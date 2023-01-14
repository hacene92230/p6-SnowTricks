<?php

namespace App\Controller;

use App\Entity\Comments;
use App\Form\ContactType;
use App\Form\CommentsType;
use App\Repository\FigureRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
class HomeController extends AbstractController
{
    private $formFactory;

    public function __construct(FormFactoryInterface $formFactory)
    {
        $this->formFactory = $formFactory;
    }
    const FIGURES_PER_PAGE = 5;
    
    #[Route('/homes/page/{page}', name: 'app_home')]
    public function index(Request $request, FigureRepository $fgr, int $page = 1): Response
    {
        // Récupération du nombre total d'éléments à paginer
        $totalItems = $fgr->count([]);

        // Calcul du nombre total de pages en divisant le nombre total d'éléments par le nombre d'éléments par page
        $totalPages = ceil($totalItems / self::FIGURES_PER_PAGE);

        // Calcul de l'offset à partir du numéro de la page courante et du nombre d'éléments par page
        $offset = ($page - 1) * self::FIGURES_PER_PAGE;

        // Récupération des figures de la page courante à partir de l'offset et du nombre d'éléments par page
        $figures = $fgr->findBy([], [], self::FIGURES_PER_PAGE, $offset);

        // Création des formulaires de commentaire pour chaque figure
        $forms = [];
        foreach ($figures as $figure) {
            $comment = new Comments();
            $form = $this->formFactory->create(CommentsType::class, $comment);
            $form->handleRequest($request);
            $forms[$figure->getId()] = $form->createView();
            unset($form);
        }

        // Affichage de la vue avec les données de pagination
        return $this->renderForm('home/index.html.twig', [
            'figures' => $figures,
            'current_page' => $page,
            'figurePagesCount' => $totalPages,
            'forms' => $forms,
            'page' => $page,

            'total_pages' => $totalPages
        ]);
    }




    /**
     * @Route("/contact", name="home_contact")
     */
    public function contact(Request $request, MailerInterface $mailer): Response
    {
        $form = $this->createForm(ContactType::class);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $email = (new TemplatedEmail())
                ->from(new Address('hacenesahraoui.paris@gmail.com', 'Sahreply'))
                ->to("hacenesahraoui.paris@gmail.com")
                ->subject($form->get('request')->getData())
                ->htmlTemplate('contact/contact.html.twig')
                ->context([
                    "request" => $form->get('request')->getData(),
                    "addemail" => $form->get('email')->getData(),
                    "phone" => $form->get('phone')->getData(),
                    "content" => $form->get('content')->getData()
                ]);
            $mailer->send($email);
            $this->addFlash('success', 'Votre message a été transmis, nous vous répondrons dans les meilleurs délais.');
            return $this->redirectToRoute('home_contact');
        }
        return $this->render('contact/index.html.twig', ['contactForm' => $form->createView()]);
    }
}
