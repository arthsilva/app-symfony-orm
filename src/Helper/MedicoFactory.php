<?php

namespace App\Helper;

use App\Entity\Medico;

//factory vai ser toda classe que recebe informações e devolve um objeto
class MedicoFactory
{
    public function criarMedico(string $json): Medico
    {
        $dadoJson = json_decode($json);

        $medico = new Medico();
        $medico->crm = $dadoJson->crm;
        $medico->nome = $dadoJson->nome;

        return $medico;
    }
}