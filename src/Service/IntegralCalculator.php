<?php
/**
 * Created by PhpStorm.
 * User: O!
 * Date: 12.03.19
 * Time: 08:36
 */

namespace App\Service;

use App\Entity\SensorRecord;
use App\Repository\SensorValueBreakpointsRepository;
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

    /** @var SensorValueBreakpointsRepository */
    protected $sensorValueBreakpointRepository;

    /**
     * IntegralCalculator constructor.
     * @param LoggerInterface $logger
     * @param SensorValueBreakpointsRepository $sensorValueBreakpointRepository
     */
    public function __construct(LoggerInterface $logger, SensorValueBreakpointsRepository $sensorValueBreakpointRepository)
    {
        $this->logger = $logger;
        $this->sensorValueBreakpointRepository = $sensorValueBreakpointRepository;
    }

    /**
     * @param SensorRecord $sensorRecord
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    public function calculateIntegralValue(SensorRecord $sensorRecord): void
    {
        $integralValue = 0;

        foreach ($sensorRecord->getSensorValues() as $sensorValue) {
            if (!$sensorValue->getValueType()->getIsInAqi()) {
                continue;
            }

            $breakpoint = $this->sensorValueBreakpointRepository
                ->getBreakpoint($sensorValue->getValueType(), $sensorValue->getValue());

            $a = ($breakpoint->getAqiMax() - $breakpoint->getAqiMin());
            $b = ($sensorValue->getValue() - $breakpoint->getValueMin());
            $c = ($breakpoint->getValueMax() - $breakpoint->getValueMin());

            $currentIntegrationValue = $a*$b/$c + 101;

            $integralValue = max($integralValue, $currentIntegrationValue);
        }

        $integralValue = min(self::MAX_INDEX_VALUE, $integralValue);
        $integralValue = max(self::MIN_INDEX_VALUE, $integralValue);

        $sensorRecord->setIntegralValue($integralValue);
    }
}
