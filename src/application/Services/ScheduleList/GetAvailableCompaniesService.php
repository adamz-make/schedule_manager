<?php


namespace App\application\Services\ScheduleList;


use App\application\Domain\Model\Company\Interfaces\CompanyRepositoryInterface;
use App\application\Domain\Model\Schedule\Interfaces\ScheduleRepositoryInterface;
use App\Entity\Company;
use App\Entity\Schedule;

class GetAvailableCompaniesService
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
     * GetAvailableCompaniesService constructor.
     * @param ScheduleRepositoryInterface $scheduleRepository
     */
    public function __construct(
        ScheduleRepositoryInterface $scheduleRepository,
        CompanyRepositoryInterface $companyRepository
    ) {
        $this->scheduleRepository = $scheduleRepository;
        $this->companyRepository = $companyRepository;
    }

    /**
     * @param \DateTimeImmutable $dateTime
     * @return array<Company>
     */
    public function execute(\DateTimeImmutable $dateTime): array
    {
        $companiesList = $this->companyRepository->findAll();
        $dateFrom = $dateTime->format('Y-m-d h:00:00');
        $dateTo = $dateTime->format('Y-m-d h:59:59');
        $plannedSchedules = $this->scheduleRepository->getSchedulesByDate($dateFrom, $dateTo);
        return array_filter($companiesList, function (Company $company) use ($plannedSchedules) {
            /** @var Schedule $plannedSchedule */
            foreach($plannedSchedules as $plannedSchedule) {
                if ($company->getId() === $plannedSchedule->getCompany()->getId()) {
                    return false;
                }
            }
            return true;
        });


    }

}