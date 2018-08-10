<?php

namespace GM\GameBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use GM\GameBundle\Entity\Category;

class LoadCategory extends AbstractFixture implements FixtureInterface
{

    public function load(ObjectManager $manager)
    {
        // Liste des noms de catégorie à ajouter
        $names = array(

            'Action Game',
            'RPG',
            'MMO',
            'Strategy',
        );

        $desc = array(

            'Action Game',
            'RPG GAME',
            'MMO, Game',
            'Strategy Game',

        );

        $i = 0;
        foreach ($names as $name) {

            $category = new Category();
            $category->setName($name);
            $category->setDescription($desc[$i]);
            $i++;

            $manager->persist($category);
            $this->addReference('category-' . $i, $category);
        }

        $manager->flush();
    }

    public function getOrder()
    {

        return 1;

    }
}
