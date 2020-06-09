<?php
namespace ChadPeng\ECPay\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use ChadPeng\ECPay\Collections\CheckoutResponseCollection;
use ChadPeng\ECPay\Services\StringService;

class ECPayController extends Controller
{
    protected $checkoutResponse;
    public function __construct(CheckoutResponseCollection $checkoutResponse)
    {
        $this->checkoutResponse = $checkoutResponse;
    }

    public function notifyUrl(Request $request)
    {
        $serverPost = $request->post();
        $checkMacValue = $request->post('CheckMacValue');
        unset($serverPost['CheckMacValue']);
        $checkCode = StringService::checkMacValueGenerator($serverPost);
        if ($checkMacValue == $checkCode) {
            return '1|OK';
        } else {
            return '0|FAIL';
        }
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     * @throws \ChadPeng\ECPay\Exceptions\ECPayException
     */
    public function returnUrl(Request $request)
    {
        $serverPost = $request->post();
        $checkMacValue = $request->post('CheckMacValue');
        unset($serverPost['CheckMacValue']);
        $checkCode = StringService::checkMacValueGenerator($serverPost);
        if ($checkMacValue == $checkCode) {
            if (!empty($request->input('redirect'))) {
                return redirect($request->input('redirect'));
            } else {
                dd($this->checkoutResponse->collectResponse($serverPost));
            }
        }
    }
}