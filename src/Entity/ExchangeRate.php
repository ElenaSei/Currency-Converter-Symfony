<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * ExchangeRate
 *
 * @ORM\Table(name="exchange_rates")
 * @ORM\Entity(repositoryClass="App\Repository\ExchangeRateRepository")
 */
class ExchangeRate
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var float
     *
     * @ORM\Column(name="exchange", type="decimal", precision=20, scale=6)
     */
    private $exchange;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date", type="datetime")
     */
    private $date;

    /**
     * @var Rate
     * @ORM\ManyToOne(targetEntity="App\Entity\Rate", inversedBy="exchangeRates")
     */
    private $rate;


    /**
     * Get id.
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set exchange.
     *
     * @param float $exchange
     *
     * @return ExchangeRate
     */
    public function setExchange($exchange)
    {
        $this->exchange = $exchange;

        return $this;
    }

    /**
     * Get exchange.
     *
     * @return float
     */
    public function getExchange()
    {
        return $this->exchange;
    }

    /**
     * Set date.
     *
     * @param \DateTime $date
     *
     * @return ExchangeRate
     */
    public function setDate($date)
    {
        $this->date = $date;

        return $this;
    }

    /**
     * Get date.
     *
     * @return \DateTime
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * @return mixed
     */
    public function getRate()
    {
        return $this->rate;
    }

    /**
     * @param mixed $rate
     */
    public function setRate($rate): void
    {
        $this->rate = $rate;
    }


}
