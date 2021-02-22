from django.urls import path 
from . import views 

#définition d'un espace de nom "app_name" pour les urls de notre application polls
#de façon à pouvoir cibler les paths sans ambiguité 
app_name = "polls"
urlpatterns = [
    #/polls/
    path('', views.index, name="index"),
    #/polls/2/
    path('<int:question_id>', views.detail, name="detail"),
    #/polls/2/results/
    path('<int:question_id>/results/', views.results, name="results"),
    #/polls/2/vote/
    path('<int:question_id>/vote/', views.vote, name="vote"),
    
]