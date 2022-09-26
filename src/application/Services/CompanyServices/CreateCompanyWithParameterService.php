<?php


namespace App\application\Services\CompanyServices;


use App\Entity\Company;

class CreateCompanyWithParameterService
{
    public static function createCompany (string $parameter, string $value): Company
    {
        $company = new Company(null, null);
        switch ($parameter) {
            case 'id':
                $company->setId($value);
                return $company;

            case 'companyName':
                $company->setCompanyName($value);
                return $company;
        }
    }
}