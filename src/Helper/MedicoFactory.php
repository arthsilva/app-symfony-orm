<?php

namespace App\Helper;

use App\Entity\Medico;
use App\Repository\EspecialidadeRepository;

//factory vai ser toda classe que recebe informações e devolve um objeto
class MedicoFactory
{
    private EspecialidadeRepository $especialidadeRepository;

    public function __construct(
        EspecialidadeRepository $especialidadeRepository
    )
    {
        $this->especialidadeRepository = $especialidadeRepository;
    }

    public function criarMedico(string $json): Medico
    {
        $dadoJson = json_decode($json);
        $especialidadeId = $dadoJson->especialidade;
        $especialidade = $this->especialidadeRepository->find($especialidadeId);

        $medico = new Medico();
        $medico
            ->setCrm($dadoJson->crm)
            ->setNome($dadoJson->nome)
            ->setEspecialidade($especialidade);

        return $medico;
    }
}