<?php

namespace App\Entity;

use App\Repository\MeetupEventRepository;
use DateTimeImmutable;
use DateTimeInterface;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

/**
 * @ORM\Entity(repositoryClass=MeetupEventRepository::class)
 * @Vich\Uploadable
 */
class MeetupEvent
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="integer", unique=true)
     */
    private $meetupId;

    /**
     * @ORM\Column(type="datetime")
     */
    private $scheduledAt;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $title;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $place = 'No definido';

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $description = 'No disponible por ahora';

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $attendingCount = 0;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $speaker = 'No definido';

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $url;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $image;

    /**
     * @Vich\UploadableField(mapping="meetup_images", fileNameProperty="image")
     */
    private $imageFile;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $linkedinUrl;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $gitUrl;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $twitterUrl;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $facebookUrl;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $slideUrl;

    /**
     * @ORM\Column(type="datetime", columnDefinition="TIMESTAMP DEFAULT CURRENT_TIMESTAMP")
     */
    private $createdAt;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $updatedAt;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getMeetupId(): ?int
    {
        return $this->meetupId;
    }

    public function setMeetupId(int $meetupId): self
    {
        $this->meetupId = $meetupId;

        return $this;
    }

    public function getScheduledAt(): ?DateTimeInterface
    {
        return $this->scheduledAt;
    }

    public function setScheduledAt(DateTimeInterface $scheduledAt): self
    {
        $this->scheduledAt = $scheduledAt;

        return $this;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getPlace(): ?string
    {
        return $this->place;
    }

    public function setPlace(?string $place): self
    {
        $this->place = $place;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getAttendingCount(): ?int
    {
        return $this->attendingCount;
    }

    public function setAttendingCount(?int $attendingCount): self
    {
        $this->attendingCount = $attendingCount;

        return $this;
    }

    public function getSpeaker(): ?string
    {
        return $this->speaker;
    }

    public function setSpeaker(?string $speaker): self
    {
        $this->speaker = $speaker;

        return $this;
    }

    public function getUrl(): ?string
    {
        return $this->url;
    }

    public function setUrl(string $url): self
    {
        $this->url = $url;

        return $this;
    }

    public function __toString(): string
    {
        $attributes = [
            'id: '.$this->id,
            'meetupId: '.$this->meetupId,
            'image: '.$this->image,
            'scheduledAt: '.$this->scheduledAt->format('Y-m-d H:i:s'),
            'title: '.$this->title,
            'place: '.$this->place,
            'description: '.$this->description,
            'attendingCount: '.$this->attendingCount,
            'speaker: '.$this->speaker,
            'url: '.$this->url,
        ];

        return sprintf('[%s]', implode(',', $attributes));
    }

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(?string $image): self
    {
        $this->image = $image;

        return $this;
    }

    public function setImageFile(File $imageFile = null): self
    {
        $this->imageFile = $imageFile;

        if ($imageFile) {
            $this->updated_at = new DateTimeImmutable();
        }

        return $this;
    }

    public function getImageFile(): ?File
    {
        return $this->imageFile;
    }

    public function setLinkedinUrl(?string $linkedinUrl): self
    {
        $this->linkedinUrl = $linkedinUrl;

        return $this;
    }

    public function getLinkedinUrl(): ?string
    {
        return $this->linkedinUrl;
    }

    public function setGitUrl(?string $gitUrl): self
    {
        $this->gitUrl = $gitUrl;

        return $this;
    }
    
    public function getGitUrl(): ?string
    {
        return $this->gitUrl;
    }

    public function setTwitterUrl(?string $twitterUrl): self
    {
        $this->twitterUrl = $twitterUrl;

        return $this;
    }

    public function getTwitterUrl(): ?string
    {
        return $this->twitterUrl;
    }

    public function setFacebookUrl(?string $facebookUrl): self
    {
        $this->facebookUrl = $facebookUrl;

        return $this;
    }

    public function getFacebookUrl(): ?string
    {
        return $this->facebookUrl;
    }

    public function setSlideUrl(?string $slideUrl): self
    {
        $this->slideUrl = $slideUrl;

        return $this;
    }

    public function getSlideUrl(): ?string
    {
        return $this->slideUrl;
    }

    public function setCreatedAt(DateTimeInterface $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getCreatedAt(): ?DateTimeInterface
    {
        return $this->createdAt;
    }

    public function setUpdatedAt(DateTimeInterface $updatedAt): self
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    public function getUpdatedAt(): ?DateTimeInterface
    {
        return $this->updatedAt;
    }
}
