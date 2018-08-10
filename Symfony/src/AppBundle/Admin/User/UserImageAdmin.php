<?php

namespace AppBundle\Admin\User;

use GM\UserBundle\Entity\UserImage;
use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Symfony\Component\Form\Extension\Core\Type\FileType;

class UserImageAdmin extends AbstractAdmin
{
    protected function configureFormFields(FormMapper $formMapper)
    {
        if($this->hasParentFieldDescription()) { // this Admin is embedded
            // $getter will be something like 'getlogoImage'
            $getter = 'get' . $this->getParentFieldDescription()->getFieldName();

            // get hold of the parent object
            $parent = $this->getParentFieldDescription()->getAdmin()->getSubject();
            if ($parent) {
                $image = $parent->$getter();
            } else {
                $image = null;
            }
        } else {
            $image = $this->getSubject();
        }

        // use $fileFieldOptions so we can add other options to the field
        $fileFieldOptions = ['required' => false];
        if ($image && ($webPath = $image->getWebPath())) {
            // add a 'help' option containing the preview's img tag
            $fileFieldOptions['help'] = '<img src="'.$webPath.'" class="admin-preview" />';
        }

        $formMapper
            ->add('file', FileType::class, [
                'required' => false,
            ])
            ->add('file', 'file', $fileFieldOptions)
            
           
        ;
    }

    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('alt');

    }

    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper->addIdentifier('alt')
            ->add('url')
            ->add('extension');

    }

    public function toString($object)
    {
        return $object instanceof UserImage
        ? $object->getName()
        : 'UserImage Post'; // shown in the breadcrumb on the create view
    }
    public function prePersist($image)
    {
        $this->manageFileUpload($image);
    }

    public function preUpdate($image)
    {
        $this->manageFileUpload($image);
    }

    private function manageFileUpload($image)
    {
        if ($image->getFile()) {
            $image->refreshUpdated();
        }
    }
}
