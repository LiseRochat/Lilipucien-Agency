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
}
