<?php

declare(strict_types=1);

namespace App\Controller;

use App\Entity\User;
use App\Form\LoginType;
use App\Form\SignUpType;
use App\Repository\SkillRepository;
use App\Repository\UserRepository;
use EmailChecker\EmailChecker;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\RequestOptions;
use Psr\Log\LoggerInterface;
use ReCaptcha\ReCaptcha;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;

class IndexController extends AbstractController
{
    protected $client;

    protected $userRepo;

    protected $logger;

    public function __construct(Client $client, UserRepository $userRepo, LoggerInterface $logger)
    {
        $this->client = $client;
        $this->userRepo = $userRepo;
        $this->logger = $logger;
    }

    /**
     * @Route("/", name="index")
     * @param Request $request
     * @param SkillRepository $skillRepository
     * @return Response
     */
    public function index(Request $request, SkillRepository $skillRepository): Response
    {
        $user = new User();
        $form = $this->createForm(SignUpType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $checker = new EmailChecker();
            if ($checker->isValid($form->get('email')->getData())) {
                $this->inviteUser($user->getEmail());

                $em = $this->getDoctrine()->getManager();
                $em->persist($user);
                $em->flush();

                $this->addFlash('notice', 'Hemos enviado correos a tu email');
            } else {
                $this->addFlash('notice', 'Correo invalido');
            }
        }

        $skills = $skillRepository->findFrontpage();

        return $this->render('index/index.html.twig', [
            'form' => $form->createView(),
            'skills' => $skills,
        ]);
    }

    /**
     * @Route("/login", name="login")
     * @param Request $request
     * @param ReCaptcha $reCaptcha
     * @return Response
     */
    public function login(Request $request, ReCaptcha $reCaptcha): Response
    {
        $form = $this->createForm(LoginType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $g_recaptcha = $request->request->get('recaptchaResponse');
            $ip = $request->getClientIp();
            $re_response = $reCaptcha->verify($g_recaptcha, $ip);

            if ($re_response->isSuccess()) {
                $email = $form->get('email')->getData();
                $user = $this->userRepo->findByEmail($email);

                $this->get('security.csrf.token_manager')
                    ->refreshToken('form_intention');

                if ($user) {
                    $user->setLastLogin(new \DateTime());

                    $em = $this->getDoctrine()->getManager();
                    $em->persist($user);
                    $em->flush();

                    $this->addFlash(
                        'notice',
                        'Te enviamos un correo con el link para ingresar a tu cuenta'
                    );
                } else {
                    $this->addFlash('notice', 'Correo no encontrado');
                }
            }
        }

        return $this->render('login.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @param string $email
     */
    private function inviteUser(string $email)
    {
        try {
            $this->client->post($this->getParameter('SLACK_URL_INVITE'), [
                RequestOptions::JSON => [
                    'token' => $this->getParameter('SLACK_TOKEN'),
                    'email' => email,
                    'channel_ids' => 'C0PDPQJ3B,C21DD0RMW,C0PPV4HS7,C0PPU2NTD',
                    'team_id' => $this->getParameter('SLACK_TEAMID'),
                ],
            ]);
        } catch (ClientException $e) {
            $this->logger->critical($e->getMessage(), [
                'cause' => 'Slack Inviter',
            ]);
        }
    }
}
