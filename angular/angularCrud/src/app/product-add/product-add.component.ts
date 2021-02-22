import { Component, OnInit } from "@angular/core";
import { ProductService } from "../product.service";
import { Router } from "@angular/router";
import { FormBuilder, FormGroup, Validators } from "@angular/forms";

@Component({
  selector: "app-product-add",
  templateUrl: "./product-add.component.html",
  styleUrls: ["./product-add.component.css"]
})
export class ProductAddComponent implements OnInit {
  constructor(
    private fb: FormBuilder,
    private productService: ProductService,
    private router: Router
  ) {}

  addForm: FormGroup;
  ngOnInit() {
    this.initForm();
  }

  initForm() {
    //on crée un groupe de formulaire et on attribue
    //a chaque champ du formulaire une forme de validation
    //Validators.required rend le champ indispensable (requis)
    //Validators.min(number) permet de rendre une valeur minimum requise
    this.addForm = this.fb.group({
      productName: ["", Validators.required],
      productDescription: ["", Validators.required],
      productPrice: [
        "",
        //on utilise Validators.compose() quand on veut utiliser plusieurs 
        //type de validation sur un même champ
        Validators.compose([Validators.required, Validators.min(0)])
      ]
    });
  }

  addProduct(name: string, description: string, price: string) {
    //On constitue un objet Product a partir des paramètres de addProduct
    this.productService.addProduct(name, description, +price).subscribe(
      //on demande une fois le produit ajouté de nous envoyer vers la page products
      () => this.router.navigateByUrl("/products")
    );
  }
}
