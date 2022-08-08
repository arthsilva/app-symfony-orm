<?php

namespace App\Controller;

use App\Entity\Especialidade;
use App\Repository\EspecialidadeRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class EspecialidadesController
{
    private EntityManagerInterface $entityManager;
    private EspecialidadeRepository $especialidadeRepository;

    public function __construct(
        EntityManagerInterface $entityManager,
        EspecialidadeRepository $especialidadeRepository
    )
    {
        $this->entityManager = $entityManager;
        $this->especialidadeRepository = $especialidadeRepository;
    }

    #[Route('/especialidades', methods: ['POST'])]
    public function nova(Request $request): Response
    {
        $dadosRequest = $request->getContent();
        $dadosJson = json_decode($dadosRequest);

        $especialidade = new Especialidade();
        $especialidade->setDescricao($dadosJson->descricao);

        $this->entityManager->persist($especialidade);;
        $this->entityManager->flush();

        return new JsonResponse($especialidade);
    }

    #[Route('/especialidades', methods: ['GET'])]
    public function buscarTodas(): Response
    {
        return new JsonResponse($this->especialidadeRepository->findAll());

    }

    #[Route('/especialidades/{id}', methods: ['GET'])]
    public function buscarEspeciliadade(int $id): Response
    {
        return new JsonResponse($this->especialidadeRepository->find($id));
    }

    #[Route('/especialidades/{id}', methods: ['PUT'])]
    public function atualiza(int $id, Request $request): Response
    {
        $especialidade = $this->especialidadeRepository->find($id);

        $especialidadeEnvio = json_decode($request->getContent());

        $especialidade->setDescricao($especialidadeEnvio->descricao);

        $this->entityManager->flush();

        return new JsonResponse($especialidade);
    }

    #[Route('/especialidades/{id}', methods: ['DELETE'])]
    public function remove(int $id): Response
    {
       $especialidade = $this->especialidadeRepository->find($id);
       $this->entityManager->remove($especialidade);
       $this->entityManager->flush();

       return new Response('', Response::HTTP_NO_CONTENT);
    }

}
