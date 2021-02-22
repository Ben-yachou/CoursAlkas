const app = require('express')(); //importer express
const http = require('http').createServer(app); //import d'un serveur http utilisant express
const io = require('socket.io')(http);

let users = [];

//parametrage de socketio 
io.on('connection', (socket) => {
    //dans ce contexte la socket est la connexion ouverte par le client
    //cette socket nous permet d'effectuer des opérations
    //visant uniquement une connexion et pas le serveur entier 

    //on crée un utilisateur temporaire dont l'id est généré aléatoirement
    let newId = genUserId();
    //et on envoie cet id au client 
    socket.emit('user-id', newId); 
    let userObject = { 
        "id": newId, 
        "nickname": `user${Math.floor(Math.random()*5000)}`,
        "online": true
    }
    
    //lorsque le client nous répond avec l'id de connexion
    socket.on('user-login', (id) => {
        //on cherche cet id dans notre tableau users
        let loginUser = users.find( (user) => user.id == id ); 
        //si l'user existe déjà
        if (loginUser) {
            //on remplace notre objet temporaire par celui déjà stocké
            userObject = loginUser;
        } else {
            //sinon on enregistre le nouvel utilisateur dans notre tableau
            userObject.id = id;
            users.push(userObject);
        }
        //on passe l'utilisateur en mode en ligne
        userObject.online = true;
        console.log(`user ${userObject.id} connected`);
        //et on met a jour les utilisateurs pour tout le monde
        io.emit('users-update', users);
    })

    socket.on('message-send', (message) => {
        io.emit('message', 
        {
            "user" : userObject.nickname,
            "message" : message
        }
        );
    });

    socket.on('user-typing', () => {
        //socket.broadcast cible tout le monde 
        //sauf la socket courante
        //TODO : faire quelque chose de propre ici
        //socket.broadcast.emit('user-typing');
    });

    socket.on('nickname-change', (nickname) => {
        userObject.nickname = nickname;
        io.emit('users-update', users);
    })

    socket.on('disconnect', () => {
        console.log(`user ${userObject.id} disconnected`)
        userObject.online = false;
        io.emit('users-update', users);
    })
});

function genUserId(){
    return Math.random().toString(36).substr(2, 10);
}

//execution du serveur
const port = 3333;
http.listen(port, () => {
    console.log(`server listening on port ${port}`);
});

