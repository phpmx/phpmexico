<?php

declare(strict_types=1);

namespace App\Controller;

use DMS\Service\Meetup\MeetupKeyAuthClient;
use Psr\Cache\CacheItemPoolInterface;
use Psr\Cache\InvalidArgumentException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;

class MeetupController extends AbstractController
{
    /**
     * @Route("/meetup", name="meetup")
     * @param CacheItemPoolInterface $cache
     * @param MeetupKeyAuthClient $client
     * @return Response
     * @throws InvalidArgumentException
     */
    public function index(CacheItemPoolInterface $cache, MeetupKeyAuthClient $client): Response
    {
        $events_cache = $cache->getItem('meetup_events');
        if (!$events_cache->isHit()) {
            $events = $client->getEvents([
                'group_urlname' => 'PHP-The-Right-Way',
            ]);

            $events_cache->set($events);

            $date = new \DateTime('+1 week');
            $events_cache->expiresAt($date);
            $cache->save($events_cache);
        } else {
            $events = $cache->getItem('meetup_events')->get();
        }

        return $this->render('meetup/index.html.twig', [
            'events' => $events->getData(),
        ]);
    }
}
