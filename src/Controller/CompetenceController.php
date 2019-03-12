<?php

namespace App\Controller;

use App\Entity\Competence;
use App\Form\CompetenceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\CompetenceRepository;

/**
 * @Route("/competence", name="competence")
 */
class CompetenceController extends AbstractController
{


    /**
     * @Route("/new", methods = {"GET","POST"} , name ="competence_new")
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function new(Request $request)
    {
        $param = new Competence();
        $form = $this->createForm(CompetenceType::class, $param);
        $form->add('submit', SubmitType::class, [
            'label' => 'Ajouter une compétence',
            'attr' => ['class' => 'btn btn-default pull-right'],
        ]);


        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            //$param = $form->getData();
            $em = $this->getDoctrine()->getManager();
            $em->persist($param);
            $em->flush();
        }

        return $this->render('Competence/new.html.twig', array(
            'form' => $form->createView(),
        ));
    }

    /**
     *@Route("/edit/{competence}", methods = {"GET","POST"} , name ="competence_edit")
     *@param Request $request
     *@return \Symfony\Component\HttpFoundation\Response
     */
    public function edit (Request $request, Competence $comptence)
    {
        $form = $this->createForm(CompetenceType::class, $comptence);
        $form->add('submit', SubmitType::class, [
            'label' => 'Mettre à jour',
            'attr' => ['class' => 'btn btn-default pull-right'],
        ]);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            //$param = $form->getData();
            $em = $this->getDoctrine()->getManager();
            $em->persist($comptence);
            $em->flush();
        }

        return $this->render('Competence/new.html.twig', array(
            'form' => $form->createView(),
        ));
    }

    /**
     * @Route("/competence/liste/", name="competences_liste")
     */
    public function afficherListeAction()
    {
        $listCompetences= $this->getDoctrine()
            ->getRepository(Contrat::class)
            ->findAll();

        //------------------
        //On demande à la vue d'afficher la liste des jobs
        //------------------
        return $this->render('competence/list.html.twig',array('lesCompetences' => $listCompetences));
    }
}
