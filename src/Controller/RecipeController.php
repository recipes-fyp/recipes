<?php

namespace App\Controller;

use App\Entity\Recipe;
use App\Form\RecipeType;
use App\Repository\RecipeRepository;

use App\Entity\Coll;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/recipe")
 */
class RecipeController extends MyBaseController
{
    public function __construct() {
        parent::__construct(RecipeRepository::class);
    }
    /**    
    /**
     * @Route("/", name="recipe_index", methods="GET")
     */
    public function index(RecipeRepository $recipeRepository): Response
    {

        $recipes = $recipeRepository->findAllVisible($this->getUser());
        // $recipes = RecipeRepository::findAllVisible();

        /**
         * determine if user is
         * a) logged in
         * b) owns the recipe - on a recipe by recipe basis
         * ideally this would be in the Recipe entity itself
         */
        $isLoggedIn = $this->getUser();
        return $this->render('recipe/index.html.twig', 
            [
                'recipes' => $recipes , 
                "isLoggedIn"    =>  $isLoggedIn
        ]);
    }

    // /**    
    // /**
    //  * @Route("/coll/{id}", name="coll_recipe_index", methods="GET")
    //  */
    // public function coll_index(Coll $coll): Response
    // {

    //     return $this->render('recipe/index.html.twig', 
    //         [
    //             'recipes'       => $coll->getRecipes() , 
    //             "showHeader"    =>  false
    //     ]);
    // }



    /**
     * @Route("/new", name="recipe_new", methods="GET|POST")
     */
    public function new(Request $request): Response
    {
        $recipe = new Recipe();
        $recipe->setUser( $this->getUser());
        $form = $this->createForm(RecipeType::class, $recipe);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $recipe->setUser( $this->getUser());
            $this->save($recipe);
            return $this->redirectToRoute('recipe_index');
        }

        return $this->render('recipe/new.html.twig', [
            'recipe' => $recipe,
            'form' => $form->createView(),
        ]);
    }
    /**
     * @Route("/new/coll/{id}", name="coll_recipe_new", methods="GET|POST")
     */
    public function coll_new(Request $request,Coll $coll): Response
    {
        $recipe = new Recipe();
        $recipe->setUser( $this->getUser());
        $recipe->setColl($coll);
        $form = $this->createForm(RecipeType::class, $recipe);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $recipe->setUser( $this->getUser());
            $recipe->setColl($coll);
            $this->save($recipe);
            return $this->redirectToRoute('coll_show' , ['id' => $coll->getId() ] );
        }

        return $this->render('recipe/new.html.twig', [
            'recipe' => $recipe,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/show/{id}", name="recipe_show", methods="GET")
     */
    public function show(Recipe $recipe): Response
    {

        $recipe->_steps = explode( PHP_EOL , $recipe->getSteps() );
        $recipe->_ingredients = explode( PHP_EOL , $recipe->getIngredients() );

        return $this->render('recipe/show.html.twig', ['recipe' => $recipe]);
    }


    /**
     * @Route("/edit/{id}", name="recipe_edit", methods="GET|POST")
     */
    public function edit(Request $request, Recipe $recipe): Response
    {
        $form = $this->createForm(RecipeType::class, $recipe);

        if($recipe->getIsPublic()) {
            // make the isPublic field readonly or removed - cannot make private
            $form->get('isPublic')->isDisabled(true);       // doesn't work!!
            $form->remove('isPublic');
        }
        if( is_null($recipe->getCreated()) ) {
            $recipe->setCreated( new \DateTime() );
        }
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            //$recipe->user = $this->getUser();
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('recipe_show', ['id' => $recipe->getId()]);
        }

        return $this->render('recipe/edit.html.twig', [
            'recipe' => $recipe,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/delete/{id}", name="recipe_delete", methods="GET")
     */
    public function delete(Request $request, Recipe $recipe): Response
    {
            $em = $this->getDoctrine()->getManager();
            $em->remove($recipe);
            $em->flush();

        return $this->redirectToRoute('recipe_index');
    }


    /**
     * @Route("/delete/{id}", name="recipe_delete_verb", methods="DELETE")
     */
    public function delete_verb(Request $request, Recipe $recipe): Response
    {
        if ($this->isCsrfTokenValid('delete'.$recipe->getId(), $request->request->get('_token'))) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($recipe);
            $em->flush();
        }

        return $this->redirectToRoute('recipe_index');
    }

    /**
     * @Route("/share/{id}", name="recipe_share", methods="GET")
     */
    public function share(Recipe $recipe): Response
    {
        $recipe->setIsShared( !$recipe->getIsShared() );
        $this->_save($recipe);
        return $this->redirectToRoute('recipe_index');
    }
    /**
     * @Route("/public/{id}", name="recipe_public", methods="GET")
     */
    public function make_public(Recipe $recipe): Response
    {
        $recipe->setIsPublic(true);
        $this->_save($recipe);
        return $this->redirectToRoute('recipe_index');
    }

}
