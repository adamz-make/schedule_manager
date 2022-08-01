<?php

namespace App\Controller;

use App\application\Services\CompanyServices\GetCompaniesJsonService;
use App\application\Services\ScheduleList\AddScheduleService;
use App\application\Services\ScheduleList\GetScheduleLIstService;
use App\application\Services\ScheduleList\GetScheduleService;
use App\Entity\Schedule;
use App\Repository\CompanyRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\StreamedResponse;
use Symfony\Component\Routing\Annotation\Route;

class ScheduleController extends AbstractController
{
    /**
     * @Route ("schedule", name="schedule")
     */
    public function index(
        GetCompaniesJsonService $getCompaniesService
    ): Response {
        $jsonCompanies = $getCompaniesService->execute();
        return $this->render('schedule.html.twig',
            [
                'companies' =>json_encode($jsonCompanies)
            ]);
    }
    /**
     * @Route ("schedule/getSchedule", name="schedule/getSchedule")
     */
    public function getSchedule(GetScheduleLIstService $getScheduleListService, Request $request): Response
    {
        $postData = json_decode($request->getContent());
        $date = $postData->date;
        $companyId = $postData->companyId;
        $dateImmuTable = new \DateTimeImmutable($date);
        $scheduleForDays = $getScheduleListService->execute($dateImmuTable, $companyId);

        $response = new StreamedResponse();
        $response->setCallback(function() use($scheduleForDays) {
            echo json_encode(['scheduleForDays' => $scheduleForDays]);
        });
        return $response;
    }

    /**
     * @Route ("schedule/addSchedule", name="schedule/addSchedule")
     */
    public function addSchedule(
        Request $request,
        GetScheduleService $scheduleService,
        AddScheduleService $addScheduleService
        ): Response {
        $postData = json_decode($request->getContent());
        $date = date('Y-m-d H:i:s', strtotime($postData->date));
        $date = new \DateTimeImmutable($date);
        $schedule = $scheduleService->execute($postData->companyId, $postData->description, $date);
        $content = json_encode(['failure'=>$schedule]);
        if (empty($schedule->getId)) {
            $addScheduleService->execute($schedule);
            $content = json_encode(['success'=>$schedule]);
        }
        $response = new Response();
        $response->setContent($content);

        return $response;
    }
}