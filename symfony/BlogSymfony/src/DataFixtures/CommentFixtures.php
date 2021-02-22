<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use App\Entity\Comment;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

class CommentFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        for ($i=1; $i <= 10; $i++) { 
            $comment = new Comment();
            $comment->setContent('Djzaojdoajdoajoidjza');
            $comment->setSubmitDate(new \DateTime());
            $comment->setAuthor($this->getReference('user'.$i));
            $comment->setArticle($this->getReference('article'.$i));

            $manager->persist($comment);
        }
        $manager->flush();
    }

    public function getDependencies()
    {
        return [UserFixtures::class, ArticleFixtures::class];
    }
}
