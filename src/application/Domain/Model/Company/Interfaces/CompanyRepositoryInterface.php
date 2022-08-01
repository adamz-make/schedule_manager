<?php


namespace App\application\Domain\Model\Company\Interfaces;


interface CompanyRepositoryInterface
{
    public function findAll();
    /**
     * @param $id
     * @param null $lockMode
     * @param null $lockVersion
     * @return mixed
     */
    public function find($id, $lockMode = null, $lockVersion = null);
}