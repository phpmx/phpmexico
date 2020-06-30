<?php

declare(strict_types=1);

namespace App\Controller;

use App\Entity\Skill;
use App\Repository\ProfileRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;

class SkillController extends AbstractController
{
    /**
     * @Route("/skill", name="skill", options={"sitemap"=true} )
     * @return Response
     */
    public function index(): Response
    {
        return $this->render('skill/index.html.twig', [
            'controller_name' => 'SkillController',
        ]);
    }

    /**
     * @Route("/skill/{slug}", name="skill_slug")
     * @param Skill $skill
     * @param ProfileRepository $profileRepository
     * @return Response
     */
    public function bySlug(Skill $skill, ProfileRepository $profileRepository): Response
    {
        $profiles = $profileRepository->findBySkill($skill);

        return $this->render('skill/index.html.twig', [
            'skill' => $skill,
            'profiles' => $profiles,
        ]);
    }
}
