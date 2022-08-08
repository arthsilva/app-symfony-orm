<?php

namespace App\Controller;

use App\Entity\Medico;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MedicosController
{

    /**
     * @param EntityManagerInterface $entityManager
     */
    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        //inicializa o gerenciado de entidades do Doctrine
        $this->entityManager = $entityManager;
    }

    #[Route('/medicos', methods: ['POST'])]
    public function novo(Request $request): Response
    {
        //retorna uma string contendo o corpo da requisição
        $corpoRequisicao = $request->getContent();
        //mapeia e retorna o valor como objeto
        $dadoJson = json_decode($corpoRequisicao);
        $medico = new Medico();
        $medico->crm = $dadoJson->crm;
        $medico->nome = $dadoJson->nome;

        $this->entityManager->persist($medico);
        $this->entityManager->flush();

        //o que vou receber, vou devolver
        return new JsonResponse($medico);
    }

    #[Route('/medicos', methods: ['GET'])]
    public function buscarTodos(): Response
    {
        $repositorioMedicos = $this
            ->entityManager
            ->getRepository(Medico::class);
        $medicos = $repositorioMedicos->findAll();

        return new JsonResponse($medicos);
    }

    #[Route('/medicos/{id}', methods: ['GET'])]
    public function buscarMedico(int $id): Response
    {
        $repositorioMedicos = $this->entityManager->getRepository(Medico::class);
        $medico = $repositorioMedicos->find($id);

        $codigoRetorno = is_null($medico) ? Response::HTTP_NO_CONTENT : 200;

        return new JsonResponse($medico, $codigoRetorno);
    }

    #[Route('/medicos/{id}', methods: ['PUT'])]
    public function atualiza(int $id, Request $request): Response
    {
        $corpoRequisicao = $request->getContent();
        $dadoJson = json_decode($corpoRequisicao);

        $medicoEnviado = new Medico();
        $medicoEnviado->crm = $dadoJson->crm;
        $medicoEnviado->nome = $dadoJson->nome;

        //buscar o medico para fazer alterações
        $repositorioMedicos = $this->entityManager->getRepository(Medico::class);
        $medicoExistente = $repositorioMedicos->find($id);

        if (is_null($medicoExistente)) {
            //retorna um erro
            return new Response('', Response::HTTP_NOT_FOUND);
        }

        $medicoExistente->crm = $medicoEnviado->crm;
        $medicoExistente->nome = $medicoEnviado->nome;

        $this->entityManager->flush();

        //o que vou receber, vou devolver
        return new JsonResponse($medicoExistente);
    }
}