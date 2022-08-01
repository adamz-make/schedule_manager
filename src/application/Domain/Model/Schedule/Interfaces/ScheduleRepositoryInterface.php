<?php

namespace App\application\Domain\Model\Schedule\Interfaces;

use App\Entity\Schedule;

interface ScheduleRepositoryInterface
{
    /**
     * @param string $companyId
     * @param string $dateFrom
     * @param string $dateto
     * @return array<Schedule>
     */
    public function getScheduleByCompanyAndDate(string $companyId, string $dateFrom, string $dateto ): array;
}