<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * StoryVotings
 *
 * @ORM\Table(name="story_votings")
 * @ORM\Entity(repositoryClass="App\Repository\StoryVotingsRepository")
 */
class StoryVotings
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var int
     *
     * @ORM\Column(name="user_id", type="integer", nullable=false)
     */
    private $userId;

    /**
     * @var int
     *
     * @ORM\Column(name="story_id", type="integer", nullable=false)
     */
    private $storyId;

    /**
     * @var string
     *
     * @ORM\Column(name="vote", type="string", length=1, nullable=false)
     */
    private $vote;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="created", type="datetime", nullable=false, options={"default"="CURRENT_TIMESTAMP"})
     */
    private $created;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUserId(): ?int
    {
        return $this->userId;
    }

    public function setUserId(int $userId): self
    {
        $this->userId = $userId;

        return $this;
    }

    public function getStoryId(): ?int
    {
        return $this->storyId;
    }

    public function setStoryId(int $storyId): self
    {
        $this->storyId = $storyId;

        return $this;
    }

    public function getVote(): ?string
    {
        return $this->vote;
    }

    public function setVote(string $vote): self
    {
        $this->vote = $vote;

        return $this;
    }

    public function getCreated(): ?\DateTimeInterface
    {
        return $this->created;
    }

    public function setCreated(\DateTimeInterface $created): self
    {
        $this->created = $created;

        return $this;
    }


}
