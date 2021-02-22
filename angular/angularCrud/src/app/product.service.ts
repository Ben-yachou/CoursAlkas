import { Injectable } from "@angular/core";
import { HttpClient, HttpHeaders } from "@angular/common/http";
import { Product } from "./Product";
import { tap } from "rxjs/operators";
import { Observable } from "rxjs";

const httpOptions = {
  headers: new HttpHeaders({ "Content-Type": "application/json" })
};

@Injectable({
  providedIn: "root"
})
export class ProductService {
  //on prépare notre URL d'api
  private apiUrl = "http://localhost:4000/products";

  constructor(private http: HttpClient) {}

  addProduct(
    name: string,
    description: string,
    price: number
  ): Observable<Product> {
    //On constitue un objet Product a partir des paramètres de addProduct
    const product: Product = {
      productName: name,
      productDescription: description,
      productPrice: price
    };

    //on envoie via HTTP POST notre objet sous forme de json au serveur d'API
    return (
      this.http
        .post<Product>(`${this.apiUrl}/add`, product, httpOptions)
        //on puise dans la réponse du serveur pour savoir si tout s'est bien passé
        //et on affiche un message dans la console si c'est le cas
        .pipe(tap(() => console.log("Product added successfully")))
    );
  }

  getProducts(): Observable<Product[]> {
    //on prépare et envoie une requête http GET a notre API
    return this.http
      .get<Product[]>(this.apiUrl)
      .pipe(tap(() => console.log("Products fetched")));
  }

  editProduct(id: string): Observable<Product> {
    return this.http
      .get<Product>(`${this.apiUrl}/edit/${id}`)
      .pipe(tap(() => console.log(`Product ${id} fetched`)));
  }

  updateProduct(
    id: string,
    name: string,
    description: string,
    price: number
  ): Observable<Product> {
    const product: Product = {
      productName: name,
      productDescription: description,
      productPrice: price
    };

    return this.http
      .put<Product>(`${this.apiUrl}/update/${id}`, product, httpOptions)
      .pipe(tap(() => console.log(`Product ${id} updated`)));
  }

  deleteProduct(id: string): Observable<any> {
    return this.http
      .delete<any>(`${this.apiUrl}/delete/${id}`)
      .pipe(tap(() => console.log(`Product ${id} deleted`)));
  }
}
