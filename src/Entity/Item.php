<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ItemRepository")
 */
class Item
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @var int
     */
    private $id;

    /**
     * @ORM\Column(type="text")
     * @var string
     */
    private $question;

    /**
     * @ORM\Column(type="text")
     * @var string
     */
    private $answer;

    /**
     * @ORM\Column(type="datetime")
     * @var \DateTime
     *
     */
    private $dueAt;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Rating", mappedBy="item", cascade="persist")
     * @ORM\OrderBy({"ratedAt" = "ASC"})
     * @var ArrayCollection|Rating[]
     */
    private $ratings;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\SuperMemoRepetition", mappedBy="item", cascade="persist")
     * @ORM\OrderBy({"repeatedAt" = "DESC"})
     * @var ArrayCollection|SuperMemoRepetition[]
     */
    private $superMemoRepetitions;

    /**
     * Item constructor.
     */
    public function __construct()
    {
        $this->dueAt = new \DateTime();
        $this->ratings = new ArrayCollection();
        $this->superMemoRepetitions = new ArrayCollection();
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getQuestion(): ?string
    {
        return $this->question;
    }

    /**
     * @param string $question
     */
    public function setQuestion(string $question): void
    {
        $this->question = $question;
    }

    /**
     * @return string
     */
    public function getAnswer(): ?string
    {
        return $this->answer;
    }

    /**
     * @param string $answer
     */
    public function setAnswer(string $answer): void
    {
        $this->answer = $answer;
    }

    /**
     * @return \DateTime
     */
    public function getDueAt(): \DateTime
    {
        return $this->dueAt;
    }

    /**
     * @param \DateTime $dueAt
     */
    public function setDueAt(\DateTime $dueAt): void
    {
        $this->dueAt = $dueAt;
    }

    /**
     * @return Rating[]|ArrayCollection
     */
    public function getRatings()
    {
        return $this->ratings;
    }

    /**
     * @param Rating[]|ArrayCollection $ratings
     */
    public function setRatings($ratings): void
    {
        $this->ratings = $ratings;
    }

    /**
     * @param Rating $rating
     */
    public function addRating(Rating $rating): void
    {
        $rating->setItem($this);
        $this->ratings->add($rating);
    }

    /**
     * @return SuperMemoRepetition[]|ArrayCollection
     */
    public function getSuperMemoRepetitions()
    {
        return $this->superMemoRepetitions;
    }

    /**
     * @param SuperMemoRepetition[]|ArrayCollection $superMemoRepetitions
     */
    public function setSuperMemoRepetitions($superMemoRepetitions): void
    {
        $this->superMemoRepetitions = $superMemoRepetitions;
    }

    /**
     * @param SuperMemoRepetition
     */
    public function addSuperMemoRepetition(SuperMemoRepetition $superMemoRepetition): void {
        $superMemoRepetition->setItem($this);
        $this->superMemoRepetitions->add($superMemoRepetition);
    }

    /**
     * @return string
     */
    public function questionRevealed(): string {
        return $this->question;
    }

}
