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
use Symfony\Component\HttpFoundation\Request;

/**
 * Class FrontController
 * @package App\Controller
 */
class FrontController extends AbstractController
{
    /**
     * @param Request $request
     * @param SensorDataService $dataService
     * @param MapDtoSerializer $serializer
     * @return JsonResponse
     * @throws \Exception
     */
    public function getMapData(
        Request $request,
        SensorDataService $dataService,
        MapDtoSerializer $serializer
    ): JsonResponse
    {
        $version = $request->headers->get('X-Version', null);
        $from = (new \DateTime())->sub(new \DateInterval("P{$request->get('period', 1)}D"));
        $lat = $request->get('lat', null);
        $lng = $request->get('lng', null);

        $dataSet = $dataService->getDataForMap($from, $lat, $lng, $version == 'next');

        return new JsonResponse($serializer->serialize($dataSet));
    }
}
