<?php
/**
 * Created by PhpStorm.
 * User: O!
 * Date: 04.03.19
 * Time: 15:04
 */

namespace App\Controller;

use Psr\Log\LoggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class IncomeDataController extends AbstractController
{

    public function storeSensorData(Request $request, LoggerInterface $logger): Response
    {

        $logger->info('Income data: '.$request->get('sensorData'));

        return new JsonResponse([]);
    }
}
