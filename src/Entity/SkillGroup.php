<?php

declare(strict_types=1);

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\SkillGroupRepository")
 * @ORM\Cache(usage="NONSTRICT_READ_WRITE", region="phpmx_statics")
 */
class SkillGroup
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
     * @ORM\OneToMany(targetEntity="App\Entity\Skill", mappedBy="skill_group", orphanRemoval=true)
     */
    private $skills;

    /**
     * @ORM\Column(type="boolean")
     */
    private $frontpage;

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
            $skill->setSkillGroup($this);
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
            // set the owning side to null (unless already changed)
            if ($skill->getSkillGroup() === $this) {
                $skill->setSkillGroup(null);
            }
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
     * @return bool|null
     */
    public function getFrontpage(): ?bool
    {
        return $this->frontpage;
    }

    /**
     * @param bool $frontpage
     * @return $this
     */
    public function setFrontpage(bool $frontpage): self
    {
        $this->frontpage = $frontpage;

        return $this;
    }
}
