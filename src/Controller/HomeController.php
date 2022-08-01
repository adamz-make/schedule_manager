<?php

namespace App\Controller;


use App\application\Services\AddUserService;
use App\application\Services\LoginService;
use App\Entity\User;
use App\Repository\UserRepository;
use Doctrine\DBAL\Connection;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    /**
     * @Route("home", name="home")
     */
    public function index(Connection $connection): Response
    {
        return $this->render('base.html.twig', [
            'errors' => null
        ]);
    }
    /**
     * @Route("loggedIn", name="loggedIn")
     */
    public function loggedIn()
    {
        return $this->render('logged_in.html.twig');
    }


}