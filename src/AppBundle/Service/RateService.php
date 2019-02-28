<?php
/**
 * Created by PhpStorm.
 * User: Valentin
 * Date: 24.02.19
 * Time: 14:54
 */

namespace AppBundle\Service;


use AppBundle\Entity\ExchangeRate;
use AppBundle\Entity\Rate;
use AppBundle\Repository\RateRepository;
use Unirest;

class RateService implements RateServiceInterface
{
    const URL = 'http://data.fixer.io/api/';
    const ACCESS_KEY = '?access_key=078016de6f923b25d70e29433fd224e3&symbols=';
    const TOP_RATES = ['EUR', 'USD', 'GBP', 'BGN', 'AUD'];

    /**
     * @var \DateTime
     */
    private $date;
    private $rateRepository;

    /**
     * RateService constructor.
     * @param RateRepository $rateRepository
     */
    public function __construct(RateRepository $rateRepository)
    {
        $this->date = new \DateTime('now');
        $this->rateRepository = $rateRepository;

    }

    /**
     * @param string $rateName
     * @return Rate|null
     */
    public function getRate(string $rateName): ?Rate
    {
        /**
         * @var Rate $rate
         */
        $rate = $this->rateRepository->findOneBy(['rateName' => $rateName]);

        return $rate;
    }

    /**
     * @param Rate $rateFrom
     * @param Rate $rateTo
     * @param float $amount
     * @return null|string
     */
    public function getConvertedResult(Rate $rateFrom, Rate $rateTo, float $amount): ?string
    {
        //base EUR
        //get desire currency-EUR exchange rate
        $currFromE = 1 / $rateFrom->getExchangeRates()->last()->getExchange();
        $currToE = 1 / $rateTo->getExchangeRates()->last()->getExchange();

//        dump($rateFrom);
//        dump($rateTo);
//        dump($rateFrom->getExchangeRates()->last()->getExchange());
//        dump($rateTo->getExchangeRates()->last()->getExchange());
//        exit;

        //get exchange rate between two currencies
        $exchangeRate = $currFromE / $currToE;

        //get total result
        $result = $exchangeRate * $amount;

        //round to 4 digit
        $result = sprintf('%.4f', $result);

        return $result;
    }

    /**
     * @return array|Rate
     */
    public function getAllRates(): array
    {
        $topRates = $this->getTopRates();
        $allRatesWithoutTopRates = $this->rateRepository->getAllRatesWithoutTopRates( self::TOP_RATES);

        $allRates = array_merge($topRates, $allRatesWithoutTopRates);

        return $allRates;
    }

    /**
     * @return array|Rate
     */
    public function getTopRates(): array
    {
        $rates = $this->rateRepository->getTopRates(self::TOP_RATES);

        return $rates;
    }

    /**
     * @return array
     */
    public function getExchangeRatesBetweenTop5(): array
    {

        $topRates = $this->getTopRates();

        /**
         * @var Rate $key
         */
        foreach ($topRates as $key) {
            $rateFrom = $key;

            /**
             * @var Rate $kvp
             */
            // every Rate gets an array of other rates, including itself, with exchange rate between it and them
            foreach ($topRates as $kvp) {

                //make new instance because of reference types!
                $rateTo = new Rate();
                $rateTo->setRateName($kvp->getRateName());

                //get only today exchange rate
                $lastExchangeRate = $kvp->getExchangeRates()->last();

                //make new instance because of reference types!
                $exchangeRate = new ExchangeRate();
                $exchangeRate->setDate($lastExchangeRate->getDate());
                $exchangeRate->setRate($rateTo);
                $exchangeRate->setExchange($lastExchangeRate->getExchange());
                
                $rateTo->addExchangeRate($exchangeRate);

                $result = $this->getConvertedResult($rateFrom, $rateTo, 1);
                $exchangeRate->setExchange($result);

                $key->addRate($rateTo);
            }
        }
        return $topRates;
    }

    public function insert(Rate $rate): bool
    {
        return $this->rateRepository->insert($rate);

    }

    public function findOneByName(string $name)
    {
        return $this->rateRepository->findOneBy(['rateName' => $name]);
    }
}