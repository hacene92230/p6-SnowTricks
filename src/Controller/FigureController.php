<?php

namespace App\Controller;

use App\Entity\Figure;
use App\Entity\Medias;
use DateTimeImmutable;
use App\Form\FigureType;
use App\Repository\FigureRepository;
use App\Repository\MediasRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/figure')]
class FigureController extends AbstractController
{
    #[Route('/', name: 'app_figure_index', methods: ['GET'])]
    public function index(FigureRepository $figureRepository): Response
    {
        return $this->render('figure/index.html.twig', [
            'figures' => $figureRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_figure_new', methods: ['GET', 'POST'])]
    public function new(Request $request, FigureRepository $figureRepository, MediasRepository $mediasRepository): Response
    {
        $figure = new Figure();
        $form = $this->createForm(FigureType::class, $figure);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $videos = $form->get('videos')->getData();
            $images = $form->get('images')->getData();
            if ($images == null and $videos == null) {
                $this->addFlash("danger", 'Vous devez mettre soit une vidéo, ou bien une image, les deux fonctionne, mais vous ne pouvez pas rien mettre');
                return $this->renderForm('figure/new.html.twig', [
                    'figure' => $figure,
                    'form' => $form,
                ]);
            }
            $figure->setCreatedAt(new DateTimeImmutable())
                ->setModifiedAt(new DateTimeImmutable())
                ->setAuthor($this->getUser());
            $medias = new Medias();
            try {
                // Vérifiez si un nouvel avatar a été téléchargé
                if ($images) {
                    // Vérifiez que l'image est au format JPG
                    if ($images->getMimeType() !== 'image/jpeg') {
                        throw new Exception('L\'image doit être au format JPG');
                    }
                    // Vérifiez que l'image a été correctement téléchargée
                    if (!$images->isValid()) {
                        throw new Exception('L\'image n\'a pas été correctement téléchargée');
                    }
                    // Générez un nom unique pour l'image en utilisant la date du jour et l'identifiant de l'utilisateur
                    $filename = uniqid() . '.jpg';
                    // Enregistrez l'image sur le serveur
                    $images->move($this->getParameter('figures_directory'), $filename);
                    // Mettez à jour l'avatar de l'utilisateur avec le nouveau nom de fichier
                    $medias->setImages($filename);
                }
            } catch (FileException $e) {
                // Affichez un message d'erreur et la trace de l'exception
                $this->addFlash('danger', $e->getMessage());
                return $this->redirectToRoute('app_home');
            }
            $medias->setVideos($videos)
                ->setFigures($figure);
            $figureRepository->save($figure, true);
            $mediasRepository->save($medias, true);
            $this->addFlash("success", 'Votre figure à correctement été créer');
            return $this->redirectToRoute('app_home');
        }
        return $this->renderForm('figure/new.html.twig', [
            'figure' => $figure,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_figure_show', methods: ['GET'])]
    public function show(Figure $figure): Response
    {
        return $this->render('figure/show.html.twig', [
            'figure' => $figure,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_figure_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Figure $figure, FigureRepository $figureRepository): Response
    {
        $form = $this->createForm(FigureType::class, $figure);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $figureRepository->save($figure, true);
            $this->addFlash("warning", "La modification s'est correctement effectuer");
            return $this->redirectToRoute('app_home');
        }

        return $this->renderForm('figure/edit.html.twig', [
            'figure' => $figure,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_figure_delete', methods: ['POST'])]
    public function delete(Request $request, Figure $figure, FigureRepository $figureRepository): Response
    {
        if ($this->isCsrfTokenValid('delete' . $figure->getId(), $request->request->get('_token'))) {
            $figureRepository->remove($figure, true);
            foreach ($figure->getMedias() as $cle => $valeur) {
                $file = $this->getParameter('figures_directory') . "/" . $valeur->getImages();
                if (is_file($file)) {
                    unlink($file);
                }
            }
        }
        $this->addFlash("danger", "La figure ainsi que tout les éléments associés viennent d'être supprimer");
        return $this->redirectToRoute('app_home');
    }
}
