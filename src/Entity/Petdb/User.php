<?php

namespace App\Entity\Petdb;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * User
 *
 * @ORM\Table(name="user")
 * @ORM\Entity(repositoryClass="App\Repository\UserRepository")
 * @UniqueEntity(
 *     fields={"email"},
 *     errorPath="email",
 *     message="Cette email est déjà utilisée."
 * )
 */
class User implements UserInterface 
{
    /**
     * @var int
     *
     * @ORM\Column(name="iduser", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $iduser;

    /**
     * @var string
     *
     * @ORM\Column(name="firstname", type="string", length=45, nullable=false)
     * @Assert\NotBlank(message="Ne peut être vide")
     */
    private $firstname;

    /**
     * @var string
     *
     * @ORM\Column(name="lastname", type="string", length=45, nullable=false)
     * @Assert\NotBlank(message="Ne peut être vide")
     */
    private $lastname;

    /**
     * @var string
     *
     * @ORM\Column(name="email", type="string", length=155, nullable=false)
     * @Assert\NotBlank(message="Ne peut être vide")
     * @Assert\Email(
     *     message = "The email '{{ value }}' is not a valid email."
     * )
     * 
     */
    private $email;

    /**
     * @var string
     *
     * @ORM\Column(name="password", type="string", length=80, nullable=false)
     * @Assert\NotBlank(message="Ne peut être vide")
     */
    private $password;

    private $plainPassword;

    /**
     * @var string
     *
     * @ORM\Column(name="street", type="string", length=155, nullable=false)
     * @Assert\NotBlank(message="Ne peut être vide")
     */
    private $street;

    /**
     * @var string
     *
     * @ORM\Column(name="zip", type="string", length=20, nullable=false)
     * @Assert\Regex("/^[0-9]{5}$/")
     * @Assert\NotBlank(message="Ne peut être vide")
     */
    private $zip;

    /**
     * @var string
     *
     * @ORM\Column(name="city", type="string", length=50, nullable=false)
     * @Assert\NotBlank(message="Ne peut être vide")
     */
    private $city;

    /**
     * @var string
     *
     * @ORM\Column(name="country", type="string", length=45, nullable=false, options={"default"="France"})
     * @Assert\NotBlank(message="Ne peut être vide")
     */
    private $country = 'France';

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="birthday", type="date", nullable=false)
     * @Assert\NotBlank(message="Ne peut être vide")
     */
    private $birthday;

    /**
     * @var string
     *
     * @ORM\Column(name="sexe", type="string", length=0, nullable=false, options={"default"="Femme"})
     */
    private $sexe = 'Femme';

    /**
     * @var bool
     *
     * @ORM\Column(name="active", type="boolean", nullable=false, options={"default"="1"})
     */
    private $active = '1';

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="createdAt", type="datetime", nullable=false, options={"default"="CURRENT_TIMESTAMP"})
     */
    // private $createdat = 'CURRENT_TIMESTAMP';
    private $createdat;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="updetedAt", type="datetime", nullable=false, options={"default"="CURRENT_TIMESTAMP"})
     */
    // private $updetedat = 'CURRENT_TIMESTAMP';
    private $updetedat;

    public function __construct() {
        $this->createdat = new \Datetime();
        $this->updetedat = new \Datetime();
    }

    public function getIduser(): ?int
    {
        return $this->iduser;
    }

    public function getFirstname(): ?string
    {
        return $this->firstname;
    }

    public function setFirstname(string $firstname): self
    {
        $this->firstname = $firstname;

        return $this;
    }

    public function getLastname(): ?string
    {
        return $this->lastname;
    }

    public function setLastname(string $lastname): self
    {
        $this->lastname = $lastname;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    public function getStreet(): ?string
    {
        return $this->street;
    }

    public function setStreet(string $street): self
    {
        $this->street = $street;

        return $this;
    }

    public function getZip(): ?string
    {
        return $this->zip;
    }

    public function setZip(string $zip): self
    {
        $this->zip = $zip;

        return $this;
    }

    public function getCity(): ?string
    {
        return $this->city;
    }

    public function setCity(string $city): self
    {
        $this->city = $city;

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

    public function getBirthday(): ?\DateTimeInterface
    {
        return $this->birthday;
    }

    public function setBirthday(\DateTimeInterface $birthday): self
    {
        $this->birthday = $birthday;

        return $this;
    }

    public function getSexe(): ?string
    {
        return $this->sexe;
    }

    public function setSexe(string $sexe): self
    {
        $this->sexe = $sexe;

        return $this;
    }

    public function getActive(): ?bool
    {
        return $this->active;
    }

    public function setActive(bool $active): self
    {
        $this->active = $active;

        return $this;
    }

    public function getCreatedat(): ?\DateTimeInterface
    {
        return $this->createdat;
    }

    public function setCreatedat(\DateTimeInterface $createdat): self
    {
        $this->createdat = $createdat;

        return $this;
    }

    public function getUpdetedat(): ?\DateTimeInterface
    {
        return $this->updetedat;
    }

    public function setUpdetedat(\DateTimeInterface $updetedat): self
    {
        $this->updetedat = $updetedat;

        return $this;
    }

    public function eraseCredentials() {
    }

    public function getSalt() {}

    public function getRoles() {
        return ["ROLE_ADMIN"];
    }

    public function getUsername() {}


}
