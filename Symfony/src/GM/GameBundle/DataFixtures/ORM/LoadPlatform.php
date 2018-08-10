<?php
// src/OC/PlatformBundle/DataFixtures/ORM/LoadSkill.php

namespace GM\GameBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use GM\GameBundle\Entity\Platform;

class LoadPlatform extends AbstractFixture implements FixtureInterface
{
    public function load(ObjectManager $manager)
    {
        // Liste des noms de compétences à ajouter
        $names = array('PS4', 'XBOX', 'PS', 'WII', 'mobile');

        $i =0;
        foreach ($names as $name) {
            // On crée la compétence
            $Platform = new Platform();
            $Platform->setName($name);
            $i++;
            // On la persiste
            $manager->persist($Platform);
            $this->addReference('platform-' . $i, $Platform);
        }

        // On déclenche l'enregistrement de toutes les compétences
        $manager->flush();
    }

    public function getOrder()
    {

        return 2;

    }
}
