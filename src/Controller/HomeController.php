<?php

namespace App\Controller;

use App\Entity\Question;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    #[Route('/', name: 'app_home')]
    public function index(): Response
    {
        $questions = $this->getDoctrine()->getRepository(Question::class)->findAll();
        return $this->render('question/list.html.twig', [
            'questions' => $questions,
        ]);
    }
}
