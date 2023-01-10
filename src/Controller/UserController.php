<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserType;
use App\Repository\UserRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

#[Route('/user')]
class UserController extends AbstractController
{
    #[Route('/', name: 'app_user_index', methods: ['GET'])]
    public function index(UserRepository $userRepository): Response
    {
        return $this->render('user/index.html.twig', [
            'users' => $userRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_user_new', methods: ['GET', 'POST'])]
    public function new(Request $request, UserRepository $userRepository): Response
    {
        $user = new User();
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $userRepository->save($user, true);

            return $this->redirectToRoute('app_user_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('user/new.html.twig', [
            'user' => $user,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_user_show', methods: ['GET'])]
    public function show(User $user): Response
    {
        return $this->render('user/show.html.twig', [
            'user' => $user,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_user_edit', methods: ['GET', 'POST'])]
    public function edit(UserPasswordHasherInterface $userPasswordHasher, Request $request, User $user, UserRepository $userRepository): Response
    {
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            if ($this->getUser() == $user) {
                // Récupérez l'image téléchargée
                $image = $form->get('avatar')->getData();

                try {
                    // Vérifiez si un nouvel avatar a été téléchargé
                    if ($image) {
                        // Vérifiez que l'image est au format JPG
                        if ($image->getMimeType() !== 'image/jpeg') {
                            throw new Exception('L\'image doit être au format JPG');
                        }
                        // Vérifiez que l'image a été correctement téléchargée
                        if (!$image->isValid()) {
                            throw new Exception('L\'image n\'a pas été correctement téléchargée');
                        }
                        // Générez un nom unique pour l'image en utilisant la date du jour et l'identifiant de l'utilisateur
                        $filename = date('Y-m-d') . '-' . microtime(true) . '.jpg';
                        if (empty($this->getUser()->getAvatar()) or $this->getUser()->getAvatar() != $filename) {
                            // Enregistrez l'image sur le serveur
                            $image->move($this->getParameter('images_directory'), $filename);
                            // Mettez à jour l'avatar de l'utilisateur avec le nouveau nom de fichier
                            $user->setAvatar($filename);
                        }
                    }
                } catch (FileException $e) {
                    // Affichez un message d'erreur et la trace de l'exception
                    $this->addFlash('danger', $e->getMessage());
                    return $this->redirectToRoute('app_home');
                }
                // encode the plain password
                $userHashForm = $userPasswordHasher->hashPassword(
                    $user,
                    $form->get('plainPassword')->getData()
                );
                if ($this->getUser()->getPassword() != $userHashForm) {
                    $user->setPassword($userHashForm);
                }
                $userRepository->save($user, true);
                return $this->redirectToRoute('app_home', [], Response::HTTP_SEE_OTHER);
            }
        }
        return $this->renderForm('user/edit.html.twig', [
            'user' => $user,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_user_delete', methods: ['POST'])]
    public function delete(Request $request, User $user, UserRepository $userRepository): Response
    {
        if ($this->isCsrfTokenValid('delete' . $user->getId(), $request->request->get('_token'))) {
            $userRepository->remove($user, true);
        }

        return $this->redirectToRoute('app_user_index', [], Response::HTTP_SEE_OTHER);
    }
}
