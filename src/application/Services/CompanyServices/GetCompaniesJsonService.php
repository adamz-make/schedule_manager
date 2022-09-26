<?php


namespace App\application\Services\CompanyServices;

use App\application\Domain\Model\Company\Interfaces\CompanyRepositoryInterface;
use App\Entity\Company;

class GetCompaniesJsonService
{
    /**
     * @var CompanyRepositoryInterface
     */
    private $companyRepository;
    /**
     * GetCompaniesJsonService constructor.
     * @param CompanyRepositoryInterface $companyRepository
     */

    public function __construct(CompanyRepositoryInterface $companyRepository)
    {
        $this->companyRepository = $companyRepository;
    }

    /**
     * @return array<Company>
     */
    public function execute(): array
    {

        return  $this->companyRepository->findAll();
        $outArray = [];
        /** @var Company $company */
        foreach ($companies as $company) {
            $outArray[] = $company->jsonSerialize();
        }
        return $outArray;
    }
}