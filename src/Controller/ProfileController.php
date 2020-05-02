<?php

namespace App\Controller;

use App\Entity\Contact;
use App\Entity\Profile;
use App\Entity\User;
use App\Form\ContactType;
use App\Form\ProfileType;
use App\Form\UserPreferenceType;
use App\Repository\SkillGroupRepository;
use Doctrine\ORM\EntityManagerInterface;
use Jaybizzle\CrawlerDetect\CrawlerDetect;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class ProfileController extends AbstractController
{
    private $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    /**
     * @Route("/profile", name="profile")
     * @IsGranted("ROLE_USER")
     */
    public function index(Request $request, EventDispatcherInterface $dispatcher)
    {
        /** @var User $user */
        $user = $this->getUser();

        if ($user->getProfile()) {
            $profile = $user->getProfile();
        }
        else {
            $profile = new Profile();
        }

        $form = $this->createForm(ProfileType::class, $profile);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $profile->setUser($user);

            $this->em->persist($profile);
            $this->em->flush();

            return $this->redirectToRoute('profile');
        }

        return $this->render('profile/index.html.twig', [
            'form' => $form->createView(),
            'user' => $user,
        ]);
    }

    /**
     * @Route("/profile/preference", name="profile_preference")
     * @IsGranted("ROLE_USER")
     */
    public function preference(Request $request)
    {
        $user = $this->getUser();
        $form = $this->createForm(UserPreferenceType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->em->persist($user);
            $this->em->flush();

            return $this->redirectToRoute('profile_preference');
        }

        return $this->render('profile/preference.html.twig', [
            'form' => $form->createView(),
            'user' => $user,
        ]);
    }

    /**
     * @Route("/u/{username}", name="profile_user")
     */
    public function user(Request $request, User $developer, CrawlerDetect $crawlerDetect, SkillGroupRepository $sgr)
    {
        /** @var User $user */
        $user = $this->getUser();
        $contact = new Contact();

        $form = $this->createForm(ContactType::class, $contact, [ 'user' => $user ]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid() && $user) {
            $contact->setUser($user);
            $contact->setDeveloper($developer);

            $em = $this->getDoctrine()->getManager();
            $em->persist($contact);
            $em->flush();
        }

        $groups = [];
        if ($developer->getProfile()) {
            foreach ($developer->getProfile()->getSkills() as $skill) {
                $groups[(string)$skill->getSkillGroup()][] = $skill;
            }
        }

        return $this->render('profile/user.html.twig', [
            'user' => $developer,
            'skill_groups' => $groups,
            'is_crawler' => $crawlerDetect->isCrawler(),
            'contact_form' => $form->createView(),
        ]);
    }
}
