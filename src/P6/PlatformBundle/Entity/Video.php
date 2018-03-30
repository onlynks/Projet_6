<?php

namespace P6\PlatformBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Video
 *
 * @ORM\Table(name="video")
 * @ORM\Entity(repositoryClass="P6\PlatformBundle\Repository\VideoRepository")
 */
class Video
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
     * @var int
     *
     * @ORM\Column(name="url", type="string", length=255)     *
     * @Assert\Regex(
     *     pattern="#^(http|https)://(www.youtube.com)/#",
     *     match=true,
     *     message="L'url doit correspondre à l'url d'une vidéo Youtube"
     * )
     */
    private $url;

    /**
     * @var \stdClass
     *
     * @ORM\ManyToOne(targetEntity="Trick", inversedBy="videos")
     */
    private $trick;


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
     * Set url
     *
     * @param integer $url
     *
     * @return Video
     */
    public function setUrl($url)
    {
        $this->url = $url;

        return $this;
    }

    /**
     * Get url
     *
     * @return int
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * Set trick
     *
     * @param \stdClass $trick
     *
     * @return Video
     */
    public function setTrick($trick)
    {
        $this->trick = $trick;

        return $this;
    }

    /**
     * Get trick
     *
     * @return \stdClass
     */
    public function getTrick()
    {
        return $this->trick;
    }
}

