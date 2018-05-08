<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use App\Entity\Recipe;

class RecipeController extends Controller {
	/**
	 * @Route("/")
	 */
	public function index() {
		// return new Response("hello");
		$recipes = $this->getDoctrine()->getRepository(Recipe::class)->findAll();
		return $this->render('recipes/index.html.twig' , [ 'recipes' => $recipes ]);
	}

	/**
	 * @Route("/recipe/{id}")
	 */
	public function recipe($id) {

		$recipe = $this->getDoctrine()->getRepository(Recipe::class)->find($id);

		$recipe->_steps = explode( PHP_EOL , $recipe->getSteps() );
		$recipe->_ingredients = explode( PHP_EOL , $recipe->getIngredients() );

		return $this->render("recipes/display.html.twig" , ['recipe' => $recipe ]);

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
