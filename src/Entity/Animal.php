<?php

namespace App\Entity;

use App\Repository\AnimalRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use phpDocumentor\Reflection\Types\Integer;

#[ORM\Entity(repositoryClass: AnimalRepository::class)]
class Animal
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 100)]
    private ?string $name = null;

    #[ORM\Column]
    private ?int $averageSize = null;

    #[ORM\Column(length: 100, nullable: true)]
    private ?string $country = null;

    #[ORM\Column(length: 100)]
    private ?string $martialArt = null;

    #[ORM\Column(length: 20)]
    private ?string $phoneNumber = null;

    #[ORM\ManyToMany(targetEntity: Country::class, inversedBy: 'animals')]
    private Collection $relation;

    public function __construct(
        string $name = null,
        int $averageSize = null,
        string $country = null,
        string $martialArt = null,
        string $phoneNumber = null
    ) {
        $this->relation = new ArrayCollection();

        $this->name = $name;
        $this->averageSize = $averageSize;
        $this->country = $country;
        $this->martialArt = $martialArt;
        $this->phoneNumber = $phoneNumber;
    }

    public function getId(): ?int
    {
        return $this->id;
    }
public function setId(int $id):self
    {
        $this->id = $id;
        return $this;
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

    public function getAverageSize(): ?int
    {
        return $this->averageSize;
    }

    public function setAverageSize(int $averageSize): self
    {
        $this->averageSize = $averageSize;

        return $this;
    }

    public function getCountry(): ?string
    {
        return $this->country;
    }

    public function setCountry(?string $country): self
    {
        $this->country = $country;

        return $this;
    }

    public function getMartialArt(): ?string
    {
        return $this->martialArt;
    }

    public function setMartialArt(string $martialArt): self
    {
        $this->martialArt = $martialArt;

        return $this;
    }

    public function getPhoneNumber(): ?string
    {
        return $this->phoneNumber;
    }

    public function setPhoneNumber(string $phoneNumber): self
    {
        $this->phoneNumber = $phoneNumber;

        return $this;
    }

    /**
     * @return Collection<int, Country>
     */
    public function getRelation(): Collection
    {
        return $this->relation;
    }

    public function addRelation(Country $relation): self
    {
        if (!$this->relation->contains($relation)) {
            $this->relation->add($relation);
        }

        return $this;
    }

    public function removeRelation(Country $relation): self
    {
        $this->relation->removeElement($relation);

        return $this;
    }
}
