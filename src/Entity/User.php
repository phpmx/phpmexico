<?php

declare(strict_types=1);

namespace App\Entity;

use DateTimeInterface;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\UserRepository")
 * @UniqueEntity("email", message="Ya estas registrado")
 * @UniqueEntity("username", message="Alguien ya usa este username")
 * @ORM\Cache(usage="NONSTRICT_READ_WRITE", region="phpmx_statics")
 */
class User implements UserInterface
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=50, unique=true)
     */
    private $username;

    /**
     * @ORM\Column(type="string", length=100, unique=true)
     * @Assert\Email
     */
    private $email;

    /**
     * @ORM\Column(type="string", length=20, nullable=true)
     */
    private $slack_id;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $slack;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $newsletter;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\Profile", inversedBy="user", cascade={"persist", "remove"})
     */
    private $profile;

    /**
     * @ORM\Column(type="string", length=300, nullable=true, unique=true)
     */
    private $login_token;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Job", mappedBy="owner")
     */
    private $jobs;

    /**
     * @ORM\Column(type="datetime")
     */
    private $last_login;

    /**
     * @ORM\Column(type="string", length=20, nullable=true)
     */
    private $mobile;

    /**
     * @ORM\Column(type="string", length=5, nullable=true)
     */
    private $tshirt_size;

    /**
     * @ORM\Column(type="string", length=15, nullable=true)
     */
    private $country;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    private $salary_expectation;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $offerts;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Contact", mappedBy="user")
     */
    private $contacts;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $slack_last_activity;

    /**
     * @ORM\Column(type="string", length=100, nullable=true)
     */
    private $city;

    /**
     * @ORM\Column(type="array")
     */
    private $roles = ['ROLE_USER'];

    public function __construct()
    {
        $this->jobs = new ArrayCollection();
        $this->last_login = new \DateTime();
        $this->contacts = new ArrayCollection();
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
    public function getUsername(): ?string
    {
        return $this->username;
    }

    /**
     * @param string $username
     * @return $this
     */
    public function setUsername(string $username): self
    {
        $this->username = $username;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getEmail(): ?string
    {
        return $this->email;
    }

    /**
     * @param string $email
     * @return $this
     */
    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getSlackId(): ?string
    {
        return $this->slack_id;
    }

    /**
     * @param string|null $slack_id
     * @return $this
     */
    public function setSlackId(?string $slack_id): self
    {
        $this->slack_id = $slack_id;

        return $this;
    }

    /**
     * @return bool|null
     */
    public function getSlack(): ?bool
    {
        return $this->slack;
    }

    /**
     * @param bool|null $slack
     * @return $this
     */
    public function setSlack(?bool $slack): self
    {
        $this->slack = $slack;

        return $this;
    }

    /**
     * @return bool|null
     */
    public function getNewsletter(): ?bool
    {
        return $this->newsletter;
    }

    /**
     * @param bool|null $newsletter
     * @return $this
     */
    public function setNewsletter(?bool $newsletter): self
    {
        $this->newsletter = $newsletter;

        return $this;
    }

    /**
     * @return Profile|null
     */
    public function getProfile(): ?Profile
    {
        return $this->profile;
    }

    /**
     * @param Profile|null $profile
     * @return $this
     */
    public function setProfile(?Profile $profile): self
    {
        $this->profile = $profile;

        return $this;
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return $this->username;
    }

    /**
     * @return string|null
     */
    public function getLoginToken(): ?string
    {
        return $this->login_token;
    }

    /**
     * @param string|null $login_token
     * @return $this
     */
    public function setLoginToken(?string $login_token): self
    {
        $this->login_token = $login_token;

        return $this;
    }

    /**
     * @return string[]
     */
    public function getRoles()
    {
        return $this->roles;
    }

    public function getPassword()
    {
        // TODO: Implement getPassword() method.
    }

    public function getSalt()
    {
        // TODO: Implement getSalt() method.
    }

    public function eraseCredentials()
    {
        // TODO: Implement eraseCredentials() method.
    }

    /**
     * @return Collection|Job[]
     */
    public function getJobs(): Collection
    {
        return $this->jobs;
    }

    /**
     * @param Job $job
     * @return $this
     */
    public function addJob(Job $job): self
    {
        if (!$this->jobs->contains($job)) {
            $this->jobs->add($job);
            $job->setOwner($this);
        }

        return $this;
    }

    /**
     * set the owning side to null (unless already changed)
     * @param Job $job
     * @return $this
     */
    public function removeJob(Job $job): self
    {
        if ($this->jobs->contains($job)) {
            $this->jobs->removeElement($job);
            if ($job->getOwner() === $this) {
                $job->setOwner(null);
            }
        }

        return $this;
    }

    /**
     * @return DateTimeInterface|null
     */
    public function getLastLogin(): ?DateTimeInterface
    {
        return $this->last_login;
    }

    /**
     * @param DateTimeInterface $last_login
     * @return $this
     */
    public function setLastLogin(DateTimeInterface $last_login): self
    {
        $this->last_login = $last_login;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getMobile(): ?string
    {
        return $this->mobile;
    }

    /**
     * @param string|null $mobile
     * @return $this
     */
    public function setMobile(?string $mobile): self
    {
        $this->mobile = $mobile;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getTshirtSize(): ?string
    {
        return $this->tshirt_size;
    }

    /**
     * @param string|null $tshirt_size
     * @return $this
     */
    public function setTshirtSize(?string $tshirt_size): self
    {
        $this->tshirt_size = $tshirt_size;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getCountry(): ?string
    {
        return $this->country;
    }

    /**
     * @param string|null $country
     * @return $this
     */
    public function setCountry(?string $country): self
    {
        $this->country = $country;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getSalaryExpectation(): ?string
    {
        return $this->salary_expectation;
    }

    /**
     * @param string|null $salary_expectation
     * @return $this
     */
    public function setSalaryExpectation(?string $salary_expectation): self
    {
        $this->salary_expectation = $salary_expectation;

        return $this;
    }

    /**
     * @return bool|null
     */
    public function getOfferts(): ?bool
    {
        return $this->offerts;
    }

    /**
     * @param bool|null $offerts
     * @return $this
     */
    public function setOfferts(?bool $offerts): self
    {
        $this->offerts = $offerts;

        return $this;
    }

    /**
     * @return Collection|Contact[]
     */
    public function getContacts(): Collection
    {
        return $this->contacts;
    }

    /**
     * @param Contact $contact
     * @return $this
     */
    public function addContact(Contact $contact): self
    {
        if (!$this->contacts->contains($contact)) {
            $this->contacts->add($contact);
            $contact->setUser($this);
        }

        return $this;
    }

    /**
     * set the owning side to null (unless already changed)
     * @param Contact $contact
     * @return $this
     */
    public function removeContact(Contact $contact): self
    {
        if ($this->contacts->contains($contact)) {
            $this->contacts->removeElement($contact);
            if ($contact->getUser() === $this) {
                $contact->setUser(null);
            }
        }

        return $this;
    }

    /**
     * @return DateTimeInterface|null
     */
    public function getSlackLastActivity(): ?DateTimeInterface
    {
        return $this->slack_last_activity;
    }

    /**
     * @param DateTimeInterface|null $slack_last_activity
     * @return $this
     */
    public function setSlackLastActivity(?DateTimeInterface $slack_last_activity): self
    {
        $this->slack_last_activity = $slack_last_activity;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getCity(): ?string
    {
        return $this->city;
    }

    /**
     * @param string|null $city
     * @return $this
     */
    public function setCity(?string $city): self
    {
        $this->city = $city;

        return $this;
    }

    /**
     * @param array|null $roles
     * @return $this
     */
    public function setRoles(?array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }
}
