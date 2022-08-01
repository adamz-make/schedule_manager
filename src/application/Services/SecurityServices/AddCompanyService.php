<?php


namespace App\application\Services\SecurityServices;


use App\Entity\Company;
use Doctrine\ORM\EntityManagerInterface;

class AddCompanyService
{
    /**
     * @var EntityManagerInterface
     */
    private $entityManager;
    /**
     * @var CompanyRepositoryInterface
     */
    private $companyRepository;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->companyRepository = $this->entityManager->getRepository(Company::class);
    }
    public function execute($companyName): Company
    {
        $company = $this->entityManager->getRepository(Company::class)->findBy(['CompanyName' => $companyName]);
        if(empty($company)) {
            $company = new Company();
            $company->setCompanyName($companyName);
            $this->entityManager->persist($company);
            $this->entityManager->flush();
        }
        return  is_array($company) ? reset($company) : $company ;
    }

}