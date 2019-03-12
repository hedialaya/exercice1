<?php

namespace App\Controller;

use App\Entity\Job;
use App\Entity\Offre;
use App\Form\JobType;
use App\Form\OffreType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\JobRepository;

/**
 * @Route("/offre", name="offre")
 */
class OffreController extends AbstractController
{

    /**
     * @Route("/new", methods = {"GET","POST"} , name ="offre_new")
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function new(Request $request)
    {
        $param = new Offre();
        $form = $this->createForm(OffreType::class, $param);
        $form->add('submit', SubmitType::class, [
            'label' => 'Ajouter une offre',
            'attr' => ['class' => 'btn btn-default pull-right'],
        ]);


        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            //$param = $form->getData();
            $em = $this->getDoctrine()->getManager();
            $em->persist($param);
            $em->flush();
        }

        return $this->render('Offre/new.html.twig', array(
            'form' => $form->createView(),
        ));
    }



    /**
     *@Route("/edit/{offre}", methods = {"GET","POST"} , name ="offre_edit")
     *@param Request $request
     *@return \Symfony\Component\HttpFoundation\Response
     */
    public function edit (Request $request, Offre $offre)
    {
        $form = $this->createForm(OffreType::class, $offre);
        $form->add('submit', SubmitType::class, [
            'label' => 'Mettre à jour',
            'attr' => ['class' => 'btn btn-default pull-right'],
        ]);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            //$param = $form->getData();
            $em = $this->getDoctrine()->getManager();
            $em->persist($offre);
            $em->flush();
        }

        return $this->render('Offre/new.html.twig', array(
            'form' => $form->createView(),
        ));
    }

    /**
     * @Route("/job/liste/", name="offre_liste")
     */
    public function afficherListeAction()
    {
        $listOffres= $this->getDoctrine()
            ->getRepository(Offre::class)
            ->findAll();

        //------------------
        //On demande à la vue d'afficher la liste des jobs
        //------------------
        return $this->render('offre/list.html.twig',array('lesOffres' => $listOffres));
    }
}
