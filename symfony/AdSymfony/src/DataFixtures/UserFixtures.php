<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use App\Entity\User;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserFixtures extends Fixture
{

    private $passwordEncoder;

    public function __construct(UserPasswordEncoderInterface $passwordEncoder)
    {
        $this->passwordEncoder = $passwordEncoder;
    }

    public function load(ObjectManager $manager)
    {
        // $product = new Product();
        // $manager->persist($product);

        $user = new User();
        $user->setUsername('Test1');
        $user->setPassword(
            $this->passwordEncoder->encodePassword($user, 'mdp1')
        );
        $manager->persist($user);

        $user2 = new User();
        $user2->setUsername('Test2');
        $user2->setPassword(
            $this->passwordEncoder->encodePassword($user2, 'mdp2')
        );
        $manager->persist($user2);

        $admin = new User();
        $admin->setUsername('Admin');
        $admin->setPassword(
            $this->passwordEncoder->encodePassword($admin, 'mdp_admin')
        );
        //le ROLE_ADMIN désigne cet utilisateur comme admin
        $admin->setRoles(['ROLE_ADMIN']);
        $manager->persist($admin);

        $manager->flush();
    }
}
