<?php

namespace App\Entity;

use App\Repository\ImagesBienRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ImagesBienRepository::class)]
class ImagesBien
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $img;

    #[ORM\ManyToOne(targetEntity: Bien::class, inversedBy: 'imagesBiens')]
    private $bien;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getImg(): ?string
    {
        return $this->img;
    }

    public function setImg(?string $img): self
    {
        $this->img = $img;

        return $this;
    }

    public function getBien(): ?Bien
    {
        return $this->bien;
    }

    public function setBien(?Bien $bien): self
    {
        $this->bien = $bien;

        return $this;
    }
}
