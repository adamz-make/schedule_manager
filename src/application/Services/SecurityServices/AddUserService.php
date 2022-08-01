<?php

namespace App\application\Services\SecurityServices;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;

class AddUserService
{
    /**
     * @var EntityManagerInterface
     */
    private $entityManager;
    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }
    public function execute()
    {
        $user = new User();
        $user->setLogin('adam')
            ->setPassword('lol')
            ->setCompanyId(1);
        $this->entityManager->persist($user);
        $this->entityManager->flush();
     //   $user = new User()
    }
}