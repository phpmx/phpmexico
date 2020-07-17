<?php

namespace App\Service;

use App\Contracts\GetLastMeetupEventInterface;
use App\Entity\MeetupEvent;
use DateTime;
use Exception;
use Symfony\Component\DomCrawler\Crawler;

class GetLatestMeetupEventFromCrawler implements GetLastMeetupEventInterface
{
    /** @var string */
    private $meetupEventsUrl;

    public function __construct(string $meetupEventsUrl)
    {
        $this->meetupEventsUrl = $meetupEventsUrl;
    }

    public function handle(): MeetupEvent
    {
        $html = $this->getHtml();
        $crawler = new Crawler($html);
        $eventListNode = $crawler->filter('.eventList-list');

        $event = new MeetupEvent();
        $event
            ->setMeetupId($this->crawlId($eventListNode))
            ->setTitle($this->crawlTitle($eventListNode))
            ->setScheduledAt($this->crawlTimestamp($eventListNode))
            ->setPlace($this->crawlAddress($eventListNode))
            ->setDescription($this->crawlDescription($eventListNode))
            ->setAttendingCount($this->crawlAttendingCount($eventListNode))
            ->setSpeaker($this->crawlSpeaker($eventListNode))
            ->setUrl($this->meetupEventsUrl.$event->getMeetupId());

        return $event;
    }

    /**
     * @throws Exception
     */
    private function getHtml(): string
    {
        if (!file_exists($this->meetupEventsUrl)) {
            throw new Exception(sprintf('Unable to read the provided source %s.', $this->meetupEventsUrl));
        }

        return file_get_contents($this->meetupEventsUrl);
    }

    private function crawlId(Crawler $eventListNode): int
    {
        $composedId = $eventListNode->filter('.eventCard')
            ->eq(0)
            ->attr('id');

        list(, $id) = explode('-', $composedId);

        return intval($id);
    }

    private function crawlTimestamp(Crawler $eventListNode): DateTime
    {
        $time = $eventListNode->filter('.eventTimeDisplay')
            ->eq(0)
            ->filter('time')
            ->eq(0)
            ->attr('datetime');

        $eventDate = new DateTime();

        return $eventDate->setTimestamp($time / 1000);
    }

    private function crawlTitle(Crawler $eventListNode): string
    {
        return $eventListNode->filter('.eventCardHead--title')
            ->eq(0)
            ->text();
    }

    private function crawlAddress(Crawler $eventListNode): string
    {
        return $eventListNode->filter('address')
            ->eq(0)
            ->filter('p')
            ->eq(0)
            ->text();
    }

    private function crawlDescription(Crawler $eventListNode): string
    {
        return $eventListNode->filter('.eventCard')
            ->eq(0)
            ->filter('.flex-item--shrink')
            ->eq(2)
            ->filter('p')
            ->eq(1)
            ->text();
    }

    private function crawlAttendingCount(Crawler $eventListNode): int
    {
        $attendingCount = $eventListNode->filter('.avatarRow--attendingCount')
            ->eq(0)
            ->filter('span')
            ->eq(0)
            ->text();

        return intval($attendingCount);
    }

    private function crawlSpeaker(Crawler $eventListNode): string
    {
        // TODO: Implement this method when we got the filter selector
        return '';
    }
}
