<?php

namespace App\Controller;

use App\Repository\MeetupEventRepository;
use Doctrine\ORM\Tools\Pagination\Paginator;
use Psr\Cache\CacheItemPoolInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class MeetupController extends AbstractController
{
    /**
     * @Route("/meetup", name="meetup")
     */
    public function index(CacheItemPoolInterface $cache, MeetupEventRepository $meetupEventRepository)
    {
        $events_cache = $cache->getItem('meetup_events');
        if (!$events_cache->isHit()) {
            $events = new Paginator($meetupEventRepository->getAllQueryBuilder());

            $events_cache->set($events);

            $date = new \DateTime('+2 day');
            $events_cache->expiresAt($date);
            $cache->save($events_cache);
        } else {
            $events = $cache->getItem('meetup_events')->get();
        }

        return $this->render('meetup/index.html.twig', [
            'events' => $events,
        ]);
    }
}
