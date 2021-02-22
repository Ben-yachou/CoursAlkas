import { Component, OnInit } from "@angular/core";
import { Hero } from "../hero";
import { HeroService } from "../hero.service";

@Component({
  selector: "app-heroes",
  templateUrl: "./heroes.component.html",
  styleUrls: ["./heroes.component.css"]
})
export class HeroesComponent implements OnInit {
  heroes: Hero[];

  constructor(private heroService: HeroService) {}

  //ngOnInit s'active juste après l'initialisation du component
  ngOnInit() {
    this.getHeroes();
  }

  //appelle le service de héros pour récupérer la liste
  //et la stocker dans la variable heroes
  getHeroes(): void {
    //on souscrit à l'observable de façon à pouvoir
    //stocker les données dans notre variable heroes 
    //une fois les données parvenues depuis le service
    this.heroService.getHeroes().subscribe( 
      data => this.heroes = data
    );
  }

  deleteHero(hero: Hero): void {
    this.heroService.deleteHero(hero).subscribe(
      //au moment de la suppression, on s'occupe de mettre à jour
      //le tableau heroes en appliquant un filtre pour ne garder
      //que les héros qui sont différents de celui qu'on a supprimé
      () => this.heroes = this.heroes.filter(h => h !== hero)
    );
  }

  addHero(name: string): void {
    //on se débarasse des espaces inutiles
    name = name.trim(); //trim() supprime les espaces avant et après une chaine de caractère
    //si le nom est vide, on arrête tout
    if (!name) { return }
    //on demande au service d'ajouter un héros sous la forme d'un objet
    //ne contenant que le nom (la base se chargera de lui ajouter un id)
    this.heroService.addHero({ name } as Hero).subscribe(
      //une fois le héros bien ajouté, on met à jour notre liste locale de héros
      hero => this.heroes.push(hero)
    );
  }


}
