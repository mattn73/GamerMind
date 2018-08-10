<?php

namespace AppBundle\Admin\User;

use GM\GameBundle\Entity\User;
use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Form\Type\AdminType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class UserAdmin extends AbstractAdmin
{
    protected function configureFormFields(FormMapper $formMapper)
    {

        $formMapper

            ->with('USER', ['class' => 'col-md-12'])
            ->add('image', AdminType::class, [
                'delete' => false,
            ])
            ->add('username', TextType::class)
            ->add('email', TextType::class)
            ->add('password', TextType::class)
            ->add('enabled', 'checkbox', array('required' => false))

            ->end()

        ;

    }

    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('username')
            ->add('email');

    }

    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper->addIdentifier('username')
            ->add('email')

            ->add('enabled');
    }

    public function toString($object)
    {
        return $object instanceof User
        ? $object->getUsername()
        : 'User Post'; // shown in the breadcrumb on the create view
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
                $associationMapping['targetEntity'] === 'App\Entity\UserImage'
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
