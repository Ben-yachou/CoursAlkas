<?php

namespace App\Controller;

use App\Entity\Conversation;
use App\Entity\RelationRequest;
use App\Entity\User;
use App\Entity\UserRelation;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Routing\Annotation\Route;

class RelationRequestController extends AbstractController
{
    /**
     * @Route("/relation/request/{id}", name="relation_request", 
     * requirements={
     *  "id" = "\d+"
     * })
     */
    public function newRelationRequest(int $id)
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_REMEMBERED');

        $target = $this->getDoctrine()->getRepository(User::class)->find($id);
        if ($target) {
            $request = new RelationRequest();
            $request->setSender($this->getUser());
            $request->setReceiver($target);
            $request->setDateSent(new \DateTime());
            $request->setIsAccepted(false);

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($request);
            $entityManager->flush();
        } else {
            //treat error 
        }
        return new RedirectResponse($this->generateUrl('user_panel'));
    }

    /**
     * @Route("/relation/request/accept/{id}", name="accept_request", 
     * requirements={
     *  "id" = "\d+"
     * })
     */
    public function acceptRequest(int $id)
    {
        $request = $this->getDoctrine()->getRepository(RelationRequest::class)->find($id);
        if ($request) {
            $user = $this->getUser();
            if ($user == $request->getReceiver()) {
                //la requête est acceptée
                $request->setIsAccepted(true);

                //on crée la relation
                $relation = new UserRelation();
                $relation->setUserA($request->getSender());
                $relation->setUserB($request->getReceiver());

                //on crée une conversation
                $conversation = new Conversation();
                $conversation->setUserA($request->getSender());
                $conversation->setUserB($request->getReceiver());
                $conversation->setSaveMessages(true);

                $entityManager = $this->getDoctrine()->getManager();
                $entityManager->persist($relation);
                $entityManager->persist($conversation);
                $entityManager->flush();
            } else {
                //handle error
            }
        } else {
            //handle error
        }

        return new RedirectResponse($this->generateUrl('user_panel'));
    }

    /**
     * @Route("/relation/request/deny/{id}", name="deny_request", 
     * requirements={
     *  "id" = "\d+"
     * })
     */
    public function denyRequest(int $id){
        $request = $this->getDoctrine()->getRepository(RelationRequest::class)->find($id);
        if ($request){
            $user = $this->getUser();
            if ($user == $request->getReceiver()) {
                $entityManager = $this->getDoctrine()->getManager();
                $entityManager->remove($request);
                $entityManager->flush();
            } else {    
                //handle error
            }
        } else {
            //handle error
        }
        return new RedirectResponse($this->generateUrl('user_panel'));

    }
}
