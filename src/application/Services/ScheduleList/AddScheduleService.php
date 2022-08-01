<?php

namespace App\application\Services\ScheduleList;

use App\Entity\Schedule;
use Doctrine\ORM\EntityManagerInterface;

class AddScheduleService
{
    /**
     * @var EntityManagerInterface
     */
    private $entityManager;

    /**
     * AddScheduleService constructor.
     * @param EntityManagerInterface $entityManager
     */
    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function execute(Schedule $schedule)
    {
        $this->entityManager->persist($schedule);
        $this->entityManager->flush();
    }
}