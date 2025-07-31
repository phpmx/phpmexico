<?php

namespace App\Service;

use Exception;
use Psr\Log\LoggerInterface;

class CrawlNode
{
    const DEFAULT_MESSAGE = 'Unable to find the node data.';

    /** @var LoggerInterface */
    private $logger;

    public function __construct(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }

    /**
     * @param mixed $default
     *
     * @return mixed
     */
    public function handle(callable $nodeFinder, $default, string $errorMessage = self::DEFAULT_MESSAGE)
    {
        try {
            return call_user_func($nodeFinder);
        } catch (Exception $exception) {
            $this->logger->warning('CrawlNode@handle', [
                'message' => $errorMessage,
                'exception' => $exception,
            ]);
        }

        return $default;
    }
}
