<?php

namespace P6\PlatformBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Message
 *
 * @ORM\Table(name="message")
 * @ORM\Entity(repositoryClass="P6\PlatformBundle\Repository\MessageRepository")
 */
class Message
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
     * @ORM\Column(name="content", type="text")
     */
    private $content;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date", type="datetimetz")
     */
    private $date;

    /**
     * @var Trick $trick
     *
     * @ORM\ManyToOne(targetEntity="P6\PlatformBundle\Entity\Trick")
     */
    private $trick;

    /**
     * @var Member $member
     *
     * @ORM\ManyToOne(targetEntity="P6\PlatformBundle\Entity\Member")
     */
    private $member;

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
     * Set content
     *
     * @param string $content
     *
     * @return Message
     */
    public function setContent($content)
    {
        $this->content = $content;

        return $this;
    }

    /**
     * Get content
     *
     * @return string
     */
    public function getContent()
    {
        return $this->content;
    }

    /**
     * Set date
     *
     * @param \DateTime $date
     *
     * @return Message
     */
    public function setDate($date)
    {
        $this->date = $date;

        return $this;
    }

    /**
     * Get date
     *
     * @return \DateTime
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * Set trick
     *
     * @param \P6\PlatformBundle\Entity\Trick $trick
     *
     * @return Message
     */
    public function setTrick(\P6\PlatformBundle\Entity\Trick $trick = null)
    {
        $this->trick = $trick;

        return $this;
    }

    /**
     * Get trick
     *
     * @return \P6\PlatformBundle\Entity\Trick
     */
    public function getTrick()
    {
        return $this->trick;
    }

    /**
     * Set member
     *
     * @param \P6\PlatformBundle\Entity\Member $member
     *
     * @return Message
     */
    public function setMember(\P6\PlatformBundle\Entity\Member $member = null)
    {
        $this->member = $member;

        return $this;
    }

    /**
     * Get member
     *
     * @return \P6\PlatformBundle\Entity\Member
     */
    public function getMember()
    {
        return $this->member;
    }
}
