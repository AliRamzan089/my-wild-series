<?php

namespace App\Controller;

use App\Entity\Category;
use App\Entity\Program;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/category", name="category_")
 */
class CategoryController extends AbstractController
{
    /**
     * @Route("/", name="index")
     */
    public function index(): Response
    {
        $categories = $this->getDoctrine()
             ->getRepository(Category::class)
             ->findAll();

        return $this->render(
             'category/index.html.twig',
             ['categories' => $categories]
         );
    }

    /**
     * Getting a category by name.
     *
     * @Route("/{name}", name="show")
     */
    public function show(string $name): Response
    {
        $category = $this->getDoctrine()
            ->getRepository(Category::class)
            ->findOneBy(['name' => $name]);

        $program = $this->getDoctrine()
            ->getRepository(Program::class)
            ->findAll(['category' => $category]);

        if (!$program) {
            throw $this->createNotFoundException('No program with category : '.$category.' found in program\'s table.');
        }

        return $this->render('category/show.html.twig', [
            'category' => $category,
            'program' => $program,
        ]);
    }
}
