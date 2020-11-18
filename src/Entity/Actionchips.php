<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Actionchips
 *
 * @ORM\Table(name="actionchips")
 * @ORM\Entity(repositoryClass="App\Repository\ActionchipsRepository")
 */
class Actionchips
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
     * @ORM\Column(name="partner_id", type="integer", nullable=false)
     */
    private $partnerId;

    /**
     * @var string
     *
     * @ORM\Column(name="chip", type="string", length=55, nullable=false)
     */
    private $chip;

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

    public function getPartnerId(): ?int
    {
        return $this->partnerId;
    }

    public function setPartnerId(int $partnerId): self
    {
        $this->partnerId = $partnerId;

        return $this;
    }

    public function getChip(): ?string
    {
        return $this->chip;
    }

    public function setChip(string $chip): self
    {
        $this->chip = $chip;

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
