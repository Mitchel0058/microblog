<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Blog;
use App\Form\BlogFormType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;

class BlogController extends AbstractController
{
    #[Route('/', name: 'homepage')]
    public function indexAction(EntityManagerInterface $entityManager): Response
    {
        $blogs = $entityManager->getRepository(Blog::class)->findAll();

        return $this->render('blog/index.html.twig', [
            'blogs' => $blogs,
        ]);
    }

    #[Route('/create', name: 'createBlog')]
    public function create(Request $request, EntityManagerInterface $entityManager): Response
    {
        $blog = new Blog();

        $form = $this->createForm(BlogFormType::class, $blog);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($blog);
            $entityManager->flush();
            return new response('Successfully created id ' . $blog->getId());
        }

        return $this->render('blog/create.html.twig', [
            'blog_form' => $form->createView(),
        ]);
    }

    #[Route('/blog/{id<\d+>}/edit', name: 'editBlog')]
    public function edit(Request $request, EntityManagerInterface $entityManager): Response
    {


        return new response('To add edit');
    }

    #[Route('/blog/{id<\d+>/delete}', name: 'deleteBlog')]
    public function delete(Request $request, EntityManagerInterface $entityManager): Response
    {


        return new response('To add delete');
    }

    #[Route('/blog/{id<\d+>}', name: 'showBlog')]
    public function show(Request $request, EntityManagerInterface $entityManager): Response
    {


        return new response('To add show');
    }
}
