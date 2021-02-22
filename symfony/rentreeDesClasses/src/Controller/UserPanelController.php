<?php

namespace App\Controller;

use App\Entity\Conversation;
use App\Entity\RelationRequest;
use App\Entity\User;
use App\Entity\UserRelation;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class UserPanelController extends AbstractController
{
    /**
     * @Route("/user/panel", name="user_panel")
     */
    public function index()
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');

        $users = $this->getDoctrine()->getRepository(User::class)->findAll();
        $userId = $this->getUser()->getId();

        //get the requests sent by the authentified user 
        $requestsSent = $this->getDoctrine()->getRepository(RelationRequest::class)->findBySender(
            $userId
        );

        $requestsReceived = $this->getDoctrine()->getRepository(RelationRequest::class)->findByReceiver(
            $userId
        );

        $relations = $this->getDoctrine()->getRepository(UserRelation::class)
            ->findByUserId($userId);

        $relationsB = $this->getDoctrine()->getRepository(UserRelation::class)
            ->findByUserBId($userId);

        $conversations = $this->getDoctrine()->getRepository(Conversation::class)
            ->findByUserId($userId);



        //filter out users that already are in relation with the current user
        $filteredUsers = [];
        foreach ($users as $user) {
            if ($user != $this->getUser()){
                $filteredUsers[] = $user;
            }
        }

        return $this->render('user_panel/index.html.twig', [
            'users' => $filteredUsers,
            'requestsSent' => $requestsSent,
            'requestsReceived' => $requestsReceived,
            'relations' => $relations,
            'relationsB' => $relationsB,
            'conversations' => $conversations
        ]);
    }
}
