import { Injectable } from "@angular/core";
import { InMemoryDbService } from "angular-in-memory-web-api";
import { Hero } from "./hero";

@Injectable({
  providedIn: "root"
})
export class InMemoryDataService implements InMemoryDbService {
  constructor() {}

  createDb() {
    const heroes: Hero[] = [
      { id: 11, name: "Dr Steak" },
      { id: 12, name: "Super Steak" },
      { id: 13, name: "Mr Steak" },
      { id: 14, name: "SteakHouse" },
      { id: 15, name: "Steak Tartare" },
      { id: 16, name: "Le Steak" },
      { id: 17, name: "La Steak" },
      { id: 18, name: "Mme Steak" },
      { id: 19, name: "BalanceTonSteak" },
      { id: 20, name: "Steak Origins" }
    ];
    return { heroes };
  }
}
