<?php
/**
 * Created by PhpStorm.
 * User: s.hulko
 * Date: 8/28/19
 * Time: 5:02 PM
 */

namespace Enfins;

use Enfins\responses\BalanceResponse;
use Enfins\responses\BillResponse;
use Enfins\responses\CreateBillResponse;
use Enfins\responses\HistoryOperationsResponse;
use Enfins\responses\PayoutResponse;
use Enfins\responses\RatesResponse;
use Enfins\responses\StatisticResponse;
use Exception;
use JsonMapper;
use JsonMapper_Exception;
use MCurl\Client;
use MCurl\Result;

class ApiClient
{
    /** @var \JsonMapper */
    private $jsonMapper;
    /** @var string */
    private $ident;
    /** @var string */
    private $secret_key;
    /** @var string */
    private $api_host;
    /** @var boolean */
    private $debug_mode;

    /**
     * @param string $ident
     * @param string $secret_key
     * @param bool $debug_mode
     */
    function __construct($ident,$secret_key,$debug_mode = false) {
        $this->ident = $ident;
        $this->secret_key = $secret_key;
        $this->jsonMapper = new JsonMapper();
        $this->api_host = 'https://qa.enfins.com:9000/v1';
        $this->debug_mode = $debug_mode;
    }

    /**
     * @param $currency
     * @param $amount
     * @param $m_order
     * @param $description
     * @param array $additional_params (optional)
     * @return object|CreateBillResponse
     * @throws JsonMapper_Exception
     * @throws ApiException
     * @throws Exception
     */
    public function createBill($currency,$amount,$m_order,$description,$additional_params=[]){
        $qb = new QueryBuilder("create_bill", $this->api_host, $this->ident,$this->secret_key,"POST");
        $qb->addParam("currency", $currency, true);
        $qb->addParam("amount", $amount, true);
        $qb->addParam("m_order", $m_order, true);
        $qb->addParam("description", $description, true);
        $qb->addParam("payer_id",isset($additional_params['payer_id'])?$additional_params['payer_id']:null, false);
        $qb->addParam("success_url", isset($additional_params['success_url'])?$additional_params['payer_id']:null, false);
        $qb->addParam("fail_url", isset($additional_params['fail_url'])?$additional_params['payer_id']:null, false);
        $qb->addParam("status_url", isset($additional_params['status_url'])?$additional_params['payer_id']:null, false);
        $qb->addParam("m_name", isset($additional_params['m_name'])?$additional_params['payer_id']:null, false);
        $qb->addParam("expire_ttl", isset($additional_params['expire_ttl'])?$additional_params['payer_id']:null, false);
        $qb->addParam("convert_to", isset($additional_params['convert_to'])?$additional_params['payer_id']:null, false);
        $qb->addParam("extra", isset($additional_params['extra'])?$additional_params['payer_id']:null, false);
        $qb->addParam("testing", isset($additional_params['testing'])?$additional_params['payer_id']:null, false);
        $qb->addParam("p_method", isset($additional_params['p_method'])?$additional_params['payer_id']:null, false);
        return $this->jsonMapper->map($this->postRequestData($qb),new CreateBillResponse());
    }

    /**
     * @param integer $bill_id
     * @return object|BillResponse
     * @throws ApiException
     * @throws JsonMapper_Exception
     * @throws Exception
     */
    public function findByBillId($bill_id){
        $qb = new QueryBuilder("find/by_bill_id", $this->api_host, $this->ident,$this->secret_key,"GET");
        $qb->addParam("bill_id", $bill_id, true);
        return $this->jsonMapper->map($this->postRequestData($qb),new BillResponse());
    }

    /**
     * @param string $m_order
     * @return object|BillResponse
     * @throws ApiException
     * @throws JsonMapper_Exception
     * @throws Exception
     */
    public function findByMOrder($m_order){
        $qb = new QueryBuilder("find/by_m_order", $this->api_host, $this->ident,$this->secret_key,"GET");
        $qb->addParam("m_order", $m_order, true);
        return $this->jsonMapper->map($this->postRequestData($qb),new BillResponse());
    }

    /**
     * @param string $m_order
     * @param string $account
     * @param string $currency
     * @param string $amount
     * @param string $description
     * @param array $additional_params (optional)
     * @return object|PayoutResponse
     * @throws ApiException
     * @throws JsonMapper_Exception
     * @throws Exception
     */
    public function payout($m_order,$account,$currency,$amount,$description,$additional_params=[]){
        $qb = new QueryBuilder("payout", $this->api_host, $this->ident,$this->secret_key,"POST");
        $qb->addParam("m_order", $m_order, true);
        $qb->addParam("account", $account, true);
        $qb->addParam("currency", $currency, true);
        $qb->addParam("amount", $amount, true);
        $qb->addParam("description", $description, true);
        $qb->addParam("to_curr", isset($additional_params['to_curr'])?$additional_params['to_curr']:null, false);
        $qb->addParam("testing", isset($additional_params['testing'])?$additional_params['testing']:null, false);
        return $this->jsonMapper->map($this->postRequestData($qb),new PayoutResponse());
    }

    /**
     * @param string $m_order
     * @param string $currency
     * @param string $amount
     * @param string $card_number
     * @param string $description
     * @param array $additional_params (optional)
     * @return object|PayoutResponse
     * @throws ApiException
     * @throws JsonMapper_Exception
     * @throws Exception
     */
    public function payoutCard($m_order,$currency,$amount,$card_number,$description,$additional_params=[]){
        $qb = new QueryBuilder("payout_card", $this->api_host, $this->ident,$this->secret_key,"POST");
        $qb->addParam("m_order", $m_order, true);
        $qb->addParam("card_number", $card_number, true);
        $qb->addParam("currency", $currency, true);
        $qb->addParam("amount", $amount, true);
        $qb->addParam("description", $description, true);
        $qb->addParam("to_curr", isset($additional_params['to_curr'])?$additional_params['to_curr']:null, false);
        $qb->addParam("testing", isset($additional_params['testing'])?$additional_params['testing']:null, false);
        return $this->jsonMapper->map($this->postRequestData($qb),new PayoutResponse());
    }

    /**
     * @param string $m_order
     * @param string $currency
     * @param string $amount
     * @param string $address
     * @param string $description
     * @param array $additional_params (optional)
     * @return object|PayoutResponse
     * @throws ApiException
     * @throws JsonMapper_Exception
     * @throws Exception
     */
    public function payoutCrypto($m_order,$currency,$amount,$address,$description,$additional_params=[]){
        $qb = new QueryBuilder("payout_crypto", $this->api_host, $this->ident,$this->secret_key,"POST");
        $qb->addParam("m_order", $m_order, true);
        $qb->addParam("address", $address, true);
        $qb->addParam("currency", $currency, true);
        $qb->addParam("amount", $amount, true);
        $qb->addParam("description", $description, true);
        $qb->addParam("testing", isset($additional_params['testing'])?$additional_params['testing']:null, false);
        return $this->jsonMapper->map($this->postRequestData($qb),new PayoutResponse());
    }

    /**
     * @return object|BalanceResponse
     * @throws ApiException
     * @throws JsonMapper_Exception
     */
    public function balance(){
        $qb = new QueryBuilder("balance", $this->api_host, $this->ident,$this->secret_key,"GET");
        return $this->jsonMapper->mapArray($this->postRequestData($qb),[],"Enfins\\responses\\BalanceResponse");
    }

    /**
     * @param string $from
     * @param string $to
     * @param integer $amount
     * @return object|RatesResponse
     * @throws ApiException
     * @throws JsonMapper_Exception
     * @throws Exception
     */
    public function ratesByAmount($from,$to,$amount){
        $qb = new QueryBuilder("rates", $this->api_host, $this->ident,$this->secret_key,"GET");
        $qb->addParam("from", $from, true);
        $qb->addParam("to", $to, true);
        $qb->addParam("amount", $amount, true);
        return $this->jsonMapper->map($this->postRequestData($qb),new RatesResponse());
    }

    /**
     * @param string $from
     * @param string $to
     * @param integer $receive_amount
     * @return object|RatesResponse
     * @throws ApiException
     * @throws JsonMapper_Exception
     * @throws Exception
     */
    public function ratesByReceiveAmount($from,$to,$receive_amount){
        $qb = new QueryBuilder("rates", $this->api_host, $this->ident,$this->secret_key,"GET");
        $qb->addParam("from", $from, true);
        $qb->addParam("to", $to, true);
        $qb->addParam("receive_amount", $receive_amount, true);
        return $this->jsonMapper->map($this->postRequestData($qb),new RatesResponse());
    }

    /**
     * @param array $additional_params (optional)
     * @return object|StatisticResponse
     * @throws ApiException
     * @throws JsonMapper_Exception
     * @throws Exception
     */
    public function stats($additional_params=[]){
        $qb = new QueryBuilder("stats", $this->api_host, $this->ident,$this->secret_key,"GET");
        $qb->addParam("currency", isset($additional_params['currency'])?$additional_params['currency']:null, false);
        $qb->addParam("begin", isset($additional_params['begin'])?$additional_params['begin']:null, false);
        $qb->addParam("end", isset($additional_params['end'])?$additional_params['end']:null, false);
        $qb->addParam("operation_type", isset($additional_params['operation_type'])?$additional_params['operation_type']:null, false);
        $qb->addParam("show_testing", isset($additional_params['show_testing'])?$additional_params['show_testing']:null, false);
        return $this->jsonMapper->map($this->postRequestData($qb),new StatisticResponse());
    }

    /**
     * @param array $additional_params (optional)
     * @return object|HistoryOperationsResponse
     * @throws ApiException
     * @throws JsonMapper_Exception
     * @throws Exception
     */
    public function history($additional_params=[]){
        $qb = new QueryBuilder("stats", $this->api_host, $this->ident,$this->secret_key,"GET");
        $qb->addParam("begin", isset($additional_params['begin'])?$additional_params['begin']:null, false);
        $qb->addParam("end", isset($additional_params['end'])?$additional_params['end']:null, false);
        $qb->addParam("status", isset($additional_params['status'])?$additional_params['status']:null, false);
        $qb->addParam("payment_method", isset($additional_params['payment_method'])?$additional_params['payment_method']:null, false);
        $qb->addParam("limit", isset($additional_params['limit'])?$additional_params['limit']:null, false);
        $qb->addParam("offset", isset($additional_params['offset'])?$additional_params['offset']:null, false);
        $qb->addParam("show_testing", isset($additional_params['show_testing'])?$additional_params['show_testing']:null, false);
        return $this->jsonMapper->map($this->postRequestData($qb),new HistoryOperationsResponse());
    }

    /**
     * @param QueryBuilder $qb
     * @return mixed
     * @throws ApiException
     */
    private function postRequestData(QueryBuilder $qb) {
        $curlOptions = [CURLOPT_USERAGENT => $_SERVER['HTTP_USER_AGENT']];
        $curlOptions[CURLINFO_HEADER_OUT] = true;
        $curlOptions[CURLOPT_TIMEOUT] = 20;
        $curlOptions[CURLOPT_HTTPHEADER] = $qb->getRequestHeaders();
        $client = new Client();
        $client->enableHeaders();
        $client->setMaxRequest(20);
        $client->setCurlOption($curlOptions);
        $curlResult = $client->post($qb->getFullUrl(), $qb->getPostRequestParams(true));
        $result = $curlResult->json;
        $this->appendHeaderRequestId($curlResult);

        if ($curlResult->getHttpCode() == 200) {
            if ($result->result === true) {
                if (!property_exists($result, "data")) {
                    return null;
                }
                return $result->data;
            } else {
                $message = "Undefined Error";
                $code = 0;
                if ($result->result === false) {
                    if (property_exists($result, "error")) {
                        $message = $result->error->message;
                        $code = $result->error->code;
                        if (property_exists($result->error, "exception")) {
                            $except = $result->error->exception;
                        }
                    }
                }
                $apiEx = new ApiException($message, $code);
                $apiEx->setBody($result);

                if ($this->debug_mode) {
                    $apiEx->innerMsgAdd("URL: " . $qb->getFullUrl());
                    $apiEx->innerMsgAdd("POST BODY: " . $qb->getPostRequestParams(true));
                    $apiEx->innerMsgAdd("RESULT: " . json_encode($result));
                    if (isset($except)) {
                        $apiEx->innerMsgAdd("EX: ". $except);
                    }
                }
                throw $apiEx;
            }
        } else {
            if($this->debug_mode){
                $message = 'url:' .$qb->getFullUrl().
                    " Status code is not valid".
                    " Code: ".$curlResult->getHttpCode().
                    " Body:".print_r($curlResult->getBody(),1);
            }else{
                $message = "Service is not available now. Please, try again later.";

            }
            $apiEx = new ApiException($message);
            if ($this->debug_mode) {
                $apiEx->innerMsgAdd("Status code: ".$curlResult->getHttpCode());
                $apiEx->innerMsgAdd("URL: " . $qb->getFullUrl());
                $apiEx->innerMsgAdd("POST BODY: " . $qb->getPostRequestParams(true));
            }
            throw $apiEx;
        }
    }

    /**
     * @param Result $curlResult
     * @return void
     */
    private function appendHeaderRequestId(Result $curlResult) {
        if (!headers_sent() && error_get_last() == NULL) {
            $request_id = $this->getRequestId($curlResult);
            header('Request-Id: ' . $request_id, false);
        }
    }

    /**
     * @param Result $curlResult
     * @return string
     */
    private function getRequestId(Result $curlResult) {
        $headersResult = $curlResult->getHeaders();
        $request_id = isset($headersResult['request_id']) ? $headersResult['request_id'] : null;
        return $request_id;
    }



}