<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Partners
 *
 * @ORM\Table(name="partners")
 * @ORM\Entity(repositoryClass="App\Repository\PartnersRepository")
 */
class Partners
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
     * @ORM\Column(name="name", type="string", length=55, nullable=false)
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="country", type="string", length=55, nullable=false)
     */
    private $country;

    /**
     * @var string
     *
     * @ORM\Column(name="gender", type="string", length=25, nullable=false)
     */
    private $gender;

    /**
     * @var string
     *
     * @ORM\Column(name="ages", type="string", length=25, nullable=false)
     */
    private $ages;

    /**
     * @var string
     *
     * @ORM\Column(name="shape", type="string", length=25, nullable=false)
     */
    private $shape;

    /**
     * @var string
     *
     * @ORM\Column(name="birthcontrol", type="string", length=25, nullable=false)
     */
    private $birthcontrol;

    /**
     * @var string
     *
     * @ORM\Column(name="met", type="string", length=25, nullable=false)
     */
    private $met;

    /**
     * @var string
     *
     * @ORM\Column(name="sexual_orientation", type="string", length=25, nullable=false)
     */
    private $sexualOrientation;

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

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getCountry(): ?string
    {
        return $this->country;
    }

    public function setCountry(string $country): self
    {
        $this->country = $country;

        return $this;
    }

    public function getGender(): ?string
    {
        return $this->gender;
    }

    public function setGender(string $gender): self
    {
        $this->gender = $gender;

        return $this;
    }

    public function getAges(): ?string
    {
        return $this->ages;
    }

    public function setAges(string $ages): self
    {
        $this->ages = $ages;

        return $this;
    }

    public function getShape(): ?string
    {
        return $this->shape;
    }

    public function setShape(string $shape): self
    {
        $this->shape = $shape;

        return $this;
    }

    public function getBirthcontrol(): ?string
    {
        return $this->birthcontrol;
    }

    public function setBirthcontrol(string $birthcontrol): self
    {
        $this->birthcontrol = $birthcontrol;

        return $this;
    }

    public function getMet(): ?string
    {
        return $this->met;
    }

    public function setMet(string $met): self
    {
        $this->met = $met;

        return $this;
    }

    public function getSexualOrientation(): ?string
    {
        return $this->sexualOrientation;
    }

    public function setSexualOrientation(string $sexualOrientation): self
    {
        $this->sexualOrientation = $sexualOrientation;

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
