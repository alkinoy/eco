<?php
/**
 * Created by PhpStorm.
 * User: O!
 * Date: 04.03.19
 * Time: 15:04
 */

namespace App\Controller;

use App\Exception\SensorInputDataValidationException;
use App\Service\IntegralCalculator;
use App\Service\SensorDataService;
use App\Service\SensorDataValidator;
use App\Service\SensorInputDataDtoFactory;
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
     * @param SensorDataValidator $validator
     * @param SensorInputDataDtoFactory $inputDtoFactory
     * @param IntegralCalculator $integralCalculator
     * @return Response
     */
    public function storeSensorData(
        Request $request,
        LoggerInterface $logger,
        SensorRecordFactory $sensorRecordFactory,
        SensorDataService $sensorDataService,
        SensorDataValidator $validator,
        SensorInputDataDtoFactory $inputDtoFactory,
        IntegralCalculator $integralCalculator
    ): Response
    {
        $incomeData = $request->get(self::INCOME_DATA_KEY, null);
        if (null === $incomeData || !is_array($incomeData)) {
            $logger->info('Income request is invalid.');

            return new JsonResponse(['message' => 'Wrong request: Invalid input data structure.'], 400);
        }

        $logger->info('Income request.', ['data' => $incomeData]);

        try {
            $validator->validateInputData($incomeData);

            $inputDto = $inputDtoFactory->createDtoFromInput($incomeData);
            $sensorRecord = $sensorRecordFactory->createSensorRecord($inputDto);
            $integralCalculator->calculateIntegralValue($sensorRecord);
            $sensorDataService->storeSensorRecord($sensorRecord);

            return new JsonResponse(['message' => 'data stored']);
        } catch (SensorInputDataValidationException $e) {
            //error already logger in validator

            return new JsonResponse(['message' => 'Wrong request: '.$e->getMessage()], 400);
        } catch (\Exception $e) {
            $errorId = uniqid('', false);
            $logger->error(
                'Exception during store sensor input data: '.$e->getMessage(),
                [
                    'errorId' => $errorId,
                    'trace' => (string)$e,
                ]
            );

            return new JsonResponse(['message' => 'Internal error. Error id: '.$errorId], 500);
        }
    }
}
