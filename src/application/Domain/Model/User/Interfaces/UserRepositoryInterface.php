<?php

namespace App\application\Domain\User\Interfaces;

use App\Entity\User;
use Doctrine\ORM\EntityManager;

interface UserRepositoryInterface
{
    public function getUserByLogin(string $login): array;
}