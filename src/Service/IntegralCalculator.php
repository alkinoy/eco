<?php
/**
 * Created by PhpStorm.
 * User: O!
 * Date: 12.03.19
 * Time: 08:36
 */

namespace App\Service;

use App\Entity\SensorRecord;
use Psr\Log\LoggerInterface;

/**
 * Class IntegralCalculator
 * @package App\Service
 */
class IntegralCalculator
{
    public const MIN_INDEX_VALUE = 0;
    public const MAX_INDEX_VALUE = 500;

    public const AQI_LEVEL_GOOD = 50;
    public const AQI_LEVEL_MODERATE = 100;
    public const AQI_LEVEL_UNHEALTHY_SENSITIVE = 150;
    public const AQI_LEVEL_UNHEALTHY_ALL = 200;
    public const AQI_LEVEL_VERY_UNHEALTHY = 300;
    public const AQI_LEVEL_HAZARDOUS = 500;


    /** @var LoggerInterface */
    protected $logger;

    /**
     * IntegralCalculator constructor.
     * @param LoggerInterface $logger
     */
    public function __construct(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }

    /**
     * @param SensorRecord $sensorRecord
     */
    public function calculateIntegralValue(SensorRecord $sensorRecord): void
    {

    }
}
