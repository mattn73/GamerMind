<?php

namespace GM\UserBundle\DataFixtures\ORM;


use GM\UserBundle\Entity\User;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Doctrine\Common\DataFixtures\AbstractFixture;

class LoadUser extends AbstractFixture implements FixtureInterface, ContainerAwareInterface

{
  public function load(ObjectManager $manager)
  {
  
    

    $userManager = $this->container->get('fos_user.user_manager');

        // Create our user and set details
        $user = $userManager->createUser();
        $user->setUsername('username');
        $user->setEmail('email@domain.com');
        $user->setPlainPassword('password');
        //$user->setPassword('3NCRYPT3D-V3R51ON');
        $user->setEnabled(true);
        $user->setRoles(array('ROLE_ADMIN'));

        // Update the user
        $userManager->updateUser($user, true);
        $manager->persist($user);
        $manager->flush();

        // Create a reference for this user.
        $this->addReference('user', $user);

      }

      public function setContainer(ContainerInterface $container = null)
      {
          $this->container = $container;
      }
  }
 