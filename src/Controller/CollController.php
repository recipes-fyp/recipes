<?php

namespace App\Controller;

use App\Entity\Coll;
use App\Form\CollType;
use App\Repository\CollRepository;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/coll")
 */
class CollController extends MyBaseController
{
    /**
     * @Route("/", name="coll_index", methods="GET")
     */
    public function index(CollRepository $collRepository): Response
    {
        $colls = $collRepository->findAllVisible($this->getUser());
        return $this->render('coll/index.html.twig', ['colls' => $colls ]);
    }

    /**
     * @Route("/new", name="coll_new", methods="GET|POST")
     */
    public function new(Request $request): Response
    {
        $coll = new Coll();
        $form = $this->createForm(CollType::class, $coll);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $coll->setUser( $this->getUser());
            $this->save($coll);

            return $this->redirectToRoute('coll_index');
        }

        return $this->render('coll/new.html.twig', [
            'coll' => $coll,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/show/{id}", name="coll_show", methods="GET")
     */
    public function show(Coll $coll): Response
    {
        return $this->render('coll/show.html.twig', ['coll' => $coll]);
    }

    /**
     * @Route("/edit/{id}", name="coll_edit", methods="GET|POST")
     */
    public function edit(Request $request, Coll $coll): Response
    {
        $form = $this->createForm(CollType::class, $coll);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('coll_index', ['id' => $coll->getId()]);
        }

        return $this->render('coll/edit.html.twig', [
            'coll' => $coll,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/delete/{id}", name="coll_delete", methods="GET")
     */
    public function delete2(Request $request, Coll $coll): Response
    {
        $em = $this->getDoctrine()->getManager();
        $em->remove($coll);
        $em->flush();

        return $this->redirectToRoute('coll_index');
    }

    /**
     * @Route("/delete/{id}", name="coll_delete_verb", methods="DELETE")
     */
    public function delete(Request $request, Coll $coll): Response
    {
        if ($this->isCsrfTokenValid('delete'.$coll->getId(), $request->request->get('_token'))) {
            $em = $this->getDoctrine()->getManager();
            /*
                need to detach all associated recipes first

            */
            foreach ($coll->getRecipes() as $key => $recipe) {
                $recipe->setColl(null);
            }

            $em->remove($coll);
            $em->flush();
        }

        return $this->redirectToRoute('coll_index');
    }

    /**
     * @Route("/share/{id}", name="coll_share", methods="GET")
     */
    public function share(Coll $coll): Response
    {
        $coll->setIsShared( !$coll->getIsShared() );
        /*
            make each recipe in coll shared/not as well
            doesn't account for recipes added to collection afterwards!!
            recipes should take shared/public state of their collection - if set 
        */ 
        foreach ($coll->getRecipes() as $key => $recipe) {
                $recipe->setShared( $coll->getIsShared() );
        }
        $this->save($coll);
        return $this->redirectToRoute('coll_index');
    }
    /**
     * @Route("/public/{id}", name="coll_public", methods="GET")
     */
    public function make_public(Coll $coll): Response
    {
        $coll->setIsPublic(true);
        /*
            make each recipe in coll shared/not as well
            doesn't account for recipes added to collection afterwards!!
            recipes should take shared/public state of their collection - if set 
        */ 
        foreach ($coll->getRecipes() as $key => $recipe) {
                $recipe->setPublic( $coll->getIsPublic() );
        }

        $this->save($coll);
        return $this->redirectToRoute('coll_index');
    }


}
