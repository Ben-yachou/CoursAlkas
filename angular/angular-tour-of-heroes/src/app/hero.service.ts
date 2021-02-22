import { Injectable } from "@angular/core";
import { Hero } from "./hero";
import { Observable, of } from 'rxjs';
import { MessageService } from './message.service';
import { HttpClient, HttpHeaders } from '@angular/common/http';
import { catchError, tap } from 'rxjs/operators';

const httpOptions = {
  headers : new HttpHeaders({ 'Content-Type': 'application/json' })
}

@Injectable({
  providedIn: "root"
})
export class HeroService {
  //on injecte le service MessageService dans heroService
  //pour pouvoir utiliser le service de messages 
  //en appellant messageService
  constructor(private http: HttpClient, private messageService: MessageService) {}

  //url vers la web api
  private heroesUrl = 'api/heroes';

  //renvoie la liste de héros
  //on renvoie cette liste sous la forme d'un observable
  //c'est à dire un objet permettant la livraison de données
  //de façon asynchrone, en notifiant les souscripteurs à l'observable
  //lors de l'arrivée des données
  getHeroes(): Observable<Hero[]> {
    //prépare et envoie une requête http vers notre API servant les héros
    //La réponse de la requête est sous la forme de JSON
    //préciser <Hero[]> lors de l'appel de get permet que l'on
    //renvoie un Observable de Hero[]
    return this.http.get<Hero[]>(this.heroesUrl).pipe(
      //tap (puiser) permet de piocher dans la réponse de la requête HTTP
      //si et seulement si celle si s'est résolue avec succès
      //ainsi on peut utiliser tap pour effectuer des opérations en cas de succès de la requête
      // utiliser un _ en tant que paramètre de la fonction signifie qu'on ne souhaite
      //pas utiliser les données envoyées par tap 
      tap(_ => this.messageService.add('HeroService : héros récupérés'))
    );
  }

  getHero(id: number): Observable<Hero>{
    //renvoie le héros dont l'id est le même que le param id
    const url = `${this.heroesUrl}/${id}`;
    //prépare et envoie une requête http sous la forme api/heroes/id
    //permettant de récuperer un héros sous la forme de JSON
    //en précisant le type <Hero> lors de l'appel de get 
    //permet de renvoyer un Observable de Hero
    return this.http.get<Hero>(url).pipe(
      //en cas de réussite on envoie un message 
      tap(_ => this.messageService.add(`HeroService : récupéré le hero ${id}`))
    );
  }

  updateHero(hero: Hero): Observable<any>{
    return this.http.put(this.heroesUrl, hero, httpOptions).pipe(
      tap(_ => this.messageService.add(`HeroService: hero ${hero.id} mis à jour`))
    );
  }

  deleteHero(hero: Hero): Observable<Hero>{
    //envoie une requête DELETE avec comme adresse
    //api/heroes/id, l'id étant celui du héros à supprimer
    const url = `${this.heroesUrl}/${hero.id}`;
    return this.http.delete<Hero>(url, httpOptions).pipe(
      tap(_ => this.messageService.add(`HeroService: hero ${hero.id} supprimé`))
    );
  }

  addHero(hero: Hero): Observable<Hero>{
    //envoie une requête POST avec comme corps de fonction notre héros au format JSON
    //heroesURL est l'url d'api vers laquelle on fait la demande
    //hero est le héros à créer dans la base, qu'on envoie
    //httpOptions permet de dire à l'api qu'on envoie du json
    return this.http.post<Hero>(this.heroesUrl, hero, httpOptions).pipe(
      //une fois la réponse de la requête réceptionnée, on utilise le héros nouvellement créé
      //renvoyé par l'API dans notre message
      tap( (newHero: Hero) => this.messageService.add(`HeroService : hero ${newHero.id} créé`) )
    );
  }
}
