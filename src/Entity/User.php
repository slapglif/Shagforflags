<?php
namespace App\Entity;

use FOS\UserBundle\Model\User as BaseUser;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\UserRepository")
 * @ORM\Table(name="fos_user")
 */
class User extends BaseUser
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @var bool
     *
     * @ORM\Column(name="confirmed", type="boolean", nullable=false)
     */
    protected $confirmed = '0';

    /**
     * @var \DateTime
     * @ORM\Column(name="inserted_on", type="datetime", nullable=true)
     */
    protected $inserted_on;


    /**
     * @var string
     * @ORM\Column(name="note", type="text", nullable=true)
     */
    protected $note;

    /**
     * @var boolean
     * @ORM\Column(name="locked", type="boolean", nullable=false)
     */
    protected $locked;

    /**
     * @var string|null
     *
     * @ORM\Column(name="alias", type="string", length=255, nullable=true)
     */
    protected $alias;

    /**
     * @var string|null
     *
     * @ORM\Column(name="name", type="string", length=55, nullable=true)
     */
    protected $name;

    /**
     * @var string|null
     *
     * @ORM\Column(name="birthdate", type="string", length=25, nullable=true)
     */
    protected $birthdate;

    /**
     * @var string|null
     *
     * @ORM\Column(name="country", type="string", length=55, nullable=true)
     */
    protected $country;

    /**
     * @var string|null
     *
     * @ORM\Column(name="location", type="string", length=125, nullable=true)
     */
    protected $location;

    /**
     * @var string|null
     *
     * @ORM\Column(name="gender", type="string", length=25, nullable=true)
     */
    protected $gender;

    /**
     * @var string|null
     *
     * @ORM\Column(name="sexorient", type="string", length=25, nullable=true)
     */
    protected $sexorient;

    /**
     * @var bool
     *
     * @ORM\Column(name="profile_confirmed", type="boolean", nullable=false)
     */
    protected $profileConfirmed = '0';

    /**
     * @var string|null
     *
     * @ORM\Column(name="profile_photo", type="string", length=55, nullable=true)
     */
    private $profilePhoto;

    public function __construct()
    {
        parent::__construct();
        // your own logic
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getInsertedOn(): ?\DateTimeInterface
    {
        return $this->inserted_on;
    }

    public function setInsertedOn(?\DateTimeInterface $inserted_on): self
    {
        $this->inserted_on = $inserted_on;

        return $this;
    }

    public function getNote(): ?string
    {
        return $this->note;
    }

    public function setNote(?string $note): self
    {
        $this->note = $note;

        return $this;
    }

    public function getLocked(): ?bool
    {
        return $this->locked;
    }

    public function setLocked(bool $locked): self
    {
        $this->locked = $locked;

        return $this;
    }

    public function setEmail($email){
        parent::setEmail($email);
        parent::setUsername($email);
    }

    public function setEmailCanonical($email){
        parent::setEmailCanonical($email);
        parent::setUsernameCanonical($email);
    }

    public function getConfirmed(): ?bool
    {
        return $this->confirmed;
    }

    public function setConfirmed(bool $confirmed): self
    {
        $this->confirmed = $confirmed;

        return $this;
    }

    public function getAlias(): ?string
    {
        return $this->alias;
    }

    public function setAlias(?string $alias): self
    {
        $this->alias = $alias;

        return $this;
    }

    public function getBirthdate(): ?string
    {
        return $this->birthdate;
    }

    public function setBirthdate(?string $birthdate): self
    {
        $this->birthdate = $birthdate;

        return $this;
    }

    public function getCountry(): ?string
    {
        return $this->country;
    }

    public function setCountry(?string $country): self
    {
        $this->country = $country;

        return $this;
    }

    public function getLocation(): ?string
    {
        return $this->location;
    }

    public function setLocation(?string $location): self
    {
        $this->location = $location;

        return $this;
    }

    public function getGender(): ?string
    {
        return $this->gender;
    }

    public function setGender(?string $gender): self
    {
        $this->gender = $gender;

        return $this;
    }

    public function getSexorient(): ?string
    {
        return $this->sexorient;
    }

    public function setSexorient(?string $sexorient): self
    {
        $this->sexorient = $sexorient;

        return $this;
    }

    public function getProfileConfirmed(): ?bool
    {
        return $this->profileConfirmed;
    }

    public function setProfileConfirmed(bool $profileConfirmed): self
    {
        $this->profileConfirmed = $profileConfirmed;

        return $this;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(?string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getProfilePhoto(): ?string
    {
        return $this->profilePhoto;
    }

    public function setProfilePhoto(?string $profilePhoto): self
    {
        $this->profilePhoto = $profilePhoto;

        return $this;
    }
}