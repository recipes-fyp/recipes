<?php

namespace App\Controller;

use App\Entity\Comment;
use App\Form\CommentType;
use App\Entity\Recipe;

use App\Repository\CommentRepository;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/recipe/{recipeId}/comment")
 */
class CommentController extends MyBaseController
{

    private $recipe;
    public function __construct() { // string $recipeId
        // parent::__construct(CommentRepository::class);
        // $recipe = $this->getDoctrine()
        //     ->getRepository(Recipe::class)
        //     ->find($recipeId);       

    }
    /**
     * @Route("/", name="comment_index", methods="GET")
     */
    public function index(CommentRepository $commentRepository,$recipeId): Response
    {
        return $this->render('comment/index.html.twig', [
            'recipeId' => $recipeId ,
            'comments' => $commentRepository->findAll()
        ]);
    }

    /**
     * @Route("/new/", name="comment_new", methods="GET|POST")
     */
    public function new(Request $request,$recipeId): Response
    {
        $comment = new Comment();
        $comment->setUser( $this->getUser() );
        $recipe = $this->getDoctrine()
            ->getRepository(Recipe::class)
            ->find($recipeId);   
        $comment->setRecipe($recipe);

        $form = $this->createForm(CommentType::class, $comment);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $comment->setRecipe($recipe);
            $comment->setUser( $this->getUser() );
            $em = $this->getDoctrine()->getManager();

            $em->persist($comment);
            $em->flush();

            return $this->redirectToRoute('recipe_show' , ['id' => $recipeId ]);
        }

        return $this->render('comment/new.html.twig', [
            'comment' => $comment,
            'recipeId' => $recipeId ,
            'recipe'    => $recipe ,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/show/{id}", name="comment_show", methods="GET")
     */
    public function show(Comment $comment,$recipeId): Response
    {
        return $this->render('comment/show.html.twig', ['recipeId' => $recipeId, 'comment' => $comment]);
    }

    /**
     * @Route("/edit/{id}", name="comment_edit", methods="GET|POST")
     */
    public function edit(Request $request, Comment $comment,$recipeId): Response
    {
        $form = $this->createForm(CommentType::class, $comment);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('comment_edit', ['recipeId' => $recipeId, 'id' => $comment->getId()]);
        }

        return $this->render('comment/edit.html.twig', [
            'recipeId' => $recipeId,
            'comment' => $comment,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/delete/{id}", name="comment_delete", methods="DELETE")
     */
    public function delete(Request $request, Comment $comment,$recipeId): Response
    {
        if ($this->isCsrfTokenValid('delete'.$comment->getId(), $request->request->get('_token'))) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($comment);
            $em->flush();
        }

        return $this->redirectToRoute('recipe_show' , ['id' => $recipeId,]);
    }
}
