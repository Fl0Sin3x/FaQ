<?php

namespace App\Controller;

use App\Entity\Question;
use App\Form\QuestionType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/question', name: 'question_')]
class QuestionController extends AbstractController
{
    #[Route('/question', name: 'app_question')]
    public function index(): Response
    {
        return $this->render('question/index.html.twig', [
            'controller_name' => 'QuestionController',
        ]);
    }

    #[Route('/{id}/view', name: 'view' , requirements: ['id' => '\d+'], methods: ['GET'])]
    public function viewCategory(Question $question): Response
    {
        return $this->render('question/view.html.twig', [
            'question' => $question,
        ]);
    }

    #[Route('/list', name: 'list', methods: ['GET'])]
    public function listQuestion()
    {
        $questions = $this->getDoctrine()->getRepository(Question::class)->findAll();
        return $this->render('question/list.html.twig', [
            'questions' => $questions,
        ]);
    }

    #[Route('/add', name: 'add')]
    public function addQuestion(Request $request)
    {
        $newQuestion = new Question();
        $form = $this->createForm(QuestionType::class, $newQuestion);

        $form->handleRequest($request);
        if($form->isSubmitted()) {
            $manager = $this->getDoctrine()->getManager();
            $manager->persist($newQuestion);
            $manager->flush();
            return $this->redirectToRoute('question_list');
        }
        // on envoi le formulaire a la template
        return $this->render(
            'question/add.html.twig',
            [
                'form' => $form->createView(),
            ]
        );
    }
}
