import { Injectable } from '@angular/core';

@Injectable({
  providedIn: 'root'
})
export class MessageService {

  private messages: string[] = [];

  //ajoute un message dans le tableau messages
  add(message: string): void{
    this.messages.push(message);
  }

  clear(){
    this.messages = [];
  }

  get(): string[]{
    return this.messages;
  }
}
