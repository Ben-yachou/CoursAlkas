<?php

namespace App\Controller;

use App\Entity\Conversation;
use App\Entity\Message;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class MessageController extends AbstractController
{
    /**
     * @Route("/message/add", name="message_add", methods={"POST"})
     */
    public function addMessage(Request $request){
        $message = new Message();

        //get POST parameters
        $conversationId = $request->request->get('form')['conversation'];
        $content = $request->request->get('form')['content'];

        $conversation = $this->getDoctrine()->getRepository(Conversation::class)
        ->find($conversationId);

        //redirect if conversation not found
        if (!$conversation) {
            $this->redirectToRoute('user_panel');
        }

        //redirect if user doesn't partake conversation
        if (
            $this->getUser() != $conversation->getUserA() &&
            $this->getUser() != $conversation->getUserB()
        ) {
            return $this->redirectToRoute('user_panel');
        }

        //hydrate entity
        $message->setSender($this->getUser());
        $message->setConversation($conversation);
        $message->setContent($content);

        $message->setTime(new \DateTime());
        $message->setIsRead(false);

        $em = $this->getDoctrine()->getManager();
        $em->persist($message);
        $em->flush();

        return $this->redirectToRoute('conversation', [
            'id' => $conversation->getId()
        ]);
    }
}

