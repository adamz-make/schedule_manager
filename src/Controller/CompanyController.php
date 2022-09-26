<?php


namespace App\Controller;


use App\application\Domain\Model\Company\Exceptions\NoPropertyException;
use App\application\Services\CompanyServices\GetCompanyService;
use App\Entity\User;
use App\Repository\CompanyRepository;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CompanyController extends AbstractController
{
    /**
     * @var CompanyRepository
     */
    private $companyRepository;
    /**
     * @var UserRepository
     */
    private $userRepository;
    public function __construct(UserRepository $userRepository, CompanyRepository $companyRepository)
    {
        $this->userRepository = $userRepository;
        $this->companyRepository = $companyRepository;
    }
    /**
     * @Route ("companySettings", name="companySettings")
     */
    public function index(): Response
    {
        // TODO check Roles if user can apply changes
       // if ($user->getRoles())
        $response = new Response();
        $err = null;
        $company = null;
        try {
            $company = $this->getCompany();

        } catch (NoPropertyException $ex){
            $err =['err1' => 'nie znany parametr'];
        }
      return $this->render('company_settings.html.twig', [
          'errors' => $err,
          'company' => json_encode($company)
          ]);
    }

    public function saveChanges(Request $request, CompanyRepository $companyRepository): Response
    {
        $postData = json_decode($request->getContent());
        $newCompanyName = $postData->companyName;
        $newRegon = $postData->companyRegon;
        $newNIP = $postData->companyNIP;
        $newAddres = $postData->companyAddress;

        $respone = new Response;
        try {
            $company = $this->getCompany();


        } catch (NoPropertyException $ex){
            $respone->setContent(['err' => 'Nie znany parameter']);
        }
        return $respone->setContent();
    }

    /**
     * @return \App\Entity\Company
     * @throws NoPropertyException
     */
    private function getCompany()
    {
        $user = $this->userRepository->findOneBy(['login' => $this->getUser()->getUserIdentifier()]);
        $getCompanyService = new GetCompanyService($this->companyRepository, 'id');
        return $getCompanyService->execute((string)$user->getCompanyId());
    }
}