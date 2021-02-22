<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use App\Entity\Article;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

class ArticleFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        for ($i=1; $i <= 10; $i++) { 
            $article = new Article();
            $article->setTitle('Article'.$i);
            $article->setContent('Lorem ipsum dolor sit amet, consectetur adipiscing elit. Proin est risus, porttitor ornare mattis eget, finibus bibendum nunc. Nullam at massa tempor, tempus arcu ut, viverra metus. Morbi vitae enim vehicula, ultricies lectus a, viverra lacus. Suspendisse pharetra finibus purus vel feugiat. Pellentesque ut orci vulputate, pellentesque nisl a, ornare metus. Curabitur non finibus lectus, eget aliquet justo. Integer in sem dapibus, rhoncus augue in, pretium leo. In ut massa molestie, vulputate nulla et, imperdiet est. Ut at nunc velit. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia Curae; Praesent eu felis nec justo tempor imperdiet quis sed justo. Morbi vel sem accumsan, interdum erat vitae, convallis urna. Fusce non lacus sollicitudin, varius urna sit amet, feugiat sem. Donec facilisis tempus rutrum. In sodales tempus urna sed rutrum. Donec porta a lacus non volutpat. ');
            $article->setImage('default.png');
            $article->setSubmitDate(new \DateTime());
            $article->setAuthor($this->getReference('user'.$i));
            //on ajoute une reference a notre article pour les commentFixtures
            $this->addReference('article'.$i, $article);
            $manager->persist($article);
        }
        $manager->flush();
    }

    public function getDependencies()
    {
        return [UserFixtures::class];
    }
}
