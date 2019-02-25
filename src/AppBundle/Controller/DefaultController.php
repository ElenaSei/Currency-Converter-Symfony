<?php

namespace AppBundle\Controller;

use AppBundle\Service\RateServiceInterface;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class DefaultController extends Controller
{
    private $rateService;

    /**
     * DefaultController constructor.
     * @param RateServiceInterface $rateService
     */
    public function __construct(RateServiceInterface $rateService)
    {
        $this->rateService = $rateService;
    }

    /**
     * @Route("/", name="homepage")
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function indexAction(Request $request)
    {
        $allRates =  $this->rateService->getAllRates();

        //make independent action for this!
        $top5rates = $this->rateService->getExchangeRatesBetweenTop5();

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
                    'rates' => $allRates,
                    'top5rates' => $top5rates]);
        }

        return $this->render('default/index.html.twig',
            ['result' => $result,
                'rates' => $allRates,
                'top5rates' => $top5rates]);
    }

    public function topRatesAction(){

    }
}
