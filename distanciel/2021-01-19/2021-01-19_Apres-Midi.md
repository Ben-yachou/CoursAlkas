# Après Midi du 19 Janvier 2021

## Utilisateurs et Security

[Voir la documentation officielle.](https://symfony.com/doc/current/security.html)

Notre application doit se charger de gérer des utilisateurs et leur connexion à la plateforme, et en ce faisant accéder à des fonctionnalités supplémentaires (par exemple poster un article, l'éditer, le supprimer...).

Pour ça, il faut comprendre ce qu'est l'extension Security dans symfony.

### Le module Security

Tout comme le `Router` se met entre les requêtes entrantes et le reste de l'application pour les diriger vers le bon controller, `Security` se place entre la requête routée et le controller et agit comme un filet supplémentaire à traverser.

![schema security 1](security1.png "L'ordre d'interception d'une requête")

En passant par `Security`, on obtient certaines fonctionnalités utiles; comme par exemple une gestion d'autorisation d'accès à certaines parties du site, l'utilisation de roles pour les utilisateurs octroyant des droits, etc.

Pour que notre gestion des utilisateurs soit compatible avec `Security` et donc profite de ces fonctionnalités, il faut implémenter certaines interfaces, et consigner certaines options dans la configuration de `Security`.

Heureusement, en utilisant le `maker-bundle`, ces choses vont être faites pour nous.

### Création d'une entité `User` compatible avec `Security`

On pourrait créer notre classe `User` avec `make:entity` et la rendre compatible ensuite avec `Security`, mais on va plutôt utiliser `make:user` qui permet de créer une classe déjà compatible.

```console
php bin/console make:user
```

Certaines questions nous sont posées, on y répond, et un notre `App\Entity\User` est créé, ainsi qu'un `App\Repository\UserRepository`.

Un fichier de configuration est également altéré, `config/packages/security.yaml`, il s'agit du fichier dictant son comportement au module `Security`.

Différentes choses y sont consignées, comme le paramétrage de _firewalls_ (_pare-feu_), qui sont un ensemble de règle permettant de cloisonner certaines parties de notre site sous conditions.

Mais ce qui y a été ajouté ce sont les mentions d'un `user_provider`.

#### Qu'est ce que le `user_provider` et d'où vient-il ?

Le _user provider_ (_fournisseur d'utilisateurs_) est une classe permettant, à chaque fois que la requête est routée, le chargement de l'objet `User` à partir de la session.

Notre provider par défaut se charge de vérifier si l'utilisateur n'est pas daté en faisant une requête en base de données (avec l'aide de Doctrine).

Le provider se charge également de désauthentifier l'utilisateur si celui ci se déconnecte.

On peut en créer des personnalisés, mais celui par défaut nous convient très bien.

Notre `make:user` nous permet d'utiliser ce provider pour _fournir_ nos entités `User` grâce aux paramètres rajoutés dans `config/packages/security.yaml`.

### Inscription d'un utilisateur

Pour inscrire un utilisateur il faut que celui ci soit enregistré dans la base, et son mot de passe haché.

Pour ce faire, on peut utiliser une autre commande :

```console
php bin/console make:registration-form
```

Cette commande permettra la création d'un formulaire d'inscription et d'un controller capable de le servir.

Rien de bien nouveau à ce niveau, si ce n'est l'utilisation d'un encodeur de mot de passe.

En effet, dans le `RegistrationController` créé par notre `maker-bundle`, on trouve la mention d'un `UserPasswordEncoderInterface`.

```php
/**
 * @Route("/register", name="app_register")
 */
public function register(Request $request, UserPasswordEncoderInterface $passwordEncoder): Response
{
    $user = new User();
    $form = $this->createForm(RegistrationFormType::class, $user);
    $form->handleRequest($request);

    if ($form->isSubmitted() && $form->isValid()) {
    // encode the plain password
    $user->setPassword(
        $passwordEncoder->encodePassword(
            $user,
            $form->get('plainPassword')->getData()
            )
        );

        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($user);
        $entityManager->flush();
        // do anything else you need here, like send an email

        return $this->redirectToRoute('index');
    }

    return $this->render('registration/register.html.twig', [
        'registrationForm' => $form->createView(),
    ]);
}
```

En appelant un représentant de `UserPasswordEncoderInterface` dans les paramètres de notre méthode de controller, on demande à Symfony de nous fournir un encodeur de mot de passe valide.

Ici, il s'agit de celui par défaut.

En utilisant ensuite sa méthode `encodePassword()` cela nous permet de hacher un mot de passe utilisateur.

#### Le formulaire `RegistrationFormType`

Un autre ajout de cette commande `make:registration-form` est la création d'un formulaire, séparé cette fois, dans un fichier `src/Form/RegistrationFormType.php`.

Celui ci ressemble à notre création de formulaire classique, excepté qu'il est réutilisable dans plusieurs controllers.

Le formulaire est ensuite récupéré et utilisé dans le `RegistrationController`, comme d'habitude.

### Connexion d'un utilisateur

Pour connecter un utilisateur, la tâche est un tout petit peu plus complexe, car devant passer par un `Authenticator`.

Cependant, il n'en est pas moins facile de le réaliser à l'aide du `maker-bundle` :

```console
php bin/console make:auth

 What style of authentication do you want? [Empty authenticator]:
  [0] Empty authenticator
  [1] Login form authenticator
 > 1

 The class name of the authenticator to create (e.g. AppCustomAuthenticator):
 > LoginFormAuthenticator

 Choose a name for the controller class (e.g. SecurityController) [SecurityController]:
 >

 Do you want to generate a '/logout' URL? (yes/no) [yes]:
 >

 created: src/Security/LoginFormAuthenticator.php
 updated: config/packages/security.yaml
 created: src/Controller/SecurityController.php
 created: templates/security/login.html.twig


  Success!


 Next:
 - Customize your new authenticator.
 - Finish the redirect "TODO" in the App\Security\LoginFormAuthenticator::onAuthenticationSuccess() method.
 - Review & adapt the login template: templates/security/login.html.twig.
```

Décortiquons ensemble ce qui a été créé/modifié pour que ça fonctionne :

#### 1. Le `LoginFormAuthenticator`

L'_authenticator_ est le composant de sécurité qui se charge de vérifier les _credentials_ d'un utilisateur dans le but de le rendre disponible au niveau de l'application en tant qu'utilisateur authentifié.

Cela nous sert essentiellement à vérifier nom d'utilisateur et mot de passe, puis d'ouvrir une session et y stocker l'utilisateur pour utilisation future.

Un _authenticator_ est enregistré auprès de `Guard`, le système d'authentifications et d'autorisations de Symfony, comme devant inspecter chaque requête et se charger d'effectuer les actions qui l'incombent.
On verra que cet enregistrement auprès de `Guard` se fait dans le `security.yaml`.

Une fois l'authenticator appelé par `Guard`, ce dernier va utiliser les méthodes mises à disposition pour déterminer si l'authentification est un succès ou non.

Le fonctionnement propre de l'authenticator est (grosso modo) le suivant :

![schema authenticator 1](authenticator1.png "Les actions de l'authenticator")

1. L'authenticator vérifie si la requête le concerne. Il vérifie si la route correspond à celle qu'il doit intercepter (pour nous ce sera la route `app_login`), et vérifie si la méthode est bien `POST` (et qu'il y a donc des choses à récupérer).

    Ce paramétrage se fait au niveau de la méthode `supports` de notre `LoginFormAuthenticator` :

    ```php
    //permet de définir que la route a intercepter est nommée app_login
    public const LOGIN_ROUTE = 'app_login';

    public function supports(Request $request)
    {
        //vérifie que la route matchée soit bien celle dans la constante LOGIN_ROUTE
        return self::LOGIN_ROUTE === $request->attributes->get('_route')
            && $request->isMethod('POST'); //... et vérifie que la méthode soit POST
    }
    ```

    Si `supports` renvoie `false`, alors l'authenticator ne fait rien de plus et laisse passer la requête. Sinon, il passe à l'étape suivante.

2. L'authenticator récupère les paramètres de connexion et vérifie qu'ils soient corrects.

    Cela se fait en deux parties, d'abord récupérer les paramètres avec `getCredentials` :

    ```php
    public function getCredentials(Request $request)
    {
        $credentials = [
            'username' => $request->request->get('username'),
            'password' => $request->request->get('password'),
            'csrf_token' => $request->request->get('_csrf_token'),
        ];
        $request->getSession()->set(
            Security::LAST_USERNAME,
            $credentials['username']
        );

        return $credentials;
    }
    ```

    Puis vérifier avec `checkCredentials` :

    ```php
    public function checkCredentials($credentials, UserInterface $user)
    {
        return $this->passwordEncoder->isPasswordValid($user, $credentials['password']);
    }
    ```

3. Récupération de l'utilisateur et stockage dans la session.

    Une fois les informations de connexion validées, on peut faire appel à Doctrine qui se chargera de récupérer l'utilisateur dans la base.

    Une fois renvoyé, celui ci sera stocké dans la session grâce au `user_provider`, que `Guard` se chargera d'appeler.

4. Redirection

    Une fois l'authentification complète, on peut rediriger l'utilisateur. Soit vers la page sur laquelle il essayait de se rendre; nécessitant une connexion, soit vers une page prédéfinie (l'accueil par exemple).

    Cette action de redirection se trouve dans `onAuthenticationSuccess` :

    ```php
    public function onAuthenticationSuccess(Request $request, TokenInterface $token, string $providerKey)
    {
        //si on arrive sur la page de connexion depuis une autre page, à l'aide d'une redirection (par exemple en voulant poster un article sans être connecté), ces deux lignes permettront de renvoyer vers la page d'origine
        if ($targetPath = $this->getTargetPath($request->getSession(), $providerKey)) {
            return new RedirectResponse($targetPath);
        }

        return new RedirectResponse($this->urlGenerator->generate('index'));
    }
    ```

L'authenticator contient plus de choses, comme par exemple l'utilisation d'un `CSRF Token`, empêchant la falsification de formulaires/requêtes par un potentiel pirate. On aura l'occasion d'en reparler.

Retenons tout de même que l'authenticator n'est qu'un moyen de personnaliser le comportement de `Guard`. Cette classe et ces méthodes sont juste une ligne de conduite pour le système d'authentification déjà préparé de Symfony.

#### 2. Le fichier `security.yaml`

Deuxième visé par le changement de notre `make:auth` est le fichier de configuration de Security, trouvé dans `config/packages/security.yaml`.

Ce changement concerne l'_enregistrement_ de notre authenticator au niveau de Guard, pour que ce dernier sache qu'il faille utiliser notre `LoginFormAuthenticator`. On y trouve également une définition d'une route de déconnexion `app_logout`.

```yaml
#dans notre fichier `security.yaml` se trouvent ces quelques lignes
firewalls:
    #...
    main:
        anonymous: true
        lazy: true
        provider: app_user_provider
        guard:
            authenticators:
                - App\Security\LoginFormAuthenticator
        logout:
            path: app_logout
            # where to redirect after logout
            target: index
```

Le paramétrage de `guard` définit un nouvel `authenticator`, celui qui vient d'être créé. Guard saura donc quoi utiliser pour authentifier une requête.

Le paramètre `logout` quant à lui permet de définir le comportement de déconnexion, permettant de vider la session et déconnecter l'utilisateur.

On y définit le nom de la route (`path`), et on y définit également la cible de redirection au niveau de `target`.

#### 3. Le `SecurityController`

Presque figurant dans cette opération, le `SecurityController` joue le rôle le plus basique possible d'un controller. On y retrouve nos routes définies à l'aide d'annotations, ainsi que l'association de la route de `login` à un template contenant le formulaire (pour peu que l'on soit en méthode `GET` et que notre `LoginFormAuthenticator` n'intercepte pas tout ça).

#### 4. Le template

Simple formulaire. Pas besoin de définir d'action ou de gérer la requête avec un `Form` et `handleRequest`, étant donné que `LoginFormAuthenticator` se charge de tout si jamais une requête `POST` est envoyée sur `app_login`.

Le template peut donc se contenter de définir un formulaire HTML basique.
