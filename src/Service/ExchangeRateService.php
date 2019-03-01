<?php
/**
 * Created by PhpStorm.
 * User: Valentin
 * Date: 27.02.19
 * Time: 12:40
 */

namespace App\Service;


use App\Entity\ExchangeRate;
use App\Repository\ExchangeRateRepository;

class ExchangeRateService implements ExchangeRateServiceInterface
{
    private $exchangeRateRepository;

    /**
     * ExchangeRateService constructor.
     * @param $exchangeRateRepository
     */
    public function __construct(ExchangeRateRepository $exchangeRateRepository)
    {
        $this->exchangeRateRepository = $exchangeRateRepository;
    }


    public function insert(ExchangeRate $exchangeRate): bool
    {
        return $this->exchangeRateRepository->insert($exchangeRate);
    }
}