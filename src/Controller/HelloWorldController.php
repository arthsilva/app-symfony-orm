<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HelloWorldController
{
    //annotation para setar a rota para acessar esta action
    #[Route('/hello', methods:['GET'])]
    public function helloWorldAction(Request $request): Response
    {
        //$request->attributes->get('nomeDoParametro'); busca um parâmetro definido na URL da rota
        //$request->query->get('nomeDoParametro'): busca o parâmetro na query string da URL
        // $request->request->get('nomeDoParametro'): busca um parâmetro do corpo da requisição

        //informações sobre a pasta
        $pathInfo = $request->getPathInfo();
        $query = $request->query->all();
        //resposta em json
        return new JsonResponse([
            'mensage' =>  'Hello World',
            'path' =>  $pathInfo,
            //'param' => $param
            'query' => $query
        ]);
    }
}