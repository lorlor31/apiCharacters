<?php

namespace App\Entity;

use App\Repository\CharacterRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: CharacterRepository::class)]
#[ORM\Table(name: '`character`')]
class Character
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['character'])]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Groups(['character'])]
    private ?string $nickname = null;

    #[ORM\Column(length: 255)]
    #[Groups(['character'])]
    private ?string $abstract = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    #[Groups(['character'])]
    private ?\DateTimeInterface $birthDate = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    #[Groups(['character'])]
    private ?\DateTimeInterface $deathDate = null;

    #[ORM\Column(type: Types::TEXT)]
    #[Groups(['character'])]
    private ?string $long_description = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Groups(['character'])]
    private ?string $backgroundImage = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Groups(['character'])]
    private ?string $avatarImage = null;

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


}
