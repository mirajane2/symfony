<?php

namespace App\Controller\Admin;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use App\Repository\RecipeRepository;
use App\Repository\CategoryRepository;
use App\Entity\Recipe;
use App\Form\RecipeType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Routing\Requirement\Requirement;

#[Route('/admin/recettes', name: 'admin.recipe.')]
class RecipeController extends AbstractController
{
    #[Route('/', name: 'index')]
    public function index(Request $request, RecipeRepository $repository, CategoryRepository $categoryRepository, EntityManagerInterface $entityManager): Response
    {
        $platPrincipal = $categoryRepository -> findOneBy(['slug' => 'plat-principal']);
        $pates = $repository -> findOneBy(['slug' => 'pates-bolognaise']);
        $pates -> setCategory($platPrincipal);
        $entityManager -> flush();
        $recipes = $repository -> findWithDurationLowerThan(100);
        return $this -> render('admin/recipe/index.html.twig', [
            'recipes' => $recipes
        ]);
    }

    #[Route('/{id}', name : 'edit', methods: ['GET', 'POST'] , requirements : ['id'=> Requirement::DIGITS])]
    public function edit(Recipe $recipe, Request $request, EntityManagerInterface $em){
        $form = $this ->createForm(RecipeType::class, $recipe);
        $form ->handleRequest($request);
        if ($form -> isSubmitted() && $form -> isValid()){
            $recipe -> setUpdatedAt(new \DateTimeImmutable() );
            $em -> flush();
            $this -> addFlash('success', 'la recette a été modifié'); 
            return $this -> redirectToRoute('admin.recipe.index');
        }
        return $this->render('admin/recipe/edit.html.twig', [
           'recipe' => $recipe,
           'form' => $form
        ]);
    }
    #[Route('/create', name : 'create')]
    public function create(Request $request, EntityManagerInterface $em){
        $recipe = new Recipe();
        $form = $this ->createForm(RecipeType::class, $recipe);
        $form ->handleRequest($request);
        if ($form -> isSubmitted() && $form -> isValid()){
            $recipe -> setCreatedAt(new \DateTimeImmutable() );
            $recipe -> setUpdatedAt(new \DateTimeImmutable() );
            $em -> persist($recipe);
            $em -> flush();
            $this -> addFlash('success', 'la recette a été créée'); 
            return $this -> redirectToRoute('admin.recipe.index');
        }
        return $this->render('admin/recipe/create.html.twig', [
           'form' => $form
        ]);
    }

    #[Route('/{id}', name : 'delete', methods:['DELETE'], requirements : ['id'=> Requirement::DIGITS])]
    public function remove(Recipe $recipe, EntityManagerInterface $em){
        $em -> remove($recipe);
        $em -> flush();
        $this -> addflash('success','La recette a bien été supprime');
        return $this -> redirectToRoute('admin.recipe.index');
    }
}
