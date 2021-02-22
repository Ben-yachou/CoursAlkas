# Décalage horaire UTC

A partir d'un formulaire indiquant le fuseau horaire UTC demandé "n",
renvoyer l'heure d'aujourd'hui décalée de "n".

ex : Si on est en utc+1, en entrant "2", on renvoie le temps utc+3.

Pour générer l'heure actuelle du serveur, on utilise la fonction `time()`.
Attention, `time()` renvoie l'heure en secondes écoulées depuis le 1er janvier 1970 00:00:00 GMT.
