<?php

namespace App\application\Services\SecurityServices;

use App\application\Domain\User\Interfaces\UserRepositoryInterface;
use App\application\Services\SecurityServices\Exceptions\NoUserException;
use App\application\Services\SecurityServices\Exceptions\WrongPasswordOrLoginException;
use App\Entity\User;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;

class LoginService
{
    /**
     * @var UserRepositoryInterface
     */
    private $userRepository;
    public function __construct(UserRepositoryInterface $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    /**
     * @param string $login
     * @param string $password
     * @throws WrongPasswordOrLoginException
     */
    public function execute(string $login,string $password): void
    {
        /** @var User $user */
       $user = $this->userRepository->getUserByLogin($login);
       if (empty($user)) {
           throw new WrongPasswordOrLoginException();
       }

       if (reset($user)->getPassword() !== $password) {
           throw new WrongPasswordOrLoginException();
       }
    }
}