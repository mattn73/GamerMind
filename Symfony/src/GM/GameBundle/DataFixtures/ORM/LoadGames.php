<?php
// src/OC/PlatformBundle/DataFixtures/ORM/LoadCategory.php

namespace GM\GameBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use GM\GameBundle\Entity\Game;
use GM\GameBundle\Entity\Image;
use GM\GameBundle\DataFixtures\ORM\LoadCategory;
use GM\GameBundle\DataFixtures\ORM\LoadPlatform;
use Symfony\Component\Validator\Constraints\DateTime;

class LoadGames extends AbstractFixture implements DependentFixtureInterface
{
    // Dans l'argument de la méthode load, l'objet $manager est l'EntityManager
    public function load(ObjectManager $manager)
    {
        // Liste des noms de catégorie à ajouter
        $game = new Game();
        $game->setName('Assasisn');
        $game->setDescription('Alexandre');
        $game->setPrice(45);
        $game->setReleaseDate(new \DateTime('2009-02-03'));
        $game->setRating(4);



        $game1 = new Game();
        $game1->setName('Fortnite.');
        $game1->setDescription('Alexandre');
        $game1->setPrice(19);
        $game1->setReleaseDate(new \DateTime('2017-07-18'));
        $game1->setRating(5);

        $game2 = new Game();
        $game2->setName('Quake');
        $game2->setDescription('Alexandre');
        $game2->setPrice(49);
        $game2->setReleaseDate(new \DateTime('2018-01-13'));
        $game2->setRating(3);

        // Création de l'entité Image
        $image = new Image();
        $image->setUrl('/img/testImage.jpg');
        $image->setAlt('Test Image 2');
        $image->setExtension('jpg');

        // Création de l'entité Image
        $image1 = new Image();
        $image1->setUrl('/img/fortnite.jpg');
        $image1->setAlt('testImage1');
        $image1->setExtension('jpg');

        // Création de l'entité Image
        $image2 = new Image();
        $image2->setUrl('/img/testImage.jpg');
        $image2->setAlt('test Image 3');
        $image2->setExtension('jpg');

        // On lie l'image à l'annonce
        $game->setImage($image);
        $game1->setImage($image1);
        $game2->setImage($image2);

        $game->addCategory($this->getReference('category-1'));
        $game1->addCategory($this->getReference('category-2'));
        $game2->addCategory($this->getReference('category-3'));
        $game->addCategory($this->getReference('category-4'));

        $game->addPlatform($this->getReference('platform-1'));
        $game1->addPlatform($this->getReference('platform-2'));
        $game2->addPlatform($this->getReference('platform-3'));
        $game->addPlatform($this->getReference('platform-4'));
        $game1->addPlatform($this->getReference('platform-5'));

        $manager->persist($game);
        $manager->persist($game1);
        $manager->persist($game2);

        $manager->persist($image);
        $manager->persist($image1);
        $manager->persist($image2);

        $manager->flush();
    }

    public function getDependencies()
    {
        return array(
            LoadCategory::class,
            LoadPlatform::class,
        );
    }
    public function getOrder()
    {

        return 3;

    }
}
