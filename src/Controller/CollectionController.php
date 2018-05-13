<?php

namespace App\Controller;

use App\Entity\Collection;
use App\Form\CollectionType;
use App\Repository\CollectionRepository;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/collection")
 */
class CollectionController extends Controller
{
    /**
     * @Route("/", name="collection_index", methods="GET")
     */
    public function index(CollectionRepository $collectionRepository): Response
    {
        return $this->render('collection/index.html.twig', ['collections' => $collectionRepository->findAll()]);
    }

    /**
     * @Route("/new", name="collection_new", methods="GET|POST")
     */
    public function new(Request $request): Response
    {
        $collection = new Collection();
        $form = $this->createForm(CollectionType::class, $collection);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($collection);
            $em->flush();

            return $this->redirectToRoute('collection_index');
        }

        return $this->render('collection/new.html.twig', [
            'collection' => $collection,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="collection_show", methods="GET")
     */
    public function show(Collection $collection): Response
    {
        return $this->render('collection/show.html.twig', ['collection' => $collection]);
    }

    /**
     * @Route("/{id}/edit", name="collection_edit", methods="GET|POST")
     */
    public function edit(Request $request, Collection $collection): Response
    {
        $form = $this->createForm(CollectionType::class, $collection);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('collection_edit', ['id' => $collection->getId()]);
        }

        return $this->render('collection/edit.html.twig', [
            'collection' => $collection,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="collection_delete", methods="DELETE")
     */
    public function delete(Request $request, Collection $collection): Response
    {
        if ($this->isCsrfTokenValid('delete'.$collection->getId(), $request->request->get('_token'))) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($collection);
            $em->flush();
        }

        return $this->redirectToRoute('collection_index');
    }
}
