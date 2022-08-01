<?php

namespace App\application\Domain\Service\ScheduleList;

class GetDaysInMonthService
{
    /**
     * @param \DateTimeImmutable $scheduleDate
     * @return array<\DateTimeImmutable>
     * @throws \Exception
     */
    public function execute(\DateTimeImmutable $scheduleDate): array
    {
        $monthAndYear = $scheduleDate->format('m-Y');
        $firstDayImmutable = new \DateTimeImmutable('01-' . $monthAndYear);
        $lastDayImmutable =
            $firstDayImmutable->add(new \DateInterval('P1M'))->sub(new \DateInterval('P1D'));

        return [$firstDayImmutable, $lastDayImmutable];
    }
}