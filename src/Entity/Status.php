<?php

namespace App\Entity;

use App\Repository\StatusRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: StatusRepository::class)]
class Status
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $title;

    #[ORM\Column(type: 'text', nullable: true)]
    private $description;

    #[ORM\OneToMany(mappedBy: 'status', targetEntity: Bien::class)]
    private $biens;

    #[ORM\Column(type: 'string', length: 255)]
    private $color;

    public function __construct()
    {
        $this->biens = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(?string $title): self
    {
        $this->title = $title;

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

    /**
     * @return Collection<int, Bien>
     */
    public function getBiens(): Collection
    {
        return $this->biens;
    }

    public function addBien(Bien $bien): self
    {
        if (!$this->biens->contains($bien)) {
            $this->biens[] = $bien;
            $bien->setStatus($this);
        }

        return $this;
    }

    public function removeBien(Bien $bien): self
    {
        if ($this->biens->removeElement($bien)) {
            // set the owning side to null (unless already changed)
            if ($bien->getStatus() === $this) {
                $bien->setStatus(null);
            }
        }

        return $this;
    }

    public function getColor(): ?string
    {
        return $this->color;
    }

    public function setColor(string $color): self
    {
        $this->color = $color;

        return $this;
    }
}
