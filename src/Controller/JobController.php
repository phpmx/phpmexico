<?php

declare(strict_types=1);

namespace App\Controller;

use App\Entity\Job;
use App\Form\JobType;
use App\Repository\ContactRepository;
use App\Repository\JobRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\RedirectResponse;

class JobController extends AbstractController
{
    /**
     * @Route("/jobs", name="jobs", options={"sitemap" = true})
     * @param JobRepository $jobRepository
     * @return Response
     */
    public function index(JobRepository $jobRepository): Response
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
     * @param Request $request
     * @return RedirectResponse|Response
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
     * @param Request $request
     * @param JobRepository $jobRepository
     * @return Response
     */
    public function own(Request $request, JobRepository $jobRepository): Response
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
     * @param ContactRepository $contactRepository
     * @return Response
     */
    public function offerts(ContactRepository $contactRepository): Response
    {
        $user = $this->getUser();
        $offerts = $contactRepository->findByUser($user);

        return $this->render('jobs/offerts.html.twig', [
            'offerts' => $offerts,
        ]);
    }

    /**
     * @Route("/job/{id}", name="job_show", options={"sitemap" = true})
     * @param Job $job
     * @return Response
     */
    public function show(Job $job): Response
    {
        return $this->render('jobs/job.html.twig', [
            'job' => $job,
        ]);
    }
}
