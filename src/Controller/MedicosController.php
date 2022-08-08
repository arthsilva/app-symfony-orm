<?php

namespace App\Controller;

use App\Entity\Medico;
use App\Helper\MedicoFactory;
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
    private MedicoFactory $medicoFactory;

    public function __construct(
        EntityManagerInterface $entityManager,
        MedicoFactory $medicoFactory //se preciso de uma classe externa, peço ela por injeção de dependência
    )
    {
        //inicializa o gerenciado de entidades do Doctrine
        $this->entityManager = $entityManager;
        $this->medicoFactory = $medicoFactory;
    }

    #[Route('/medicos', methods: ['POST'])]
    public function novo(Request $request): Response
    {
        //retorna uma string contendo o corpo da requisição
        $corpoRequisicao = $request->getContent();
        //mapeia e retorna o valor como objeto
        $medico = $this->medicoFactory->criarMedico($corpoRequisicao);

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
        $medico = $this->buscaMedico($id);

        $codigoRetorno = is_null($medico) ? Response::HTTP_NO_CONTENT : 200;

        return new JsonResponse($medico, $codigoRetorno);
    }

    #[Route('/medicos/{id}', methods: ['PUT'])]
    public function atualiza(int $id, Request $request): Response
    {
        $corpoRequisicao = $request->getContent();
        $medicoEnviado = $this->medicoFactory->criarMedico($corpoRequisicao);

        //buscar o medico para fazer alterações
        $medicoExistente = $this->buscaMedico($id);

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

    #[Route('/medicos/{id}', methods: ['DELETE'])]
    public function remove( int $id): Response
    {
        $medico = $this->buscaMedico($id);
        $this->entityManager->remove($medico);
        $this->entityManager->flush();

        return new Response('', Response::HTTP_NO_CONTENT);
    }

    /**
     * @param int $id
     * @return object|null
     */
    public function buscaMedico(int $id): mixed
    {
        $repositorioMedicos = $this->entityManager->getRepository(Medico::class);
        $medico = $repositorioMedicos->find($id);
        return $medico;
    }
}