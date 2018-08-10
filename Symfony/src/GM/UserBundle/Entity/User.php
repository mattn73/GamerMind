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
     * @ORM\OneToMany(targetEntity="GM\GameBundle\Entity\Comment", mappedBy="user", cascade={"remove"})
     */
    private $comments;

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

    /**
     * Add comment
     *
     * @param \GM\GameBundle\Entity\Comment $comment
     *
     * @return User
     */
    public function addComment(\GM\GameBundle\Entity\Comment $comment)
    {
        $this->Comments[] = $comment;

        return $this;
    }

    /**
     * Remove comment
     *
     * @param \GM\GameBundle\Entity\Comment $comment
     */
    public function removeComment(\GM\GameBundle\Entity\Comment $comment)
    {
        $this->Comments->removeElement($comment);
    }

    /**
     * Get comments
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getComments()
    {
        return $this->Comments;
    }
}
