<?php

namespace App\Controller;

use App\Entity\Medico;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MedicosController
{
    /**
     * @Route("/medicos", methods={"POST"})
     */
    public function novo(Request $request): Response
    {
        //retorna uma string contendo o corpo da requisição
        $corpoRequisicao = $request->getContent();
        //mapeia e retorna o valor como objeto
        $dadoJson = json_decode($corpoRequisicao);
        $medico = new Medico();
        $medico->crm = $dadoJson->crm;
        $medico->nome = $dadoJson->nome;

        //o que vou receber, vou devolver
        return new JsonResponse($medico);
    }
}