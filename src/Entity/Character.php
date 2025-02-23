<?php

namespace App\Entity;

use App\Repository\CharacterRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;
use Vich\UploaderBundle\Mapping\Annotation as Vich;
use Symfony\Component\HttpFoundation\File\File;

#[ORM\Entity(repositoryClass: CharacterRepository::class)]
#[ORM\Table(name: '`character`')]
#[Vich\Uploadable]

#[ORM\HasLifecycleCallbacks]
class Character
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['character'])]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank]
    #[Assert\Length(max: 255, maxMessage: "Le nom ne doit pas dépasser 255 caractères.")]
    #[Groups(['character'])]
    private ?string $nickname = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank]
    #[Assert\Length(max: 255, maxMessage: "Le résumé ne doit pas dépasser 255 caractères.")]
    #[Groups(['character'])]
    private ?string $abstract = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    #[Assert\NotBlank]
    #[Groups(['character'])]
    private ?\DateTimeInterface $birthDate = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    // #[Assert\DateTime] => pas mis parce que ça bloque pour les dates dans l'heure ??
    // à comprendre
    #[Groups(['character'])]
    private ?\DateTimeInterface $deathDate = null;

    #[ORM\Column(type: Types::TEXT)]
    #[Assert\Length(max: 10000, maxMessage: "La description ne doit pas dépasser 10000 caractères.")]
    #[Assert\NotBlank]
    #[Groups(['character'])]
    private ?string $long_description = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Groups(['character'])]
    private ?string $backgroundImage = null;

    // #[ORM\Column(length: 255, nullable: true)] => ne pas mapper cette propriété
    #[Groups(['character'])]
    #[Vich\UploadableField(mapping: 'characters', fileNameProperty: 'avatarImage', size: 'imageSize')]
    private ?File $avatarFile = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Groups(['character'])]
    private ?string $avatarImage = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $createdAt = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $updatedAt = null;

    /**
     * @var Collection<int, Personality>
     */
    #[ORM\ManyToMany(targetEntity: Personality::class, inversedBy: 'characters')]
    #[Groups(['character','character_personalities'])]
    private Collection $personalities;


   
    public function __construct()
    {
        $this->personalities = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNickname(): ?string
    {
        return $this->nickname;
    }

    public function setNickname(string $nickname): static
    {
        $this->nickname = $nickname;

        return $this;
    }

    public function getAbstract(): ?string
    {
        return $this->abstract;
    }

    public function setAbstract(string $abstract): static
    {
        $this->abstract = $abstract;

        return $this;
    }

    public function getBirthDate(): ?\DateTimeInterface
    {
        return $this->birthDate;
    }

    public function setBirthDate(?\DateTimeInterface $birthDate): static
    {
        $this->birthDate = $birthDate;

        return $this;
    }

    public function getDeathDate(): ?\DateTimeInterface
    {
        return $this->deathDate;
    }

    public function setDeathDate(?\DateTimeInterface $deathDate): static
    {
        $this->deathDate = $deathDate;

        return $this;
    }

    public function getLongDescription(): ?string
    {
        return $this->long_description;
    }

    public function setLongDescription(string $long_description): static
    {
        $this->long_description = $long_description;

        return $this;
    }

    public function getBackgroundImage(): ?string
    {
        return $this->backgroundImage;
    }

    public function setBackgroundImage(?string $backgroundImage): static
    {
        $this->backgroundImage = $backgroundImage;

        return $this;
    }

    public function getAvatarImage(): ?string
    {
        return $this->avatarImage;
    }

    public function setAvatarImage(?string $avatarImage): static
    {
        $this->avatarImage = $avatarImage;

        return $this;
    }


    public function setAvatarFile(?File $avatarFile = null): void
    {
        $this->avatarFile = $avatarFile;

        if (null !== $avatarFile) {
            // It is required that at least one field changes if you are using doctrine
            // otherwise the event listeners won't be called and the file is lost
            $this->updatedAt = new \DateTimeImmutable();
        }
    }

    public function getAvatarFile(): ?File
    {
        return $this->avatarFile;
    } 

    /**
     * @return Collection<int, Personality>
     */
    public function getPersonalities(): Collection
    {
        return $this->personalities;
    }

    public function addPersonality(Personality $personality): static
    {
        if (!$this->personalities->contains($personality)) {
            $this->personalities->add($personality);
        }

        return $this;
    }

    public function removePersonality(Personality $personality): static
    {
        $this->personalities->removeElement($personality);

        return $this;
    }


    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->createdAt;
    }

    #[ORM\PrePersist]
    public function setCreatedAt(): static
    {
        $this->createdAt = new \DateTimeImmutable();

        return $this;
    }

    public function getUpdatedAt(): ?\DateTimeInterface
    {
        return $this->updatedAt;
    }

    #[ORM\PreUpdate]
    public function setUpdatedAt(): static
    {
        $this->updatedAt = new \DateTimeImmutable();

        return $this;
    }

}