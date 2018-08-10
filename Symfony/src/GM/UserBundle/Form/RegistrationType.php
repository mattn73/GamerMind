<?php

namespace GM\UserBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use GM\UserBundle\Form\ImageType;
use FOS\UserBundle\Form\Type\RegistrationFormType as BaseRegistrationFormType;

class RegistrationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        // Arbitrairement, on récupère toutes les catégories qui commencent par "D"
        $pattern = 'D%';

        $builder
            ->add('image', ImageType::class)
          
        ;

    }

    public function getParent()
    {
      return BaseRegistrationFormType::class;
    }
}
