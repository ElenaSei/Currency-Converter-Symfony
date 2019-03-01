<?php
/**
 * Created by PhpStorm.
 * User: Valentin
 * Date: 25.02.19
 * Time: 17:47
 */

namespace App\Service;

use App\Entity\ExchangeRate;
use App\Entity\Rate;
use Unirest;


class ApiService implements ApiServiceInterface
{
    const URL = 'http://data.fixer.io/api/';
    const ACCESS_KEY = '?access_key=078016de6f923b25d70e29433fd224e3&symbols=';
    const TOP_5_RATES = ['EUR', 'USD', 'GBP', 'BGN', 'AUD'];
    /**
     * @var \DateTime
     */
    private $date;
    private $rateService;
    private $exchangeRateService;

    /**
     * RateService constructor.
     * @param RateServiceInterface $rateService
     * @param ExchangeRateServiceInterface $exchangeRateService
     */
    public function __construct(RateServiceInterface $rateService, ExchangeRateServiceInterface $exchangeRateService)
    {
        $this->date = new \DateTime('now');
        $this->exchangeRateService = $exchangeRateService;
        $this->rateService = $rateService;

    }

    public function insertAllRates(): bool
    {
        $response = Unirest\Request::get(self::URL . $this->date->format('Y-m-d') . self::ACCESS_KEY);

        if ($response->body->success === true){
            foreach ($response->body->rates as $key => $value){
                $rate = $this->rateService->findOneByName($key);

                if ($rate === null){
                    $rate = new Rate();
                    $rate->setRateName($key);
                    $this->rateService->insert($rate);
                }

                $exchangeRate = new ExchangeRate();
                $exchangeRate->setExchange($value);
                $exchangeRate->setRate($rate);
                $exchangeRate->setDate($this->date);
                $this->exchangeRateService->insert($exchangeRate);
            }

            return true;
        }

        return false;
    }
}