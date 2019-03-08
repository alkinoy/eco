<?php
/**
 * Created by PhpStorm.
 * User: O!
 * Date: 08.03.19
 * Time: 14:16
 */

namespace App\Service;

use Psr\Log\LoggerInterface;

/**
 * Class SensorDataService
 * @package App\Service
 */
class SensorDataService
{
    /** @var LoggerInterface */
    protected $logger;

    /**
     * SensorDataService constructor.
     * @param LoggerInterface $logger
     */
    public function __construct(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }

    public function storeSensorRecord()
    {

    }
}
