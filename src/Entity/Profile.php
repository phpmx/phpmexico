<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ProfileRepository")
 * @ORM\Cache(usage="NONSTRICT_READ_WRITE", region="phpmx_statics")
 */
class Profile
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=50)
     */
    private $name;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\User", mappedBy="profile", cascade={"persist", "remove"})
     */
    private $user;

    /**
     * @ORM\Column(type="string", length=50)
     */
    private $lastname;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $developer;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $hr;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Skill", inversedBy="profiles")
     */
    private $skills;

    /**
     * @ORM\Column(type="string", length=80, nullable=true)
     */
    private $title;

    public function __construct()
    {
        $this->skills = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
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

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        // set (or unset) the owning side of the relation if necessary
        $newProfile = null === $user ? null : $this;
        if ($newProfile !== $user->getProfile()) {
            $user->setProfile($newProfile);
        }

        return $this;
    }

    public function __toString(): string
    {
        return $this->name;
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

    public function isDeveloper(): ?bool
    {
        return $this->developer;
    }

    public function setDeveloper(?bool $developer): self
    {
        $this->developer = $developer;

        return $this;
    }

    public function isHr(): ?bool
    {
        return $this->hr;
    }

    public function setHr(?bool $hr): self
    {
        $this->hr = $hr;

        return $this;
    }

    /**
     * @return Collection|Skill[]
     */
    public function getSkills(): Collection
    {
        return $this->skills;
    }

    public function addSkill(Skill $skill): self
    {
        if (!$this->skills->contains($skill)) {
            $this->skills[] = $skill;
        }

        return $this;
    }

    public function removeSkill(Skill $skill): self
    {
        if ($this->skills->contains($skill)) {
            $this->skills->removeElement($skill);
        }

        return $this;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(?string $title): self
    {
        $this->title = $title;

        return $this;
    }
}
