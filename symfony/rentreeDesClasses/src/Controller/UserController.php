<?php

namespace App\Controller;

use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class UserController extends AbstractController
{
    /**
     * @Route("/user/view/{id}", name="user_view", requirements={
     *  "id" = "\d+"
     * })
     */
    public function view(int $id)
    {
        $user = $this->getDoctrine()->getRepository(User::class)->find($id);

        return $this->render('user/index.html.twig', [
            'user' => $user,
        ]);
    }
}
