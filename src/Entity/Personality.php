<?php

namespace App\Entity;

use App\Entity\Character;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\PersonalityRepository;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: PersonalityRepository::class)]
class Personality
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['character_personalities'])]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Groups(['character_personalities'])]
    private ?string $value = null;

    /**
     * @var Collection<int, Character>
     */
    #[ORM\ManyToMany(targetEntity: Character::class, mappedBy: 'personalities')]
    private Collection $characters;

   
    public function __construct()
    {
        $this->characters = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getValue(): ?string
    {
        return $this->value;
    }

    public function setValue(string $value): static
    {
        $this->value = $value;

        return $this;
    }

    /**
     * @return Collection<int, Character>
     */
    public function getCharacters(): Collection
    {
        return $this->characters;
    }

    public function addCharacter(Character $character): static
    {
        if (!$this->characters->contains($character)) {
            $this->characters->add($character);
            $character->addPersonality($this);
        }

        return $this;
    }

    public function removeCharacter(Character $character): static
    {
        if ($this->characters->removeElement($character)) {
            $character->removePersonality($this);
        }

        return $this;
    }

}
