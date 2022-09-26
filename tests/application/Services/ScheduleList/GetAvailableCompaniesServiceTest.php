<?php

namespace App\Tests;

use App\application\Services\ScheduleList\GetAvailableCompaniesService;
use App\application\Services\ScheduleList\GetScheduleLIstService;
use App\Entity\Company;
use App\Entity\Schedule;
use App\Repository\CompanyRepository;
use App\Repository\ScheduleRepository;
use PHPUnit\Framework\TestCase;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class GetAvailableCompaniesServiceTest extends TestCase
{
    public function testReturnOneCompany(): void
    {
        $mockCompaniesRepository = $this->createMock(CompanyRepository::class);
        $companyNameToBeReturned = 'someCompany';
        $companies = [
            new Company( $companyNameToBeReturned, 1),
            new Company( 'someOtherCompany', 2)
        ];
        $date = new \DateTimeImmutable();

        $mockCompaniesRepository->method('findAll')->willReturn($companies);
        $mockScheduleRepository = $this->createMock(ScheduleRepository::class);
        $mockScheduleRepository->method('getSchedulesByDate')->willReturn([
            new Schedule($companies[1], 'jakiś tam', $date, 1)
        ]);

        $getScheduleListService = new GetAvailableCompaniesService($mockScheduleRepository, $mockCompaniesRepository);

        $companiesList = $getScheduleListService->execute($date);
        $this->assertIsArray($companiesList);
        $this->assertTrue($companiesList[0]->getCompanyName() === $companyNameToBeReturned);
    }

    public function testReturnTwoCompanies(): void
    {
        $mockCompaniesRepository = $this->createMock(CompanyRepository::class);
        $companyNameToBeReturned = ['someCompany', 'someOtherCompany'];
        $companies = [
            new Company( $companyNameToBeReturned[0], 1),
            new Company( $companyNameToBeReturned[1], 2)
        ];
        $date = new \DateTimeImmutable();

        $mockCompaniesRepository->method('findAll')->willReturn($companies);
        $mockScheduleRepository = $this->createMock(ScheduleRepository::class);

        $getScheduleListService = new GetAvailableCompaniesService($mockScheduleRepository, $mockCompaniesRepository);
        $companiesList = $getScheduleListService->execute($date);
        $this->assertIsArray($companiesList);
        $this->assertTrue($companiesList[0]->getCompanyName() === $companyNameToBeReturned[0]);
    }

    public function testReturnNoCompany(): void
    {
        $mockCompaniesRepository = $this->createMock(CompanyRepository::class);
        $companyNameToBeReturned = ['someCompany', 'someOtherCompany'];
        $companies = [
            new Company( $companyNameToBeReturned[0], 1),
            new Company( $companyNameToBeReturned[1], 2)
        ];
        $date = new \DateTimeImmutable();

        $mockCompaniesRepository->method('findAll')->willReturn($companies);
        $mockScheduleRepository = $this->createMock(ScheduleRepository::class);
        $mockScheduleRepository->method('getSchedulesByDate')->willReturn([
            new Schedule($companies[0], 'jakiś tam', $date, 1),
            new Schedule($companies[1], 'jakiś tam', $date, 2)
        ]);

        $getScheduleListService = new GetAvailableCompaniesService($mockScheduleRepository, $mockCompaniesRepository);
        $companiesList = $getScheduleListService->execute($date);
        $this->assertIsArray($companiesList);
        $this->isEmpty($companiesList);
    }
}
