import { Component, OnInit, ViewChild, ElementRef, Renderer2 } from '@angular/core';
import * as io from "socket.io-client";
import { CookieService } from 'ngx-cookie-service';

@Component({
  selector: 'app-chat',
  templateUrl: './chat.component.html',
  styleUrls: ['./chat.component.css']
})
export class ChatComponent implements OnInit {
  private socket;
  private messages: any[] = [];
  constructor(private renderer: Renderer2, private cookieService: CookieService) {
  }

  @ViewChild('messageInput', {"static": false}) messageInput : ElementRef;
  @ViewChild('nicknameChange', {"static": false}) nicknameInput: ElementRef;
  
  ngOnInit() {
    this.socket = io("http://localhost:3333");
    this.getUserId();
    this.updateMessages();
    this.updateTypingStatus();
    this.updateUsers();
  }

  private userId: string;
  getUserId(){
    this.socket.on("user-id", (id) => {
      //check si le cookie userId est absent
      if (!this.cookieService.check('userId')){
        //si c'est le cas on initialise le cookie
        this.cookieService.set('userId', id); 
        this.userId = id;
      } else {
        //sinon on recupère la valeur stockée
        this.userId = this.cookieService.get('userId');
        //et on l'envoie au server
      }
      this.socket.emit('user-login', this.userId);
      console.log(this.userId);
    })
  }

  updateMessages(){
    this.socket.on("message", (message) => {
      this.messages.push(message);
    })
  }

  private userTyping;
  updateTypingStatus(){
    this.socket.on("user-typing", () => {
      this.userTyping = true;
    });
  }

  private users = [];
  private connectedUsers = [];
  private disconnectedUsers = [];
  private firstTimeUpdateUser = true; 
  updateUsers(){
    
    this.socket.on("users-update", (users) => {
      this.users = users;
      //pour empêcher les mises à jour du pseudo intempestives
      if (this.firstTimeUpdateUser){
        this.renderer.setProperty(this.nicknameInput.nativeElement, 'value', this.getCurrentUser().nickname)
      }
      this.firstTimeUpdateUser = false;
      this.connectedUsers = this.users.filter( user => user.online );
      this.disconnectedUsers = this.users.filter( user => !user.online)
    })
  }

  send(message: string){
    //emission d'un event appelé message-send contenant la variable message
    this.socket.emit("message-send", message);
    this.renderer.setProperty(this.messageInput.nativeElement, "value", "")
  }

  typing(){
    this.socket.emit("user-typing");
  }

  sendNewNick(nickname: string){
    this.socket.emit("nickname-change", nickname);
  }

  getCurrentUser(){
    return this.users.find( u => u.id == this.userId)
  }
}
