<?php

namespace App\Tests\Unit\Service;

use App\Service\CrawlNode;
use PHPUnit\Framework\TestCase;
use Psr\Log\LoggerInterface;
use Symfony\Component\DomCrawler\Crawler;

class CrawlNodeTest extends TestCase
{
    /** @var CrawlNode */
    private $crawlNode;

    /** @var string */
    private $node;

    protected function setUp(): void
    {
        parent::setUp();

        $loggerMockup = $this->createMock(LoggerInterface::class);
        $this->crawlNode = new CrawlNode($loggerMockup);

        $html = file_get_contents(__DIR__.'/../../fixtures/meetup_response_example.html');
        $this->node = new Crawler($html);
    }

    /**
     * @test
     */
    public function handleShouldGetTheCrawledData(): void
    {
        $nodeContent = $this->crawlNode->handle(
            function () {
                return $this->
                node
                ->filter('.eventCard--link')
                ->eq(0)
                ->attr('href');
            },
            'default'
        );

        $this->assertSame('/PHP-The-Right-Way/events/123456/', $nodeContent);
    }

    /**
     * @test
     */
    public function handleShouldReturnTheDefaultIfTheNodeDoesNotExists(): void
    {
        $nodeContent = $this->crawlNode->handle(
            function () {
                $this->node->filter('eventCard')
                    ->eq(0)
                    ->attr('id');
            },
            'default'
        );

        $this->assertSame('default', $nodeContent);
    }
}
