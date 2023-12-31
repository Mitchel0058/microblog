<?php

namespace App\Entity;

use App\Repository\BlogRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: BlogRepository::class)]
class Blog
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank]
    private ?string $Title = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank]
    private ?string $Subtitle = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    #[Assert\NotBlank]
    private ?\DateTimeInterface $PublicationDate = null;

    #[ORM\Column(type: Types::TEXT)]
    #[Assert\NotBlank]
    private ?string $Text = null;

    #[ORM\Column(length: 255)]
    #[Assert\Image(groups: ['create'])]
    private ?string $MainImage = null;

    #[ORM\Column(type: Types::ARRAY, nullable: true)]
    #[Assert\Image(groups: ['create'])]
    private $SubImages = null;

    public function __construct()
    {
        $this->PublicationDate = new \DateTime();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->Title;
    }

    public function setTitle(string $Title): static
    {
        $this->Title = $Title;

        return $this;
    }

    public function getSubtitle(): ?string
    {
        return $this->Subtitle;
    }

    public function setSubtitle(string $Subtitle): static
    {
        $this->Subtitle = $Subtitle;

        return $this;
    }

    public function getPublicationDate(): ?\DateTimeInterface
    {
        return $this->PublicationDate;
    }

    public function setPublicationDate(\DateTimeInterface $PublicationDate): static
    {
        $this->PublicationDate = $PublicationDate;

        return $this;
    }

    public function getText(): ?string
    {
        return $this->Text;
    }

    public function setText(string $Text): static
    {
        $this->Text = $Text;

        return $this;
    }

    public function getMainImage(): ?string
    {
        return $this->MainImage;
    }

    public function setMainImage(string $MainImage): static
    {
        $this->MainImage = $MainImage;

        return $this;
    }

    public function getSubImages(): ?array
    {
        return $this->SubImages;
    }

    public function setSubImages(?array $SubImages): static
    {
        $this->SubImages = $SubImages;

        return $this;
    }

    public function addSubImages(?string $SubImages): static
    {
        $this->SubImages[] = $SubImages;

        return $this;
    }
}
