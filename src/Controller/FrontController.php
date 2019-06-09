<?php
/**
 * Created by PhpStorm.
 * User: O!
 * Date: 13.03.19
 * Time: 15:22
 */

namespace App\Controller;

use App\Service\MapDtoSerializer;
use App\Service\SensorDataService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;

/**
 * Class FrontController
 * @package App\Controller
 */
class FrontController extends AbstractController
{
    /**
     * @param SensorDataService $dataService
     * @param MapDtoSerializer $serializer
     * @return JsonResponse
     * @throws \Exception
     */
    public function getMapData(SensorDataService $dataService, MapDtoSerializer $serializer): JsonResponse
    {
        $dataSet = $dataService->getDataForMap();

        return new JsonResponse($serializer->serialize($dataSet));
    }
}
