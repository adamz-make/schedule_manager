<?php

namespace App\Controller;

use App\application\Services\SecurityServices\AddUserService;
use App\application\Services\SecurityServices\LoginService;
use App\application\Services\SecurityServices\Exceptions\NoUserException;
use App\application\Services\SecurityServices\Exceptions\WrongPasswordOrLoginException;
use App\Application\Services\Utils\ValidationHandler;
use App\Infrastructure\Model\UserRepository;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use http\Params;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class SecurityController extends AbstractController
{
    /**
     * @Route("/logout", name="logout")
     */
    public function logout()
    {

    }

   /* public function login(Request $request, LoginService $loginService) : Response
    {
        $login = $request->get('login');
        $password = $request->get('password');
        $token = $request->get('_csrf_token_login');
        if (!$this->isCsrfTokenValid('auth', $token)) {
            return $this->render('base.html.twig', [
                'errors' => 'ERR-CP-2 Błędny token autoryzacyjny'
            ]);

        }

        try {
            $loginService->execute($login, $password);
        } catch (WrongPasswordOrLoginException $exception) {
            return $this->render('base.html.twig', [
                'errors' => 'ERR-CP-1 Błędne hasło lub login'
            ]);
        }

        return $this->render('base.html.twig', [
            'errors' => ''
        ]);
    } */

    private function toJson($array)
    {
        return json_encode($array);
    }

    /**
     * @Route("/login", name="app_login")
     */
    public function login(AuthenticationUtils $authenticationUtils): Response
    {
        // if ($this->getUser()) {
        //     return $this->redirectToRoute('target_path');
        // }

        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();
        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('security/login.html.twig', ['last_username' => $lastUsername, 'error' => $error]);
    }

}

