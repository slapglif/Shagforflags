<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * StoryImages
 *
 * @ORM\Table(name="story_images")
 * @ORM\Entity(repositoryClass="App\Repository\StoryImagesRepository")
 */
class StoryImages
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
     * @ORM\Column(name="story_id", type="integer", nullable=false)
     */
    private $storyId;

    /**
     * @var string
     *
     * @ORM\Column(name="image_name", type="string", length=55, nullable=false)
     */
    private $imageName;

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

    public function getStoryId(): ?int
    {
        return $this->storyId;
    }

    public function setStoryId(int $storyId): self
    {
        $this->storyId = $storyId;

        return $this;
    }

    public function getImageName(): ?string
    {
        return $this->imageName;
    }

    public function setImageName(string $imageName): self
    {
        $this->imageName = $imageName;

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
