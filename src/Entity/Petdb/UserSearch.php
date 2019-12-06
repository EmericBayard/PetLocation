<?php

namespace App\Entity\Petdb;


class UserSearch {
   
    private $email;
    private $dateCreatedAt;
    // private $dateCreatedAtPlusOneDay;

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(?string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getDateCreatedAt(): ?\DateTimeInterface
    {
        return $this->dateCreatedAt;
    }

    public function setDateCreatedAt(?\DateTimeInterface $dateCreatedAt): self
    {
        $this->dateCreatedAt = $dateCreatedAt;
        // $this->dateCreatedAtPlusOneDay = $dateCreatedAt->add(new \DateInterval('P1D'));

        return $this;
    }
    // public function getDateCreatedAtPlusOneDay(): ?\DateTimeInterface
    // {
    //     return $this->dateCreatedAtPlusOneDay;
    // }
}
