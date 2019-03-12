<?php

namespace App\Controller;

use App\Entity\Candidature;
use App\Form\CandidatureType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\CandidatureRepository;


/**
 * @Route("/candidature", name="candidature")
 */
class CandidatureController extends AbstractController
{

    /**
     * @Route("/new", methods = {"GET","POST"}, name ="candidature_new")
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function new(Request $request)
    {
        $candidature = new Candidature();
        $form = $this->createForm(CandidatureType::class, $candidature);
        $form->add('submit', SubmitType::class, [
            'label' => 'Créer une candidature',
            'attr' => ['class' => 'btn btn-default pull-right'],
        ]);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            $em = $this->getDoctrine()->getManager();
            $em->persist($candidature);
            $em->flush();
        }

        return $this->render('Candidature/new.html.twig', array(
            'form' => $form->createView(),
        ));
    }

    /**
     *@Route("/edit/{candidature}", methods = {"GET","POST"}, name ="Candidature_edit")
     *@param Request $request
     *@return \Symfony\Component\HttpFoundation\Response
     */
    public function edit (Request $request, Candidature $candidature)
    {
        $form = $this->createForm(CandidatureType::class, $candidature);
        $form->add('submit', SubmitType::class, [
            'label' => 'Mettre à jour ',
            'attr' => ['class' => 'btn btn-default pull-right'],
        ]);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            $em = $this->getDoctrine()->getManager();
            $em->persist($candidature);
            $em->flush();
        }

        return $this->render('Candidature/edit.html.twig', array(
            'form' => $form->createView(),
        ));
    }

    /**
     * @Route("/candidature/liste/", name="candidatures_liste")
     */
    public function afficherListeAction()
    {
        $listCandidatures= $this->getDoctrine()
            ->getRepository(Contrat::class)
            ->findAll();

        //------------------
        //On demande à la vue d'afficher la liste des jobs
        //------------------
        return $this->render('competence/list.html.twig',array('lesCandidas' => $listCandidatures));
    }
}
