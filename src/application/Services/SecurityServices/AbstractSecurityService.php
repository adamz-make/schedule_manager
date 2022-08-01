<?php


namespace App\application\Services\SecurityServices;

use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AbstractSecurityService
{
    protected $userPasswordHasher;
    public function __construct(UserPasswordHasherInterface $userPasswordHasher )
    {

    }
}