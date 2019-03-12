<?php

namespace App\Controller;

use App\Entity\Contrat;
use App\Form\ContratType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use App\Repository\ContratRepository;


/**
 * @Route("/contrat", name="contrat")
 */
class ContratController extends AbstractController
{

    /**
     * @Route("/new", methods = {"GET","POST"} , name ="contrat_new")
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function new(Request $request)
    {
        $param = new Contrat();
        $form = $this->createForm(ContratType::class, $param);
        $form->add('submit', SubmitType::class, [
            'label' => 'Ajouter un contrat',
            'attr' => ['class' => 'btn btn-default pull-right'],
        ]);


        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            //$param = $form->getData();
            $em = $this->getDoctrine()->getManager();
            $em->persist($param);
            $em->flush();
        }

        return $this->render('Contrat/new.html.twig', array(
            'form' => $form->createView(),
        ));
    }

    /**
     *@Route("/edit/{contrat}", methods = {"GET","POST"} , name ="contrat_edit")
     *@param Request $request
     *@return \Symfony\Component\HttpFoundation\Response
     */
    public function edit (Request $request, Contrat $contrat)
    {
        $form = $this->createForm(ContratType::class, $contrat);
        $form->add('submit', SubmitType::class, [
            'label' => 'Mettre à jour',
            'attr' => ['class' => 'btn btn-default pull-right'],
        ]);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            //$param = $form->getData();
            $em = $this->getDoctrine()->getManager();
            $em->persist($contrat);
            $em->flush();
        }

        return $this->render('Contrat/new.html.twig', array(
            'form' => $form->createView(),
        ));
    }

    /**
     * @Route("/contrat/liste/", name="contrats_liste")
     */
    public function afficherListeAction()
    {
        $listContrats= $this->getDoctrine()
            ->getRepository(Contrat::class)
            ->findAll();

        //------------------
        //On demande à la vue d'afficher la liste des jobs
        //------------------
        return $this->render('contrat/list.html.twig',array('lesContrats' => $listContrats));
    }
}
