<?php

namespace App\Repository;

use App\application\Domain\Model\Schedule\Interfaces\ScheduleRepositoryInterface;
use App\Entity\Schedule;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Schedule|null find($id, $lockMode = null, $lockVersion = null)
 * @method Schedule|null findOneBy(array $criteria, array $orderBy = null)
 * @method Schedule[]    findAll()
 * @method Schedule[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ScheduleRepository extends ServiceEntityRepository implements ScheduleRepositoryInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Schedule::class);
    }

    // /**
    //  * @return Schedule[] Returns an array of Schedule objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('s.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Schedule
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
    /**
     * @param \DateTimeImmutable $dateFrom
     * @param \DateTimeImmutable $date
     * @return array<Schedule>
     */
    public function getByDates(\DateTimeImmutable $dateFrom, \DateTimeImmutable $date): array
    {
        /*return $this->createQueryBuilder()
            ->andWhere('') */
    }

    /**
     * @param Schedule $schedule
     * @return array<Schedule>
     */
    public function getScheduleByCompanyAndDate(string $companyId, string $dateFrom, string $dateto ): array
    {
         return $this->createQueryBuilder('a')
            ->join('a.company','c')
            ->andWhere('c.id=:company_id')
            ->andWhere('a.date >=:dateFrom')
            ->andWhere('a.date <=:dateTo')
            ->setParameters(['company_id' => $companyId, 'dateFrom' => $dateFrom, 'dateTo' => $dateto])
            ->getQuery()
            ->getResult();
    }
}
