<?php

namespace App\application\Services\ScheduleList;

use App\application\Domain\Model\Company\Interfaces\CompanyRepositoryInterface;
use App\application\Domain\Model\Schedule\Interfaces\ScheduleRepositoryInterface;
use App\Entity\Schedule;
use Doctrine\ORM\EntityManagerInterface;

class GetScheduleService
{
    /**
     * @var ScheduleRepositoryInterface
     */
    private $scheduleRepository;
    /**
     * @var CompanyRepositoryInterface
     */
    private $companyRepository;
    /**
     * @var EntityManagerInterface
     */
    private $entityManager;

    /**
     * GetScheduleService constructor.
     * @param ScheduleRepositoryInterface $scheduleRepository
     * @param CompanyRepositoryInterface $companyRepository
     */
    public function __construct(
        ScheduleRepositoryInterface $scheduleRepository,
        CompanyRepositoryInterface $companyRepository
    ) {
        $this->companyRepository = $companyRepository;
        $this->scheduleRepository = $scheduleRepository;
    }

    /**
     * @param string $companyId
     * @param string $description
     * @param \DateTimeImmutable $date
     * @return string
     */
    public function execute(string $companyId, string $description, \DateTimeImmutable $date): Schedule
    {
        $company = $this->companyRepository->find($companyId);
        $schedule = new Schedule($company, $description, $date);
        /*
         * GetSchedule from one hour
         */
        $scheduleExists = $this->scheduleRepository->getScheduleByCompanyAndDate(
            $schedule->getCompany()->getId(),
            $schedule->getDate()->format('Y-m-d H:00'),
            $schedule->getDate()->add(new \DateInterval('P1H')));
        if (!empty($scheduleExists)) {
            return reset($scheduleExists);
        }

        return $schedule;
    }
}