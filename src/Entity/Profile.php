<?php

declare(strict_types=1);

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

    /**
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return string|null
     */
    public function getName(): ?string
    {
        return $this->name;
    }

    /**
     * @param string $name
     * @return $this
     */
    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return User|null
     */
    public function getUser(): ?User
    {
        return $this->user;
    }

    /**
     * Set (or unset) the owning side of the relation if necessary
     * @param User|null $user
     * @return $this
     */
    public function setUser(?User $user): self
    {
        $this->user = $user;

        $newProfile = null === $user ? null : $this;
        if ($newProfile !== $user->getProfile()) {
            $user->setProfile($newProfile);
        }

        return $this;
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return $this->name;
    }

    /**
     * @return string|null
     */
    public function getLastname(): ?string
    {
        return $this->lastname;
    }

    /**
     * @param string $lastname
     * @return $this
     */
    public function setLastname(string $lastname): self
    {
        $this->lastname = $lastname;

        return $this;
    }

    /**
     * @return bool|null
     */
    public function isDeveloper(): ?bool
    {
        return $this->developer;
    }

    /**
     * @param bool|null $developer
     * @return $this
     */
    public function setDeveloper(?bool $developer): self
    {
        $this->developer = $developer;

        return $this;
    }

    /**
     * @return bool|null
     */
    public function isHr(): ?bool
    {
        return $this->hr;
    }

    /**
     * @param bool|null $hr
     * @return $this
     */
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

    /**
     * @param Skill $skill
     * @return $this
     */
    public function addSkill(Skill $skill): self
    {
        if (!$this->skills->contains($skill)) {
            $this->skills[] = $skill;
        }

        return $this;
    }

    /**
     * @param Skill $skill
     * @return $this
     */
    public function removeSkill(Skill $skill): self
    {
        if ($this->skills->contains($skill)) {
            $this->skills->removeElement($skill);
        }

        return $this;
    }

    /**
     * @return string|null
     */
    public function getTitle(): ?string
    {
        return $this->title;
    }

    /**
     * @param string|null $title
     * @return $this
     */
    public function setTitle(?string $title): self
    {
        $this->title = $title;

        return $this;
    }
}
