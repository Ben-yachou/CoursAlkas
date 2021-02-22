from django.shortcuts import get_object_or_404, render
from django.http import HttpResponse, HttpResponseRedirect
from django.urls import reverse

from .models import Question, Choice
# Create your views here.

def index(request):
    #récupère les 3 dernières questions triées par date 
    latest_questions = Question.objects.order_by('-date_published')[:3]
    return render(request, 'polls/index.html', { 'question_list' : latest_questions })

def detail(request, question_id):
    #récupère la question dont l'id correspond au paramètre
    #get_object_or_404 est un raccourci permettant d'envoyer une erreur 404 si jamais l'objet
    #n'a pas été trouvé en base
    question = get_object_or_404(Question, id=question_id)
    return render(request, 'polls/detail.html', {'question' : question})

def results(request, question_id):
    question = get_object_or_404(Question, id=question_id)
    return render(request, 'polls/results.html', {'question': question})

def vote(request, question_id):
    question = get_object_or_404(Question, id=question_id)
    try:
        choice = question.choice_set.get(id=request.POST['choice'])
    #le mot clé except permet de traiter une exception
    #l'exception est de type KeyError (erreur de clé)
    #et le message d'exception sera celui de Choice.DoesNotExist explicitant qu'une entité Choice
    #n'existe pas
    except (KeyError, Choice.DoesNotExist):
        return render(request, 'polls/detail.html', {
            'question': question,
            'error_message': "Erreur survenue, veuillez réessayer"
        })
    #else définit le comportement à suivre si tout se passe bien 
    #autrement dit: incrémenter le nombre de votes du choix selectionné 
    else:
        choice.votes += 1
        choice.save()
        return HttpResponseRedirect(redirect_to=reverse('polls:results', args=[question.id]))
        
