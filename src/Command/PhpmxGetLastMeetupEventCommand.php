<?php

namespace App\Command;

use App\Contracts\GetLastMeetupEventInterface;
use App\Entity\MeetupEvent;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

class PhpmxGetLastMeetupEventCommand extends Command
{
    const SUCCESSFUL_EXECUTED_STATUS = 1;

    protected static $defaultName = 'phpmx:meetup:last-event';

    /** @var GetLastMeetupEventInterface */
    private $getLastMeetupEvent;

    /** @var EntityManagerInterface */
    private $em;

    public function __construct(GetLastMeetupEventInterface $getLastMeetupEvent, EntityManagerInterface $em)
    {
        parent::__construct();

        $this->getLastMeetupEvent = $getLastMeetupEvent;
        $this->em = $em;
    }

    protected function configure()
    {
        $this->setDescription('Get the latest event from the meetup page.');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $io = new SymfonyStyle($input, $output);
        $latestEvent = $this->getLastMeetupEvent->handle();

        if (!$latestEvent) {
            $io->warning('Command executed but no event was retrieved.');

            return self::SUCCESSFUL_EXECUTED_STATUS;
        }

        /** @var MeetupEvent $cachedEvent */
        $cachedEvent = $this->em->getRepository(MeetupEvent::class)
            ->findOneBy([
                'meetupId' => $latestEvent->getMeetupId(),
            ]);

        if ($cachedEvent) {
            $cachedEvent
                ->setMeetupId($latestEvent->getMeetupId())
                ->setTitle($latestEvent->getTitle())
                ->setScheduledAt($latestEvent->getScheduledAt())
                ->setPlace($latestEvent->getPlace())
                ->setDescription($latestEvent->getDescription())
                ->setAttendingCount($latestEvent->getAttendingCount())
                ->setSpeaker($latestEvent->getSpeaker())
                ->setUrl($latestEvent->getUrl());

            $this->em->persist($cachedEvent);
            $this->em->flush();

            $io->success(
                sprintf(
                    'Cached event was updated successfully, details: %s',
                    $cachedEvent
                )
            );

            return self::SUCCESSFUL_EXECUTED_STATUS;
        }

        $this->em->persist($latestEvent);
        $this->em->flush();

        $io->success(
            sprintf(
                'Event retrieved and persisted, details: %s.',
                $latestEvent
            )
        );

        return self::SUCCESSFUL_EXECUTED_STATUS;
    }
}
