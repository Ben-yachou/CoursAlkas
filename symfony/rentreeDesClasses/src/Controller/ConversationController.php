<?php

namespace App\Controller;

use App\Entity\Conversation;
use App\Entity\Message;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Routing\Annotation\Route;

class ConversationController extends AbstractController
{
    /**
     * @Route("/conversation/{id}", name="conversation", 
     * requirements= {
     *  "id" = "\d+"
     * })
     */
    public function index(int $id)
    {
        $conversation = $this->getDoctrine()->getRepository(Conversation::class)->find($id);
        
        if ($conversation) {
            //stops other users from partaking in private conversation
            if (
                $this->getUser() != $conversation->getUserA() &&
                $this->getUser() != $conversation->getUserB()
            ) {
                return $this->redirectToRoute('user_panel');
            }
        } else {
            return $this->redirectToRoute('user_panel');
        }

        $interlocutor = $conversation->getUserB();

        $messages = $this->getDoctrine()->getRepository(Message::class)->findFromConversation($id);

        $form = $this->createFormBuilder()
        ->setAction($this->generateUrl('message_add'))
        ->add('content', TextareaType::class, [
            'label' => "Votre message"
        ])
        ->add('submit', SubmitType::class, [
            'label' => 'Envoyer'
        ] )
        ->add('conversation', HiddenType::class, [
            'data' => $conversation->getId()
        ])
        ->getForm();

        return $this->render('conversation/index.html.twig', [
            'conversation' => $conversation,
            'messages' => $messages,
            'form' => $form->createView(),
            'interlocutor' => $interlocutor
        ]);
    }
}
