<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MedicosController
{
    public function novo(Request $request): Response
    {
        //retorna uma string contendo o corpo da requisição
        /**
         * @Route("/medicos")
         */
        $corpoRequisicao = $request->getContent();

        //o que vou receber, vou devolver
        return new Response($corpoRequisicao);
    }
}