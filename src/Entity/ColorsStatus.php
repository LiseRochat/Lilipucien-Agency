<?php

namespace App\Entity;

use App\Repository\ColorsStatusRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ColorsStatusRepository::class)]
class ColorsStatus
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 255)]
    private $name;

    #[ORM\Column(type: 'string', length: 255)]
    private $codeBootstrap;

    #[ORM\OneToOne(mappedBy: 'color', targetEntity: Status::class, cascade: ['persist', 'remove'])]
    private $status;

    public function getId(): ?int
    {
        return $this->id;
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

    public function getCodeBootstrap(): ?string
    {
        return $this->codeBootstrap;
    }

    public function setCodeBootstrap(string $codeBootstrap): self
    {
        $this->codeBootstrap = $codeBootstrap;

        return $this;
    }

    public function getStatus(): ?Status
    {
        return $this->status;
    }

    public function setStatus(?Status $status): self
    {
        // unset the owning side of the relation if necessary
        if ($status === null && $this->status !== null) {
            $this->status->setColor(null);
        }

        // set the owning side of the relation if necessary
        if ($status !== null && $status->getColor() !== $this) {
            $status->setColor($this);
        }

        $this->status = $status;

        return $this;
    }
}
