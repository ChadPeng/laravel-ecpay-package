<?php
/**
 * Created by PhpStorm.
 * User: yihua
 * Date: 2018/11/27
 * Time: 下午 3:30
 */

namespace ChadPeng\ECPay;

use Carbon\Carbon;
use Illuminate\Support\Collection;
use ChadPeng\ECPay\Collections\InvoicePostCollection;
use ChadPeng\ECPay\Exceptions\ECPayException;
use ChadPeng\ECPay\Services\StringService;
use ChadPeng\ECPay\Validations\InvoiceValidation;

class Invoice
{
    use ECPayTrait;

    protected $apiUrl;
    protected $postData;
    protected $merchantId;
    protected $hashKey;
    protected $hashIv;
    protected $encryptType='md5';

    protected $checkMacValueIgnoreFields;

    public function __construct(InvoicePostCollection $postData)
    {
        if (config('app.env') == 'production') {
            $this->apiUrl = 'https://einvoice.ecpay.com.tw/Invoice/Issue';
        } else {
            $this->apiUrl = 'https://einvoice-stage.ecpay.com.tw/Invoice/Issue';
        }
        $this->postData = $postData;

        $this->hashKey = config('ecpay.InvoiceHashKey');
        $this->hashIv = config('ecpay.InvoiceHashIV');
        $this->checkMacValueIgnoreFields = [
            'InvoiceRemark', 'ItemName', 'ItemWord', 'ItemRemark', 'CheckMacValue'
        ];
    }

    /**
     * @param $invData
     * @return $this
     * @throws Exceptions\ECPayException
     */
    public function setPostData($invData)
    {
        $this->postData->setData($invData)->setBasicInfo()->setPostData();
        return $this;
    }
}