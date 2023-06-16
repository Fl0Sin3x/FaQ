<?php

namespace App\Controller;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Form\QuestionType;
use App\Entity\Question;

#[Route('/question', name: 'question_')]
class QuestionController extends AbstractController
{
    private EntityManagerInterface $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    #[Route('/question', name: 'app_question')]
    public function index(): Response
    {
        return $this->render('question/index.html.twig', [
            'controller_name' => 'QuestionController',
        ]);
    }

    #[Route('/{id}/view', name: 'view', requirements: ['id' => '\d+'], methods: ['GET'])]
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
    public function addQuestion(Request $request, EntityManagerInterface $em)
    {
        $newQuestion = new Question();
        $form = $this->createForm(QuestionType::class, $newQuestion);

        $form->handleRequest($request);
        if ($form->isSubmitted()) {
            $newQuestion->setUser($this->getUser());
            $em->persist($newQuestion);
            $em->flush();
            return $this->redirectToRoute('question_list');
        }
        return $this->render(
            'question/add.html.twig',
            [
                'form' => $form->createView(),
            ]
        );
    }

}
