<?php


namespace App\application\Services\CompanyServices;


use App\application\Domain\Model\Company\Exceptions\NoPropertyException;
use App\application\Domain\Model\Company\Interfaces\CompanyRepositoryInterface;
use App\Entity\Company;

class GetCompanyService
{
    /**
     * @var CompanyRepositoryInterface
     */
    private $companyRepository;
    /**
     * @var string
     */
    private $parameter;

    public function __construct(
        CompanyRepositoryInterface $companyRepository,
        string $parameter
    )
    {
        $this->companyRepository = $companyRepository;
        $this->parameter = $parameter;
    }

    /**
     * @param string $value
     * @return Company
     * @throws NoPropertyException
     */
    public function execute(string $value): Company
    {
        $company = $this->getCompany($value);
        if (empty($company)) {
            return CreateCompanyWithParameterService::createCompany($this->parameter, $value);
        }
        return $company;
    }

    /**
     * @param string $value
     * @return Company|null
     * @throws NoPropertyException
     */
    private function getCompany(string $value): ?Company
    {
        switch ($this->parameter) {
            case 'id' :
                return $this->companyRepository->find($value);
            case 'companyName' :
                return $this->companyRepository->findOneBy(['companyName' => $value]);
            default:
                throw new NoPropertyException();
        }
    }

}