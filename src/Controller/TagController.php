<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use App\Repository\TagRepository;
use App\Form\TagType;
use App\Entity\Tag;

#[Route('/admin/tag', name: 'admin_tag_')]
class TagController extends AbstractController
{
    #[Route('/', name: 'list_tag', methods: ['GET'])]
    public function index(TagRepository $tagRepository): Response
    {
        return $this->render('tag/list.html.twig', ['tag' => $tagRepository->findAll()]);
    }

    #[Route('/new', name: 'new', methods: ['GET', 'POST'])]
    public function new(Request $request): Response
    {
        $tag = new Tag();
        $form = $this->createForm(TagType::class, $tag);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($tag);
            $em->flush();

            $this->addFlash('success', 'Tag ajouté.');

            return $this->redirectToRoute('tag_index');
        }

        return $this->render('tag/new.html.twig', [
            'tag' => $tag,
            'form' => $form->createView(),
        ]);
    }

    #[Route('/{id}', name: 'tag_show', methods: ['GET', 'POST'])]
    public function show(Tag $tag): Response
    {
        return $this->render('tag/show.html.twig', ['tag' => $tag]);
    }

    #[Route('{id}/edit', name: 'tag_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Tag $tag): Response
    {
        $form = $this->createForm(TagType::class, $tag);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            $this->addFlash('success', 'Tag modifié.');

            return $this->redirectToRoute('tag_edit', ['id' => $tag->getId()]);
        }

        return $this->render('tag/edit.html.twig', [
            'tag' => $tag,
            'form' => $form->createView(),
        ]);
    }

    #[Route('/{id}', name: 'tag_delete', methods: ['DELETE'])]
    public function delete(Request $request, Tag $tag): Response
    {
        if ($this->isCsrfTokenValid('delete' . $tag->getId(), $request->request->get('_token'))) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($tag);
            $em->flush();

            $this->addFlash('success', 'Tag supprimé.');

        }

        return $this->redirectToRoute('tag_index');
    }
}
