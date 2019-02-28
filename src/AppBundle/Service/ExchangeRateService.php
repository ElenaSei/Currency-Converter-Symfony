<?php
/**
 * Created by PhpStorm.
 * User: Valentin
 * Date: 27.02.19
 * Time: 12:40
 */

namespace AppBundle\Service;


use AppBundle\Entity\ExchangeRate;
use AppBundle\Entity\Rate;
use AppBundle\Repository\ExchangeRateRepository;

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