import { Component, OnInit } from "@angular/core";
import { ProductService } from "../product.service";
import { Product } from "../Product";
import { ActivatedRoute, Router } from "@angular/router";

@Component({
  selector: "app-product-edit",
  templateUrl: "./product-edit.component.html",
  styleUrls: ["./product-edit.component.css"]
})
export class ProductEditComponent implements OnInit {
  constructor(
    private productService: ProductService,
    private route: ActivatedRoute,
    private router: Router
  ) {}

  product: Product;

  ngOnInit() {
    //on récupère le paramètre id dans l'url
    const id = this.route.snapshot.paramMap.get("id");
    //et on appelle editProduct
    this.editProduct(id);
  }

  editProduct(id: string): void {
    this.productService
      .editProduct(id)
      .subscribe(data => (this.product = data));
  }

  updateProduct(id: string): void {
    this.productService.updateProduct(
      id,
      this.product.productName,
      this.product.productDescription,
      this.product.productPrice
    ).subscribe(
      () => this.router.navigateByUrl('/products')
    );
  }
}
