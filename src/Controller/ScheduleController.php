<?php

namespace App\Controller;

use App\application\Services\CompanyServices\GetCompaniesJsonService;
use App\application\Services\ScheduleList\AddScheduleService;
use App\application\Services\ScheduleList\GetAvailableCompaniesService;
use App\application\Services\ScheduleList\GetScheduleLIstService;
use App\application\Services\ScheduleList\GetScheduleService;
use App\Repository\ScheduleRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\StreamedResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Twig\Environment;

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
                'companies' => json_encode($jsonCompanies)
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
            echo json_encode(['scheduleForDays' => json_encode($scheduleForDays)]);
        });
        return $response;
    }

    /**
     * @Route ("schedule/addSchedule", name="schedule/addSchedule")
     */
    public function addSchedule(
        Request $request,
        GetScheduleService $scheduleService,
        ScheduleRepository $scheduleRepository
        ): Response {
        $postData = json_decode($request->getContent());
        $date = date('Y-m-d H:i:s', strtotime($postData->date));
        $date = new \DateTimeImmutable($date);
        $schedule = $scheduleService->execute($postData->companyId, $postData->description, $date);
        $content = json_encode(['failure'=>$schedule]);
        if (empty($schedule->getId)) {
            $scheduleRepository->persist($schedule);
            $content = json_encode(['success'=>$schedule]);
        }
        $response = new Response();
        $response->setContent($content);

        return $response;
    }

    /**
     * @Route ("schedule/getCompaniesAvailability", name="schedule/getCompaniesAvailability")
     */
    public function getCompaniesAvailability(
        Request $request,
        GetAvailableCompaniesService $getAvailableCompaniesService
    ) : Response {

        $postData = json_decode($request->getContent());
        //$date = date('Y-m-d H:i:s', strtotime($postData->date));
        $date = new \DateTimeImmutable("2022-08-02 08:15:00");
        $availableCompanies = $getAvailableCompaniesService->execute($date);
        $jsonCompanies = [];
        foreach ($availableCompanies as $company) {
            $jsonCompanies[] = $company->jsonSerialize();
        }
        return new JsonResponse(json_encode(['availableCompanies' => $jsonCompanies]));
    }

}