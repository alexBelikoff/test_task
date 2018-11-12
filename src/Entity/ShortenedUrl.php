<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ShortenedUrlRepository")
 * @ORM\Table(name="shortened_url", uniqueConstraints={@ORM\UniqueConstraint(name="shortened_url_unique_id",columns={"id"}),@ORM\UniqueConstraint(name="shortened_url_unique_original",columns={"original_url"})})
 * })
 */
class ShortenedUrl
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(name="original_url", type="string", length=255, unique=true)
     */
    private $originalUrl;

    /**
     * @ORM\Column(name="shortened_url", type="string", length=18, nullable=true)
     */
    private $shortenedUrl;

    /**
     * @var \DateTime $created
     *
     * @Gedmo\Timestampable(on="create")
     * @ORM\Column(type="datetime")
     */
    private $created;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $counter;

    /**
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return null|string
     */
    public function getOriginalUrl(): ?string
    {
        return $this->originalUrl;
    }

    /**
     * @param string $originalUrl
     * @return ShortenedUrl
     */
    public function setOriginalUrl(string $originalUrl): self
    {
        $this->originalUrl = $originalUrl;

        return $this;
    }

    /**
     * @return null|string
     */
    public function getShortenedUrl(): ?string
    {
        return $this->shortenedUrl;
    }

    /**
     * @param null|string $shortenedUrl
     * @return ShortenedUrl
     */
    public function setShortenedUrl(?string $shortenedUrl): self
    {
        $this->shortenedUrl = $shortenedUrl;

        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getCreated():\DateTime
    {
        return $this->created;
    }

    /**
     * @return int|null
     */
    public function getCounter(): ?int
    {
        return $this->counter;
    }


    /**
     * @param int $counter
     * @return ShortenedUrl
     */
    public function setCounter(int $counter): self
    {
        $this->counter = $counter;

        return $this;
    }
}
