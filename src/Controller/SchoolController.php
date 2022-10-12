<?php

namespace App\Controller;

use App\Entity\Book;
use App\Form\SchoolType;
use App\Repository\BookRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class SchoolController extends AbstractController
{
    public function __construct()
    {
        
    }
   
    /**
     * @Route("/", name="app_home")
     */
    public function index(Request $request, EntityManagerInterface $em, BookRepository $bookRepository, MailerInterface $mailer)  : Response
    {
        $school = new Book();

        $form = $this->createForm(SchoolType::class, $school);
        
        
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $school = $form->getData();
            $school->setToken($this->generateToken());
            $em->persist($school);
            $em->flush();
        
            $email = (new TemplatedEmail())
                ->from('thanigainayagam@yahoo.fr')
                ->to('thanigainayagam@yahoo.fr')
                ->subject('Thanks for signing up!')

                // path of the Twig template to render
                ->htmlTemplate('emails/clientmail.html.twig')

                // pass variables (name => value) to the template
                ->context([
                    'token' => $school->getToken(),
                ]);
                
                try {
                    $mailer->send($email);
                } catch (TransportExceptionInterface $e) {
                    dd($e);
                } 
            return $this->redirectToRoute('app_home');

        }
    
        return $this->render('school/index.html.twig', [
            'form' => $form->createView(),
            'books' => $bookRepository->findAll(),
        ]);
    }


    public function generateToken()
    {
        return rtrim(strtr(base64_encode(random_bytes(32)), '+/', '-_'),  '=');
    }
    
}
