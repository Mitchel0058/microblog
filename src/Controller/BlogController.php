<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Blog;
use App\Form\BlogFormType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\String\Slugger\SluggerInterface;
use Symfony\Component\HttpFoundation\File\Exception\FileException;

class BlogController extends AbstractController
{
    #[Route('/', name: 'homepage')]
    public function indexAction(EntityManagerInterface $entityManager): Response
    {
        $blogs = $entityManager->getRepository(Blog::class)->findBy([], ['id' => 'DESC']);

        return $this->render('blog/index.html.twig', [
            'blogs' => $blogs,
        ]);
    }

    #[Route('/create', name: 'createBlog')]
    public function create(Request $request, EntityManagerInterface $entityManager, SluggerInterface $slugger): Response
    {
        $blog = new Blog();

        $form = $this->createForm(BlogFormType::class, $blog);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $mainImageFile = $form->get('MainImage')->getData();
            $subImageFiles = $form->get('SubImages')->getData();

            if ($mainImageFile) {
                $originalFilename = pathinfo($mainImageFile->getClientOriginalName(), PATHINFO_FILENAME);
                // this is needed to safely include the file name as part of the URL
                $safeFilename = $slugger->slug($originalFilename);
                $newFilename = $safeFilename . '-' . uniqid() . '.' . $mainImageFile->guessExtension();

                // Move the file to the directory where brochures are stored
                try {
                    $mainImageFile->move(
                        $this->getParameter('mainImage_directory'),
                        $newFilename
                    );
                } catch (FileException $e) {
                    // ... handle exception if something    happens during file upload
                    var_dump($e);
                }

                // updates the 'mainImageFileName' property to store the PDF file name
                // instead of its contents
                $blog->setMainImage($newFilename);
            }

            foreach ($subImageFiles as $subImageFile) {
                if ($subImageFile) {
                    $originalFilename = pathinfo($subImageFile->getClientOriginalName(), PATHINFO_FILENAME);
                    $safeFilename = $slugger->slug($originalFilename);
                    $newFilename = $safeFilename . '-' . uniqid() . '.' . $subImageFile->guessExtension();

                    try {
                        $subImageFile->move(
                            $this->getParameter('subImages_directory'),
                            $newFilename
                        );
                    } catch (FileException $e) {
                        var_dump($e);
                    }
                    $blog->addSubImages($newFilename);
                }
            }

            $entityManager->persist($blog);
            $entityManager->flush();
            return $this->redirectToRoute('homepage');
        }

        return $this->render('blog/create.html.twig', [
            'blog_form' => $form->createView(),
        ]);
    }

    #[Route('/blog/{id<\d+>}/edit', name: 'editBlog')]
    public function edit(Request $request, EntityManagerInterface $entityManager, Blog $blog, SluggerInterface $slugger): Response
    {
        $form = $this->createForm(BlogFormType::class, $blog);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $mainImageFile = $form->get('MainImage')->getData();
            $subImageFiles = $form->get('SubImages')->getData();

            if ($mainImageFile) {
                $originalFilename = pathinfo($mainImageFile->getClientOriginalName(), PATHINFO_FILENAME);
                // this is needed to safely include the file name as part of the URL
                $safeFilename = $slugger->slug($originalFilename);
                $newFilename = $safeFilename . '-' . uniqid() . '.' . $mainImageFile->guessExtension();

                // Move the file to the directory where brochures are stored
                try {
                    $mainImageFile->move(
                        $this->getParameter('mainImage_directory'),
                        $newFilename
                    );
                } catch (FileException $e) {
                    // ... handle exception if something    happens during file upload
                    var_dump($e);
                }

                // updates the 'mainImageFileName' property to store the PDF file name
                // instead of its contents
                $blog->setMainImage($newFilename);
            }

            foreach ($subImageFiles as $subImageFile) {
                if ($subImageFile) {
                    $originalFilename = pathinfo($subImageFile->getClientOriginalName(), PATHINFO_FILENAME);
                    $safeFilename = $slugger->slug($originalFilename);
                    $newFilename = $safeFilename . '-' . uniqid() . '.' . $subImageFile->guessExtension();

                    try {
                        $subImageFile->move(
                            $this->getParameter('subImages_directory'),
                            $newFilename
                        );
                    } catch (FileException $e) {
                        var_dump($e);
                    }
                    $blog->addSubImages($newFilename);
                }
            }

            $entityManager->persist($blog);
            $entityManager->flush();
            return $this->redirect('homepage');
        }
        return $this->render('blog/edit.html.twig', [
            'blog_form' => $form->createView()
        ]);
    }

    #[Route('/blog/{id<\d+>/delete}', name: 'deleteBlog')]
    public function delete(Request $request, EntityManagerInterface $entityManager): Response
    {

        return new response('To add delete');
    }

    #[Route('/blog/{id<\d+>}', name: 'showBlog')]
    public function show(Request $request, EntityManagerInterface $entityManager, $id): Response
    {
        $blog = $entityManager->getRepository(Blog::class)->findById($id);

        return $this->render('blog/show.html.twig', ['blog' => $blog[0]]);
    }
}
