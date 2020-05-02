<?php

namespace App\Controller;

use App\Entity\Skill;
use App\Repository\ProfileRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class SkillController extends AbstractController
{
    /**
     * @Route("/skill", name="skill", options={"sitemap"=true} )
     */
    public function index()
    {
        return $this->render('skill/index.html.twig', [
            'controller_name' => 'SkillController',
        ]);
    }

    /**
     * @Route("/skill/{slug}", name="skill_slug")
     */
    public function bySlug(Skill $skill, ProfileRepository $profileRepository)
    {
        $profiles = $profileRepository->findBySkill($skill);

        return $this->render('skill/index.html.twig', [
            'skill' => $skill,
            'profiles' => $profiles,
        ]);
    }
}
