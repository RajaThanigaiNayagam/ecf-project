<?php

namespace App\Controller;

use App\Entity\Book;
use App\Form\SchoolType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class SchoolController extends AbstractController
{
    /**
     * @Route("/", name="app_home")
     */
    public function index(Request $request, EntityManagerInterface $em): Response
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
            'controller_name' => 'SchoolController',
        ]);
    }
}
