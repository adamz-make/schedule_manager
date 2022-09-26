<?php

namespace App\application\Services\ScheduleList;
use App\application\Domain\Model\Schedule\Interfaces\ScheduleRepositoryInterface;
use App\application\Domain\Service\ScheduleList\GetDaysInMonthService;
use App\Entity\Schedule;

class GetScheduleLIstService
{
    /**
     * @var ScheduleRepositoryInterface
     */
    private $scheduleRepository;

    /**
     * GetScheduleLIstService constructor.
     * @param ScheduleRepositoryInterface $scheduleRepository
     */
    public function __construct(ScheduleRepositoryInterface $scheduleRepository)
    {
        $this->scheduleRepository = $scheduleRepository;
    }

    /**
     * @param \DateTimeImmutable $scheduleDate
     * @param string $companyId
     * @return array
     * @throws \Exception
     */
    public function execute(\DateTimeImmutable $scheduleDate, string $companyId): array
    {
        $getDaysInMonthService = new GetDaysInMonthService();
        list($firstDayImmutable, $lastDayImmutable) = $getDaysInMonthService->execute($scheduleDate);
        $daysArray = [];
        $scheduleList = $this->scheduleRepository->getScheduleByCompanyAndDate(
            $companyId,
            $firstDayImmutable->format('Y-m-d H:i:s'),
            $lastDayImmutable->format('Y-m-d 23:59:59')
        );
        for ($i = (int)$firstDayImmutable->format('d'); $i <= $lastDayImmutable->format('d') ; $i++) {
            $dateIntervalString = 'P' . $i . 'D';
            $firstDayImmutable->add(new \DateInterval($dateIntervalString));
            $scheduleForDay = array_filter($scheduleList, function($singleSchedule) use ($i) {
                if ($i === (int)$singleSchedule->getDate()->format('d')) {
                    return true;
                }
            });
            $JsonScheduleForDay = $this->scheduleToJson($scheduleForDay);
            $daysArray[$i] = $JsonScheduleForDay;
        }
        return $daysArray;
    }


    /**
     * @param array<schedule> $scheduleList
     * @return array
     */
    private function scheduleToJson(array $scheduleList): ?array
    {
        if (reset($scheduleList) instanceOf Schedule) {
            return reset($scheduleList)->jsonSerialize();
        }
        return [];
    }
}