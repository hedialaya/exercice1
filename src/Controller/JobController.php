<?php

namespace App\Controller;

use App\Entity\Job;
use App\Form\JobType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\JobRepository;

/**
 * @Route("/job", name="job")
 */
class JobController extends AbstractController
{

    /**
     * @Route("/new", methods = {"GET","POST"} , name ="job_new")
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function new(Request $request)
    {
        $param = new Job();
        $form = $this->createForm(JobType::class, $param);
        $form->add('submit', SubmitType::class, [
            'label' => 'Ajouter un job',
            'attr' => ['class' => 'btn btn-default pull-right'],
        ]);


        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            //$param = $form->getData();
            $em = $this->getDoctrine()->getManager();
            $em->persist($param);
            $em->flush();
        }

        return $this->render('Job/new.html.twig', array(
            'form' => $form->createView(),
        ));
    }



    /**
     *@Route("/edit/{job}", methods = {"GET","POST"} , name ="Job_edit")
     *@param Request $request
     *@return \Symfony\Component\HttpFoundation\Response
     */
    public function edit (Request $request, Job $job)
    {
        $form = $this->createForm(JobType::class, $job);
        $form->add('submit', SubmitType::class, [
            'label' => 'Mettre à jour',
            'attr' => ['class' => 'btn btn-default pull-right'],
        ]);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            //$param = $form->getData();
            $em = $this->getDoctrine()->getManager();
            $em->persist($job);
            $em->flush();
        }

        return $this->render('Job/new.html.twig', array(
            'form' => $form->createView(),
        ));
    }

    /**
     * @Route("/job/liste/{id}", name="job_liste")
     */
    public function afficherListeAction()
    {
        $listJobs= $this->getDoctrine()
            ->getRepository(Job::class)
            ->findAll();

        //------------------
        //On demande à la vue d'afficher la liste des jobs
        //------------------
        return $this->render('Job/list.html.twig',array('lesJobs' => $listJobs));
    }
}
