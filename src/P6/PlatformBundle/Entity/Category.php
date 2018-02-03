<?php

namespace P6\PlatformBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Category
 *
 * @ORM\Table(name="category")
 * @ORM\Entity(repositoryClass="P6\PlatformBundle\Repository\CategoryRepository")
 */
class Category
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255, unique=true)
     */
    private $name;

    /**
     * @var
     *
     * @ORM\ManyToMany(targetEntity="P6\PlatformBundle\Entity\Trick", mappedBy="category")
     */
    private $trick;

    public function __construct()
    {
        $this->$trick = new ArrayCollection();
    }
    /**
     * @return array() $trick
     */
    public function getTrick()
    {
        return $this->trick;
    }

    /**
     * @param Trick $trick
     */
    public function addTrick(Trick $trick)
    {
        $this->trick[] = $trick;
    }

    /**
     * @param Trick $trick
     */
    public function removeCategory(Trick $trick)
    {
        $this->trick->removeElement($trick);
    }

    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set name
     *
     * @param string $name
     *
     * @return Category
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }
}

