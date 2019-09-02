<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 9/2/19
 * Time: 12:36 PM
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

interface ApiClientInterface
{
    /**
     * @return void
     */
    public function enableDebugMode();

    /**
     * @return void
     */
    public function disableDebugMode();

    /**
     * @param string $currency
     * @param float $amount
     * @param string $m_order
     * @param string $description
     * @param array $additional_params (optional)
     * @return object|CreateBillResponse
     * @throws ApiException
     * @throws Exception
     */
    public function createBill($currency,$amount,$m_order,$description,$additional_params=[]);

    /**
     * @param integer $bill_id
     * @return object|BillResponse
     * @throws ApiException
     * @throws Exception
     */
    public function findByBillId($bill_id);

    /**
     * @param string $m_order
     * @return object|BillResponse
     * @throws ApiException
     * @throws Exception
     */
    public function findByMOrder($m_order);

    /**
     * @param string $m_order
     * @param string $account
     * @param string $currency
     * @param float $amount
     * @param string $description
     * @param array $additional_params (optional)
     * @return object|PayoutResponse
     * @throws ApiException
     * @throws Exception
     */
    public function payout($m_order,$account,$currency,$amount,$description,$additional_params=[]);

    /**
     * @param string $m_order
     * @param string $currency
     * @param float $amount
     * @param string $card_number
     * @param string $description
     * @param array $additional_params (optional)
     * @return object|PayoutResponse
     * @throws ApiException
     * @throws Exception
     */
    public function payoutCard($m_order,$currency,$amount,$card_number,$description,$additional_params=[]);

    /**
     * @param string $m_order
     * @param string $currency
     * @param float $amount
     * @param string $address
     * @param string $description
     * @param array $additional_params (optional)
     * @return object|PayoutResponse
     * @throws ApiException
     * @throws Exception
     */
    public function payoutCrypto($m_order,$currency,$amount,$address,$description,$additional_params=[]);

    /**
     * @return object|BalanceResponse
     * @throws ApiException
     */
    public function balance();

    /**
     * @param string $from
     * @param string $to
     * @param float $amount
     * @return object|RatesResponse
     * @throws ApiException
     * @throws Exception
     */
    public function ratesByAmount($from,$to,$amount);

    /**
     * @param string $from
     * @param string $to
     * @param float $receive_amount
     * @return object|RatesResponse
     * @throws ApiException
     * @throws Exception
     */
    public function ratesByReceiveAmount($from,$to,$receive_amount);

    /**
     * @param array $additional_params (optional)
     * @return object|StatisticResponse
     * @throws ApiException
     * @throws Exception
     */
    public function stats($additional_params=[]);

    /**
     * @param array $additional_params (optional)
     * @return object|HistoryOperationsResponse
     * @throws ApiException
     * @throws Exception
     */
    public function history($additional_params=[]);
}