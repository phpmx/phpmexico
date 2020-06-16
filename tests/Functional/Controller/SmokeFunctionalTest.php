<?php

namespace App\Tests\Functional\Controller;

use RuntimeException;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Throwable;

final class SmokeFunctionalTest extends WebTestCase
{
    const ANONYMOUS = 'anom.';

    /**
     * @return void
     */
    public function testSmokeTest()
    {
        foreach ($this->getUrlsToTest() as $account => $paths) {
            $client = static::createClient();

            foreach ($paths as $url) {
                $method = 'GET';
                $data = [];
                if (is_array($url)) {
                    $method = isset($url['method']) ? $url['method'] : $method;
                    $data = isset($url['data']) ? $url['data'] : $data;
                    $url = isset($url['url']) ? $url['url'] : null;
                }

                if (null === $url) {
                    throw new RuntimeException('Url cannot be null.');
                }

                $client->request($method, $url, $data);
                $statusCode = $client->getResponse()->getStatusCode();
                $this->assertEquals(200, $statusCode);
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
            ],
        ];
    }
}
