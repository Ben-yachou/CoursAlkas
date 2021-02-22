import { Component, OnInit, Input } from "@angular/core";
import { Hero } from "../hero";
import { ActivatedRoute } from "@angular/router";
import { HeroService } from "../hero.service";
import { Location } from '@angular/common';

@Component({
  selector: "app-hero-detail",
  templateUrl: "./hero-detail.component.html",
  styleUrls: ["./hero-detail.component.css"]
})
export class HeroDetailComponent implements OnInit {
  hero: Hero;

  constructor(
    private route: ActivatedRoute,
    private location: Location,
    private heroService: HeroService
  ) {}

  ngOnInit() {
    //permet de récuperer le paramètre :id dans la route
    //details/:id
    const id = +this.route.snapshot.paramMap.get('id');
    this.getHero(id);
  }

  getHero(id: number): void {
    //on souscrit a l'observable renvoyé par getHero
    //lorsque le héros sera reçu on le stockera dans this.hero
    this.heroService.getHero(id).subscribe(
      data => this.hero = data
    )
  }

  goBack(): void {
    this.location.back();
  }

  save(): void {
    //on appelle le service pour lui demander d'enregistrer les changements
    //une fois le changement enregistré la fonction goBack()
    //nous fera revenir en arrière
    this.heroService.updateHero(this.hero).subscribe(
      () => this.goBack()
    );
  }
}
