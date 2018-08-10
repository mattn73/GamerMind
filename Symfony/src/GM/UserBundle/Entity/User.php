<?php

namespace GM\UserBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use FOS\UserBundle\Model\User as BaseUser;

/**
 * User
 *
 * @ORM\Table(name="user")
 * @ORM\Entity(repositoryClass="GM\UserBundle\Repository\UserRepository")
 */
class User extends BaseUser
{
    /**
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\OneToOne(targetEntity="GM\UserBundle\Entity\UserImage", cascade={"persist"})
     *
     */
    private $image;

    /**
     * Set image
     *
     * @param \GM\UserBundle\Entity\UserImage $image
     *
     * @return User
     */
    public function setImage(\GM\UserBundle\Entity\UserImage $image = null)
    {
        $this->image = $image;

        return $this;
    }

    /**
     * Get image
     *
     * @return \GM\UserBundle\Entity\UserImage
     */
    public function getImage()
    {
        return $this->image;
    }

    public function __toString()
    {
        return $this->getUsername();
    }
}
