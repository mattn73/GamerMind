<?php

namespace AppBundle\Admin\Game;

use GM\GameBundle\Entity\Game;
use GM\GameBundle\Entity\Platform;
use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Form\Type\AdminType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

//use Symfony\Component\Form\Extension\Core\Type\ImageType;

class GameAdmin extends AbstractAdmin
{
    protected function configureFormFields(FormMapper $formMapper)
    {

        // $advert = $this->getSubject();

        // $fileImageOptions = array('required' => true, 'label' => 'Logo (image files only, max file size 2Mb)');

        // if ($advert && ($logoWebPath = $advert->getImage())) {

        //     $path = $logoWebPath->getWebPath();
        //     $fileImageOptions['help'] = '<img src="' . $path . '" height="50"/>';
        //     $fileImageOptions['required'] = false;
        // }

        $formMapper

            ->with('General', ['class' => 'col-md-12'])
            ->add('name', TextType::class)
            ->add('description', TextareaType::class)
            ->end()
            ->with('Image', ['class' => 'col-md-12'])

            ->add('image', AdminType::class, [
                'delete' => false,
            ])
            ->end()

            ->with('Details', ['class' => 'col-md-12'])
            ->add('price', TextType::class)
            ->add('releaseDate', DateType::class)
            ->add('rating', NumberType::class)
            ->add('platforms', EntityType::class, [
                'class' => Platform::class,
                'choice_label' => 'name',
                'multiple' => true,
            ])
            ->add('categories', 'sonata_type_collection', array(), array(
                'by_reference' => false,
                'edit' => 'inline',
                'inline' => 'table',
                'sortable' => 'position',
                'required' => false,
            ))
            ->end()

        ;

    }

    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper->add('name')
            ->add('releaseDate')
            ->add('platforms')
            ->add('categories')
            ->add('image.alt')
            ->add('description')
            ->add('price')
            ->add('rating')
        ;

    }

    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper->addIdentifier('name')

            ->add('rating')
            ->add('categories')
            ->add('image.alt');
    }

    public function toString($object)
    {
        return $object instanceof Game
        ? $object->getName()
        : 'Game Post'; // shown in the breadcrumb on the create view
    }

    public function prePersist($page)
    {
        $this->manageEmbeddedImageAdmins($page);
    }

    public function preUpdate($page)
    {
        $this->manageEmbeddedImageAdmins($page);
    }

    private function manageEmbeddedImageAdmins($page)
    {
        // Cycle through each field
        foreach ($this->getFormFieldDescriptions() as $fieldName => $fieldDescription) {
            // detect embedded Admins that manage Images
            if ($fieldDescription->getType() === 'sonata_type_admin' &&
                ($associationMapping = $fieldDescription->getAssociationMapping()) &&
                $associationMapping['targetEntity'] === 'App\Entity\Image'
            ) {
                $getter = 'get' . $fieldName;
                $setter = 'set' . $fieldName;

                /** @var Image $image */
                $image = $page->$getter();

                if ($image) {
                    if ($image->getFile()) {
                        // update the Image to trigger file management
                        $image->refreshUpdated();
                    } elseif (!$image->getFile() && !$image->getFilename()) {
                        // prevent Sf/Sonata trying to create and persist an empty Image
                        $page->$setter(null);
                    }
                }
            }
        }
    }

}
