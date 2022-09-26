<?php

namespace App\application\Domain\Model\Company\Interfaces;

use App\application\Domain\CommonRepository\Interfaces\CommonRepositoryInterface;
use App\Entity\Company;

interface CompanyRepositoryInterface extends CommonRepositoryInterface
{
    public function findAll();

    public function find($id, $lockMode = null, $lockVersion = null);

    public function findOneBy(array $criteria, array $orderBy = null);
}