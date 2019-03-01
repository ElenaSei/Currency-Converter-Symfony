<?php

namespace App\Controller;

use App\Service\ApiServiceInterface;
use App\Service\RateServiceInterface;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class DefaultController extends Controller
{
    private $rateService;
    private $apiService;

    /**
     * DefaultController constructor.
     * @param RateServiceInterface $rateService
     * @param ApiServiceInterface $apiService
     */
    public function __construct(RateServiceInterface $rateService, ApiServiceInterface $apiService)
    {
        $this->rateService = $rateService;
        $this->apiService = $apiService;
    }

    /**
     * @Route("/", name="homepage", options={"expose"=true})
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function indexAction(Request $request)
    {
        //make an independent action for this and do it once per day
        //$this->apiService->insertAllRates();

        $allRates =  $this->rateService->getAllRates();

        $result = '';
        if ($request->isMethod('POST')){

            $amount = $request->request->get('amount');
            $currFrom = $request->request->get('currFrom');
            $currTo = $request->request->get('currTo');

            $rateFrom = $this->rateService->getRate($currFrom);
            $rateTo = $this->rateService->getRate($currTo);

            $result = $this->rateService->getConvertedResult($rateFrom, $rateTo, $amount);


            $result = $result . ' ' . $rateTo->getRateName();

            return $this->render('default/index.html.twig',
                ['result' => $result,
                    'rates' => $allRates]);
        }

        return $this->render('default/index.html.twig',
            ['result' => $result,
                'rates' => $allRates]);
    }

    /**
     * @Route("/topRates", name="top_rates", methods="GET", options={"expose"=true})
     */
    public function topRatesAction(){
        $topRates = $this->rateService->getExchangeRatesBetweenTop5();

        return $this->render('default/top_rates.html.twig',
            ['topRates' => $topRates]);
    }
}
