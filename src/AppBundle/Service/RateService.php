<?php
/**
 * Created by PhpStorm.
 * User: Valentin
 * Date: 24.02.19
 * Time: 14:54
 */

namespace AppBundle\Service;


use AppBundle\Entity\Rate;
use Unirest;

class RateService implements RateServiceInterface
{
    const URL = 'http://data.fixer.io/api/';
    const ACCESS_KEY = '?access_key=078016de6f923b25d70e29433fd224e3&symbols=';
    const TOP_5_RATES = ['EUR', 'USD', 'GBP', 'BGN', 'AUD'];

    /**
     * @var \DateTime
     */
    private $date;

    /**
     * RateService constructor.
     */
    public function __construct()
    {
        $this->date = new \DateTime('now');

    }

    /**
     * @param string $rateName
     * @return Rate|null
     */
    public function getRate(string $rateName): ?Rate
    {
        $response = Unirest\Request::get(self::URL . $this->date->format('Y-m-d') . self::ACCESS_KEY . $rateName);

        $rate = new Rate();
        $rate->setRateName($rateName);
        $rate->setRateExchange($response->body->rates->$rateName);

        return $rate;
    }

    /**
     * @param string $rateFrom
     * @param string $rateTo
     * @param float $amount
     * @return null|string
     */
    public function getConvertedResult(string $rateFrom, string $rateTo, float $amount): ?string
    {
        $rateFrom = $this->getRate($rateFrom);
        $rateTo = $this->getRate($rateTo);

        //formula - base EUR
        //get desire currency-EUR exchange rate
        $currFromE = 1 /  $rateFrom->getRateExchange();
        $currToE = 1 / $rateTo->getRateExchange();

        //get exchange rate between two currencies
        $exchangeRate = $currFromE / $currToE;

        //get total result
        $result = $exchangeRate * $amount;

        //round to 4 digit
        $result = number_format($result, 4, '.', '.');
        $result = $result . ' ' . $rateTo->getRateName();

        return $result;

    }

    /**
     * @return array|Rate
     */
    public function getAllRates(): array
    {
        $response = Unirest\Request::get(self::URL . $this->date->format('Y-m-d') . self::ACCESS_KEY)
            ->body
            ->rates;

        $top5Rates = $this->getTop5Rates();

        $rates = $rates =$this->createArrayOfRates($response, $top5Rates);

        return $rates;
    }

    /**
     * @return array|Rate
     */
    public function getTop5Rates(): array
    {
        $response = Unirest\Request::get(self::URL . $this->date->format('Y-m-d') . self::ACCESS_KEY . join(',',self::TOP_5_RATES))
            ->body
            ->rates;

        $rates =$this->createArrayOfRates($response);

        return $rates;
    }

    /**
     * @param $response
     * @param null $rates
     * @return array|Rate
     */
    private function createArrayOfRates($response, $rates = null): array{

        foreach ($response as $key => $value){
            if ($rates === null){
                $rate = new Rate();
                $rate->setRateName($key);
                $rate->setRateExchange($value);
                $rates[$rate->getRateName()] = $rate;
            }else if (!in_array($key, $rates)){
                $rate = new Rate();
                $rate->setRateName($key);
                $rate->setRateExchange($value);
                $rates[$rate->getRateName()] = $rate;
            }
        }

        return $rates;
    }
}