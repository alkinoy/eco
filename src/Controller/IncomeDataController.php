<?php
/**
 * Created by PhpStorm.
 * User: O!
 * Date: 04.03.19
 * Time: 15:04
 */

namespace App\Controller;

use App\Service\SensorDataService;
use App\Service\SensorRecordFactory;
use Psr\Log\LoggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class IncomeDataController extends AbstractController
{
    public const INCOME_DATA_KEY = 'sensorData';

    /**
     * @param Request $request
     * @param LoggerInterface $logger
     * @param SensorRecordFactory $sensorRecordFactory
     * @param SensorDataService $sensorDataService
     * @return Response
     */
    public function storeSensorData(
        Request $request,
        LoggerInterface $logger,
        SensorRecordFactory $sensorRecordFactory,
        SensorDataService $sensorDataService
    ): Response
    {
        $incomeData = $request->get(self::INCOME_DATA_KEY, null);
        if (null === $incomeData) {
            $logger->info('Income request is invalid.');

            return new JsonResponse(['message' => 'Wrong request'], 400);
        }

        $logger->info('Income request.', ['data' => $incomeData]);

        $sensorRecord = $sensorRecordFactory->createSensorRecord($incomeData);
        $sensorDataService->storeSensorRecord($sensorRecord);

        return new JsonResponse(['message' => 'data stored']);
    }
}
