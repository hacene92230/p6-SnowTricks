<?php

namespace App\Controller;

use App\Entity\Medias;
use App\Form\MediasType;
use App\Repository\MediasRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/medias')]
class MediasController extends AbstractController
{
    #[Route('/', name: 'app_medias_index', methods: ['GET'])]
    public function index(MediasRepository $mediasRepository): Response
    {
        return $this->render('medias/index.html.twig', [
            'medias' => $mediasRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_medias_new', methods: ['GET', 'POST'])]
    public function new(Request $request, MediasRepository $mediasRepository): Response
    {
        $media = new Medias();
        $form = $this->createForm(MediasType::class, $media);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $mediasRepository->save($media, true);

            return $this->redirectToRoute('app_medias_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('medias/new.html.twig', [
            'media' => $media,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_medias_show', methods: ['GET'])]
    public function show(Medias $media): Response
    {
        return $this->render('medias/show.html.twig', [
            'media' => $media,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_medias_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Medias $media, MediasRepository $mediasRepository): Response
    {
        $form = $this->createForm(MediasType::class, $media);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $mediasRepository->save($media, true);

            return $this->redirectToRoute('app_medias_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('medias/edit.html.twig', [
            'media' => $media,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_medias_delete', methods: ['POST'])]
    public function delete(Request $request, Medias $media, MediasRepository $mediasRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$media->getId(), $request->request->get('_token'))) {
            $mediasRepository->remove($media, true);
        }

        return $this->redirectToRoute('app_medias_index', [], Response::HTTP_SEE_OTHER);
    }
}
