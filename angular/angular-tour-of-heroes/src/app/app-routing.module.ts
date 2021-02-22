import { NgModule } from '@angular/core';
import { RouterModule, Routes } from '@angular/router';
import { HeroesComponent } from './heroes/heroes.component';
import { DashboardComponent } from './dashboard/dashboard.component';
import { HeroDetailComponent } from './hero-detail/hero-detail.component';

//nos routes permettent de lier une URL (un chemin)
//a un component particulier
//redirectTo permet de faire une redirection vers une route existante
const routes: Routes = [
  { path: '', redirectTo: 'dashboard', pathMatch: 'full'},
  { path: 'heroes', component: HeroesComponent }, 
  { path: 'dashboard', component: DashboardComponent },
  { path: 'detail/:id', component: HeroDetailComponent},
];

@NgModule({
  //permet la lecture de changements dans la barre d'adresse
  imports: [ RouterModule.forRoot(routes )],
  //permet de rendre disponible le module de routage dans l'application
  exports: [ RouterModule ]
})
export class AppRoutingModule { }
