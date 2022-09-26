<?php

namespace App\Tests;

use App\application\Services\ScheduleList\GetScheduleLIstService;
use App\Entity\Company;
use App\Entity\Schedule;
use App\Repository\ScheduleRepository;
use PHPUnit\Framework\TestCase;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class GetScheduleListServiceTest extends TestCase
{
    public function testReturnScheduleForOneDay(): void
    {
        $scheduleRepositoryMock = $this->createMock(ScheduleRepository::class);

        $companyFromRepostiroy = new Company('jakaś firma', 1);
        $day = 5;
        $scheduleFromRepository = new Schedule(
            $companyFromRepostiroy,
            'jakiś opis',
            new \DateTimeImmutable('2022-02-' . $day),
            1
        );
        $scheduleRepositoryMock->method('getScheduleByCompanyAndDate')->willReturn([$scheduleFromRepository]);
        $getScheduleListService = new GetScheduleLIstService($scheduleRepositoryMock);

        $date = new \DateTimeImmutable('2022-02-08');
        $schedulesList = $getScheduleListService->execute($date, 1);

        $this->assertIsArray($schedulesList);
        $this->assertNotEmpty($schedulesList[$day]);
    }
}
