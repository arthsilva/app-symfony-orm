<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
class Medico
{
    #[ORM\Id,
    ORM\GeneratedValue,
    ORM\Column]
    public int $id;

    #[ORM\Column]
    public int $crm;

    #[ORM\Column]
    public string $nome;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private ?Especialidade $especialidade = null;

    public function getEspecialidade(): ?Especialidade
    {
        return $this->especialidade;
    }

    public function setEspecialidade(?Especialidade $especialidade): self
    {
        $this->especialidade = $especialidade;

        return $this;
    }
}