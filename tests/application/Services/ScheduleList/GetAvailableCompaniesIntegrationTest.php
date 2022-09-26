<?php

namespace App\Tests\application\Services\ScheduleList;

use App\application\Services\ScheduleList\GetAvailableCompaniesService;
use App\Entity\Company;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class GetAvailableCompaniesIntegrationTest extends KernelTestCase
{
    public function testReturnAllCompanies()
    {
        self::bootKernel();
        /** @var GetAvailableCompaniesService $getAvailableCompaniesService */
        $getAvailableCompaniesService = self::$kernel->getContainer()->get(
            'test.' . GetAvailableCompaniesService::class
        );
        $now = new \DateTimeImmutable();
        $companiesListFromService = $getAvailableCompaniesService->execute($now->add(new \DateInterval('P100Y')));

        /** @var EntityManagerInterface $em */
        $em = self::$kernel->getContainer()
            ->get('doctrine')
            ->getManager();

        $companyRepository = $em->getRepository(Company::class);
        $allCompaniesList = $companyRepository->findAll();\
        dd($allCompaniesList);
    }
}