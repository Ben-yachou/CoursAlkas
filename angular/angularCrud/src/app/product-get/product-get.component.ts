import { Component, OnInit } from '@angular/core';
import { ProductService } from '../product.service';
import { Product } from '../Product';

@Component({
  selector: 'app-product-get',
  templateUrl: './product-get.component.html',
  styleUrls: ['./product-get.component.css']
})
export class ProductGetComponent implements OnInit {

  products: Product[];

  constructor(private productService: ProductService) { }

  ngOnInit() {
    this.getProducts();
  }

  getProducts(): void{
    this.productService.getProducts().subscribe(
      data => this.products = data
    );
  }

  //deleteProduct prend deux paramètres : 
  //l'id du product nécessaire pour la requête au service
  //le product lui même nécessaire pour actualiser la liste locale des products
  deleteProduct(id: string, product: Product): void{
    this.productService.deleteProduct(id).subscribe(
      //une fois le produit bien supprimé du côté serveur
      //on met a jour la liste this.products en la remplaçant par une liste
      //dans laquelle le product supprimé n'existe plus
      () => this.products = this.products.filter(p => p !== product)
    );
  }
}
