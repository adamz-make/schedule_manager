<?php

namespace App\application\Domain\CommonRepository\Interfaces;

use Doctrine\ORM\EntityManagerInterface;

Interface CommonRepositoryInterface
{
    public function getEm(): EntityManagerInterface;
}