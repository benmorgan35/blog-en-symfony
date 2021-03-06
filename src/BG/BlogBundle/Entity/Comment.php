<?php

namespace BG\BlogBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Comment
 *
 * @ORM\Table(name="comment")
 * @ORM\Entity(repositoryClass="BG\BlogBundle\Repository\CommentRepository")
 */
class Comment
{

    /**
     * @ORM\ManyToOne(targetEntity="BG\BlogBundle\Entity\Billet", inversedBy="comments")
     * @ORM\JoinColumn(nullable=false)
     */

    private $billet;

    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date", type="datetime")
     */
    private $date;

    /**
     * @var string
     *
     * @ORM\Column(name="author", type="string", length=255)
     */
    private $author;

    /**
     * @var string
     *
     * @ORM\Column(name="content", type="string", length=255)
     */
    private $content;

    /**
     * @var int
     *
     * @ORM\Column(name="idParent", type="integer", nullable=true)
     */
    private $idParent;

    /**
     * @var int
     *
     * @ORM\Column(name="depth", type="integer", nullable=true)
     */
    private $depth;

    /**
     * @var bool
     *
     * @ORM\Column(name="isIndicated", type="boolean", nullable=true)
     */
    private $isIndicated;

    /**
     * @var bool
     *
     * @ORM\Column(name="isDeleted", type="boolean", nullable=true)
     */
    private $isDeleted;


    public function _construct()
    {
        $this->date=new \Datetime();
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
     * Set date
     *
     * @param \DateTime $date
     *
     * @return Comment
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
     * Set author
     *
     * @param string $author
     *
     * @return Comment
     */
    public function setAuthor($author)
    {
        $this->author = $author;

        return $this;
    }

    /**
     * Get author
     *
     * @return string
     */
    public function getAuthor()
    {
        return $this->author;
    }

    /**
     * Set content
     *
     * @param string $content
     *
     * @return Comment
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
     * Set idParent
     *
     * @param integer $idParent
     *
     * @return Comment
     */
    public function setIdParent($idParent)
    {
        $this->idParent = $idParent;

        return $this;
    }

    /**
     * Get idParent
     *
     * @return int
     */
    public function getIdParent()
    {
        return $this->idParent;
    }

    /**
     * Set depth
     *
     * @param integer $depth
     *
     * @return Comment
     */
    public function setDepth($depth)
    {
        $this->depth = $depth;

        return $this;
    }

    /**
     * Get depth
     *
     * @return int
     */
    public function getDepth()
    {
        return $this->depth;
    }

    /**
     * Set isIndicated
     *
     * @param boolean $isIndicated
     *
     * @return Comment
     */
    public function setIsIndicated($isIndicated)
    {
        $this->isIndicated = $isIndicated;

        return $this;
    }

    /**
     * Get isIndicated
     *
     * @return bool
     */
    public function getIsIndicated()
    {
        return $this->isIndicated;
    }

    /**
     * Set isDeleted
     *
     * @param boolean $isDeleted
     *
     * @return Comment
     */
    public function setIsDeleted($isDeleted)
    {
        $this->isDeleted = $isDeleted;

        return $this;
    }

    /**
     * Get isDeleted
     *
     * @return bool
     */
    public function getIsDeleted()
    {
        return $this->isDeleted;
    }




    /**
     * Set billet
     *
     * @param \BG\BlogBundle\Entity\Billet $billet
     *
     * @return Comment
     */
    public function setBillet(Billet $billet)
    {
        $this->billet = $billet;

        return $this;
    }

    /**
     * Get billet
     *
     * @return \BG\BlogBundle\Entity\Billet
     */
    public function getBillet()
    {
        return $this->billet;
    }
}
