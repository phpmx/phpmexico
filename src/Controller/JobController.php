<?php

namespace App\Controller;

use App\Entity\Job;
use App\Form\JobType;
use App\Repository\ContactRepository;
use App\Repository\JobRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class JobController extends AbstractController
{
    /**
     * @Route("/jobs", name="jobs", options={"sitemap" = true})
     */
    public function index(JobRepository $jobRepository)
    {
        $jobs = $jobRepository->findBy([
            'active' => true,
        ]);

        return $this->render('jobs/index.html.twig', [
            'jobs' => $jobs,
        ]);
    }

    /**
     * @Route("/job/create", name="jobs_create")
     * @IsGranted("ROLE_USER")
     */
    public function create(Request $request)
    {
        $job = new Job();

        $form = $this->createForm(JobType::class, $job);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $job->setOwner($this->getUser());

            $em = $this->getDoctrine()->getManager();
            $em->persist($job);
            $em->flush();

            return $this->redirectToRoute('jobs_own');
        }

        return $this->render('jobs/create.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/job/own", name="jobs_own")
     * @IsGranted("ROLE_USER")
     */
    public function own(Request $request, JobRepository $jobRepository)
    {
        $jobs = $jobRepository->findOwnJobPost($this->getUser());

        return $this->render('jobs/own.html.twig', [
            'jobs' => $jobs,
        ]);
    }

    /**
     * @Route("/job/plans", name="jobs_plans")
     */
    public function plans()
    {
        return $this->render('jobs/plans.html.twig', [
        ]);
    }

    /**
     * @Route("/job/offerts", name="job_offerts")
     * @IsGranted("ROLE_USER")
     */
    public function offerts(ContactRepository $contactRepository)
    {
        $user = $this->getUser();
        $offerts = $contactRepository->findByUser($user);

        return $this->render('jobs/offerts.html.twig', [
            'offerts' => $offerts,
        ]);
    }

    /**
     * @Route("/job/{id}", name="job_show", options={"sitemap" = true})
     */
    public function show(Job $job)
    {
        return $this->render('jobs/job.html.twig', [
            'job' => $job,
        ]);
    }
}
