import datetime #datetime est un composant de python interne, on a pas besoin de préciser le module
from django.db import models
from django.utils import timezone

#définir un model revient à définir une classe
#on utilise les fonctionalités de models pour définir les champs
#de notre entité
class Question(models.Model):
    question_text = models.CharField(max_length=200) #un charfield est l'équivalent d'un varchar
    date_published = models.DateTimeField()

    # __str__ est l'équivalent de toString() il permet au langage
    # d'avoir un moyen de décrire une entité par du texte 
    # __str__ est une méthode utilisable dans tous les objets car appartenant a la classe "mère"
    # de tous les objets en Python : "Object"
    def __str__(self):
        return self.question_text
    
    #exemple d'une méthode de classe personnalisée 
    def was_published_recently(self):
        # vérifie que la question ait été publiée dans un intervalle d'un jour
        return self.date_published >= timezone.now() - datetime.timedelta(days=1)

class Choice(models.Model):
    #pour définir une relation on définit une foreignKey
    #le premier paramètre est la classe avec laquelle établir une relation
    #le second paramètre on_delete détermine l'action suivant la suppression
    #de l'entité référencée par la clé étrangère. 
    # Cascade signifie que le choix est suppirmé également
    question = models.ForeignKey(Question, models.CASCADE) 
    choice_text = models.CharField(max_length=200)
    votes = models.IntegerField(default=0)

    def __str__(self):
        return self.choice_text
    
    