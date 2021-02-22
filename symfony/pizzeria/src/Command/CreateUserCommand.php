<?php

namespace App\Command;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Exception;
use Symfony\Component\Console\Application;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class CreateUserCommand extends Command
{
    protected static $defaultName = "app:create-user";

    private $entityManager;
    private $encoder;

    public function __construct(EntityManagerInterface $entityManager, UserPasswordEncoderInterface $encoder)
    {
        //pour pouvoir utiliser nos services entityManager et passwordEncoder il faut les injecter au niveau du constructeur
        $this->entityManager = $entityManager;
        $this->encoder = $encoder;

        //il est nécessaire d'appeler le constructeur parent après avoir défini nos propriétés, voir doc
        parent::__construct();
    }

    protected function configure()
    {
        //on paramètre nos paramètres de commandes avec addArgument, ici on rajoute deux paramètres requis
        $this->addArgument('username', InputArgument::REQUIRED, 'Username of the user to create');
        $this->addArgument('password', InputArgument::REQUIRED, 'Password of the user to create');
        $this->addArgument('admin', InputArgument::OPTIONAL, 'is the user admin ?');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        //ici on se charge de l'execution de la commande, donc le code à exécuter lorsque la commande est appelée
        $output->writeln([
            'Create a new User',
            '-----------------'
        ]);

        //pour créer notre utilisateur on crée un User qu'on persist et flush
        $user = new User();
        $user->setUsername($input->getArgument('username'));
        $user->setPassword(
            $this->encoder->encodePassword(
                $user,
                $input->getArgument('password')
            )
        );

        if ($input->getArgument('admin')) {
            //en ajoutant ROLE_ADMIN dans les roles on fait essentiellement de notre utilisateur un admin
            $user->setRoles(['ROLE_ADMIN']);
        }

        $this->entityManager->persist($user);
        try {
            $this->entityManager->flush();
        } catch (Exception $e) {
            $output->writeln([
                'An error occured',
            ]);
            return Command::FAILURE;
        }

        $output->writeln([
            'User successfully created !',
        ]);

        //la commande doit renvoyer SUCCESS ou FAILURE selon si elle réussit ou pas
        return Command::SUCCESS;
    }
}
