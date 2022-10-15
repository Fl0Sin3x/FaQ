<?php

namespace App\Controller;

use App\Entity\Answer;
use App\Entity\Question;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/answer', name: 'app_answer')]
class AnswerController extends AbstractController
{

    public function index(): Response
    {
        return $this->render('answer/index.html.twig', [
            'controller_name' => 'AnswerController',
        ]);
    }

    #[Route('/answer/{id}', name: 'answer_validate')]
    public function show(Question $question, Request $request, EntityManagerInterface $manager)
    {

        $answer = new Answer();

        $form = $this->createForm(CommentType::class, $answer);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $answer->setAd($question->getAnswers())
                ->setAuthor($this->getUser());

            $manager->persist($answer);
            $manager->flush();

            $this->addFlash(
                'success',
                "Votre commentaire a bien été "
            );
        }


        return $this->render('question/view.html.twig', [
            'question' => $question,
            'form' => $form->createView()
        ]);
    }
}
