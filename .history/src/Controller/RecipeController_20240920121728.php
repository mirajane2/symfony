<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use App\Repository\RecipeRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;

class RecipeController extends AbstractController
{
    #[Route('/recettes', name: 'recipe.index')]
    public function index(Request $request, RecipeRepository $repository): Response
    {
        $recipes = $repository -> findWithDurationLowerThan(100);
        return $this -> render('recipe/index.html.twig', [
            'recipes' => $recipes
        ]);
    }

    #[Route('/recettes/{slug}-{id}', name: 'recipe.show', requirements: ['id' =>  '\d+', 'slug' => '[a-z0-9-]+'])]
    public function show(Request $request, string $slug, int $id, RecipeRepository $repository): Response
    {
        $recipe = $repository -> findOneBy(['slug' => $slug]);
        dd($recipe);
        if ($recipe -> getSlug() != $slug){
            return $this -> render('recipe.show', ['slug' => $recipe -> getSlug(), 'id' => $recipe -> getId()]);
        }
        return $this -> redirectToRoute('recipe/show.html.twig', [
            'slug' => $slug,
            'id' => $id
        ]);
    }
}
