<?php

namespace App\Entity;

use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\GeneratedValue;
use Doctrine\ORM\Mapping\Id;

#[Entity]
class Medico
{
    #[Id, GeneratedValue, Column]
    public int $id;

    #[Column]
    public int $crm;

    #[Column]
    public string $nome;
}