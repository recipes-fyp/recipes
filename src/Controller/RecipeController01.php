<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;


use App\Entity\Recipe;

class RecipeController01 extends Controller {
	/**
	 * @Route("/")
	 */
	public function index() {
		// return new Response("hello");
		$recipes = $this->getDoctrine()->getRepository(Recipe::class)->findAll();
		return $this->render('recipes/index.html.twig' , [ 'recipes' => $recipes ]);
	}

	/**
	 * @Route("/recipe/display/{id}")
	 */
	public function display($id) {

		$recipe = $this->getDoctrine()->getRepository(Recipe::class)->find($id);

		$recipe->_steps = explode( PHP_EOL , $recipe->getSteps() );
		$recipe->_ingredients = explode( PHP_EOL , $recipe->getIngredients() );

		return $this->render("recipes/display.html.twig" , ['recipe' => $recipe ]);

	}

	/**
	 * @Route("/recipe/new" , name = "recipe_new" )
	 */
	public function new(Request $request) {
		$recipe = new Recipe();

		$form = $this->createFormBuilder($recipe)
		->add("title" , TextType::class , [ 'attr' => [ 'class' => 'form-control'] ] )
		->add("summary" , TextType::class , [ 'attr' => [ 'class' => 'form-control'] ] )
		->add("steps" , TextareaType::class , [ 'attr' => [ 'class' => 'form-control'] ] )
		->add("ingredients" , TextareaType::class , [ 'attr' => [ 'class' => 'form-control'] ] )
		->add("save" , SubmitType::class , [ 'label' => 'Create' , 'attr' => [ 'class' => 'btn btn-primary mt-3'] ])
		->getForm();

		$form->handleRequest($request);
		if($form->isSubmitted()) {
			if($form->isValid()) {
				$recipe = $form->getData();

			 	$em = $this->getDoctrine()->getManager();

			 	$em->persist($recipe);
			 	$em->flush();

			 	return $this->redirect("/");
			}
		}

		return $this->render('recipes/new.html.twig' , [ 'form' => $form->createView() ]);
	}

	/**
	 * @Route("/recipe/init")
	 */
	 public function init() {

	 	$em = $this->getDoctrine()->getManager();
	 	
	 	$recipe = new Recipe();
	 	$recipe->setTitle("Scrambled Eggs")
	 		->setSummary("The old breakfast classic - Scrambled Eggs")
	 		->setSteps(<<<EOF
				1. Break half dozen eggs into a bowl
				2. Add 1/4 pint of cream
				3. Add a pinch of salt and pepper to season
				4. Whisk gently until frothy
				5. Add a knob of butter to a gently heated pot
				6. Add whisked eggs to pot
				7. Stir gently using a wooden spoon/spatula ensuring eggs do not stick to bottom of pot
				8. Remove eggs onto plate when golden yellow and still slightly moist
				9. Serve
EOF
	 		)->setIngredients(<<<EOF
				6 eggs
				1/4 (100ml) pint cream
				salt and pepper
				knob (2g) botter
EOF
	 		);

	 	$em->persist($recipe);
	 	$em->flush();

	 	return new Response("Saved a new Recipe with ID " . $recipe->getId() );
	 }
}
