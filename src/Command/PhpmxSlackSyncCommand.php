<?php

namespace App\Command;

use App\Entity\Profile;
use App\Entity\User;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use wrapi\slack\slack;

class PhpmxSlackSyncCommand extends Command
{
    protected static $defaultName = 'phpmx:slack:sync';

    public function __construct(ParameterBagInterface $param, UserRepository $userRepo, EntityManagerInterface $entityManager)
    {
        $this->param = $param;
        $this->userRepo = $userRepo;
        $this->em = $entityManager;

        parent::__construct();
    }

    protected function configure()
    {
        $this
            ->setDescription('Syncronize the slack users with phpmexico.mx')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $slack_token = $this->param->get('SLACK_TOKEN');

        $slack = new slack($slack_token);
        $user_request = $slack->users->list();

        foreach ($user_request['members'] as $member) {
            if (!$member['is_bot'] && $member['name'] !== 'slackbot') {
                $email = $member['profile']['email'];
                $slack_id = $member['id'];
                $username = $member['name'];

                $user = $this->userRepo->findByEmail($email);

                if ($user && $user->getSlackId() == null) {
                    $user->setSlackId($slack_id);
                } elseif (!$user) {
                    $user = new User();
                    $user->setEmail($email);
                    $user->setUsername($username);
                    $user->setSlackId($slack_id);
                    $user->setSlack(true);

                    if (array_key_exists('first_name', $member['profile']) &&
                        array_key_exists('last_name', $member['profile'])) {
                        $name = $member['profile']['first_name'];
                        $lastname = $member['profile']['last_name'];

                        $profile = new Profile();
                        $profile->setName($name);
                        $profile->setLastname($lastname);

                        $user->setProfile($profile);
                    }
                }

                $this->em->persist($user);
                $this->em->flush();
            }
        }

        $io = new SymfonyStyle($input, $output);
        $io->success('Done');
    }
}
