<?php

namespace App\Controller;

use App\Entity\Book;
use App\Form\SchoolType;
use App\Repository\BookRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class SchoolController extends AbstractController
{
    /**
     * @Route("/", name="app_home")
     */
    public function index(Request $request, EntityManagerInterface $em, BookRepository $bookRepository)  : Response
    {
        $school = new Book();

        $form = $this->createForm(SchoolType::class, $school);
        
        
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $school = $form->getData();

            $em->persist($school);
            $em->flush();

            return $this->redirectToRoute('app_home');

        }
    
        return $this->render('school/index.html.twig', [
            'form' => $form->createView(),
            'books' => $bookRepository->findAll(),
        ]);
    }
}
