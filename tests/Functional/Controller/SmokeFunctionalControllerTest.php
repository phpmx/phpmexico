<?php

namespace App\Tests\Functional\Controller;

use RuntimeException;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Throwable;

final class SmokeFunctionalControllerTest extends WebTestCase
{
    const ANONYMOUS = 'anom.';

    /**
     * @return void
     */
    public function testSmokeTest()
    {
        foreach ($this->getUrlsToTest() as $account => $paths) {
            $client = static::createClient();

            if ($account !== self::ANONYMOUS) {
                //TODO Login
            }
            foreach ($paths as $url) {
                $method = 'GET';
                $data = [];
                if (is_array($url)) {
                    $method = isset($url['method']) ? $url['method'] : $method;
                    $data = isset($url['data']) ? $url['data'] : $data;
                    $url = isset($url['url']) ? $url['url'] : null;
                }

                if ($url === null) {
                    throw new RuntimeException('Url cannot be null.');
                }

                try {

                    $crawler = $client->request($method, $url, $data);

                    $statusCode = $client->getResponse()->getStatusCode();

                    if ($statusCode === 500) {
                        $content = $client->getResponse()->getContent();
                        preg_match('/\<title\>(.*)/', $content, $matches);

                        $error = trim($matches[1]);

                        $this->fail(sprintf('%s "%s" failed with error: %s', $method, $url, $error));
                    }
                    $this->assertEquals(200, $statusCode);

                } catch (Throwable $e) {
                    $this->fail(sprintf('%s "%s" failed with error: %s', $method, $url, $e->getMessage()));
                }
            }
        }
    }

    /**
     * @return string|array<mixed, mixed>
     */
    public function getUrlsToTest()
    {
        return [
            self::ANONYMOUS => [
                '/',
                '/job/plans',
                '/jobs',
                '/meetup',
            ]
        ];
    }
}