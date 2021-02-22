import { Injectable } from '@angular/core';
import * as io from 'socket.io-client';
import { Observable } from 'rxjs';

@Injectable({
  providedIn: 'root'
})
export class ColorsService {

  private url = "http://localhost:3333";
  
  private socket; 

  constructor() { 
    this.socket = io(this.url); 
  }

  getPalette(): Observable<any>{
    return Observable.create(observer => {
      this.socket.on("palette", palette => {
        observer.next(palette);
      })
    })
  }

  getImage(): Observable<any>{
    return Observable.create(observer => {
      this.socket.on("image", data => {
        observer.next(data);
      })
    })
  }
}
