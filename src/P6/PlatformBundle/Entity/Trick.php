<?php

namespace P6\PlatformBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Trick
 *
 * @ORM\Table(name="trick")
 * @ORM\Entity(repositoryClass="P6\PlatformBundle\Repository\TrickRepository")
 * @ORM\HasLifecycleCallbacks()
 */
class Trick
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
     * @Assert\NotBlank(message="Le champ ne doit pas être vide")
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="text")
     * @Assert\NotBlank(message="Le champ ne doit pas être vide")
     * @Assert\Type(type="string", message="La description de la figure doit être de type {{ type }}.")
     */
    private $description;

    /**
     * @var
     *
     * @ORM\ManyToMany(targetEntity="P6\PlatformBundle\Entity\Category", inversedBy="trick")
     * @ORM\JoinTable(name="tricks_categories")
     * @Assert\Valid()
     */
    private $category;

    /**
     * @var ArrayCollection
     *
     * @ORM\OneToMany(targetEntity="P6\PlatformBundle\Entity\Image", mappedBy="trick", cascade={"persist", "remove"})
     *
     */
    private $images;

    /**
     * @var ArrayCollection
     *
     * @ORM\OneToMany(targetEntity="P6\PlatformBundle\Entity\Video", mappedBy="trick", cascade={"persist", "remove"})
     *
     */
    private $videos;

    /**
     * @ORM\OneToMany(targetEntity="P6\PlatformBundle\Entity\Message", mappedBy="trick", cascade={"remove"})
     */
    private $message;





        public function __construct()
    {
        $this->category = new ArrayCollection();
        $this->images = new ArrayCollection();
        $this->videos = new ArrayCollection();
        $this->message = new ArrayCollection();
    }
    /**
     * @return array() $category
     */
    public function getCategory()
    {
        return $this->category;
    }

    /**
     * @param Category $category
     */
    public function addCategory(Category $category)
    {
        $this->category[] = $category;
    }

    /**
     * @param Category $category
     */
    public function removeCategory(Category $category)
    {
       $this->categories->removeElement($category);
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
     * @return Trick
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

    /**
     * Set description
     *
     * @param string $description
     *
     * @return Trick
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Add image
     *
     * @param \P6\PlatformBundle\Entity\Image $image
     *
     * @return Trick
     */
    public function addImage(\P6\PlatformBundle\Entity\Image $image)
    {
        $this->images[] = $image;

        return $this;
    }

    /**
     * Remove image
     *
     * @param \P6\PlatformBundle\Entity\Image $image
     */
    public function removeImage(\P6\PlatformBundle\Entity\Image $image)
    {
        $this->images->removeElement($image);
    }

    /**
     * Get images
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getImages()
    {
        return $this->images;
    }

    /**
     * @return mixed
     */
    public function getMessage()
    {
        return $this->message;
    }

    /**
     * Add Video
     *
     * @param \P6\PlatformBundle\Entity\Video $video
     *
     * @return Trick
     */
    public function addVideo(Video $video)
    {
        $this->videos[] = $video;

        return $this;
    }

    /**
     * Remove video
     *
     * @param \P6\PlatformBundle\Entity\Video $video
     */
    public function removeVideo(Video $video)
    {
        $this->videos->removeElement($video);
    }

    /**
     * Get Videos
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getVideos()
    {
        return $this->videos;
    }

}
