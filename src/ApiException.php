<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 8/29/19
 * Time: 1:25 PM
 */

namespace Enfins;


use Error;

class ApiException extends \Exception
{
    protected $body;
    private $innerMsg;
    private $apiErrors;

    /**
     * @param string $message
     * @param int $code
     * @param \Exception|null $previous
     */
    public function __construct($message = "", $code = 0, \Exception $previous = null) {
        parent::__construct($this->displayMessage($message), $code, $previous);
    }

    /**
     * @param mixed $body
     */
    public function setBody($body) {
        $this->body = $body;
    }

    /**
     * @param $msg
     * @return
     */
    private function displayMessage($msg) {
        return $msg;
    }

    /**
     * @param $msg
     * @return void
     */
    public function innerMsgAdd($msg) {
        $this->innerMsg[] = $msg;
    }

    public function getHtmlErrorMessage() {
        $adtMsg = "";
        if ($this->innerMsg) {
            $adtMsg = '<span style="display:none">';
            foreach ($this->innerMsg as $val) {
                $adtMsg .= $val."\n";
            }
            $adtMsg .= '</span>';
        }
        return $this->getMessage().$adtMsg;
    }

    /**
     * @return mixed
     */
    public function getBody() {
        return $this->body;
    }

    /**
     * @return mixed
     */
    public function getApiErrors() {
        return $this->apiErrors;
    }

    /**
     * @param mixed $apiErrors
     */
    public function setApiErrors($apiErrors) {
        $this->apiErrors = $apiErrors;
    }

    /**
     * @return Error
     */
    public function getErrorResponse() {
        $response = new Error($this->getMessage(), $this->innerMsg);
        return $response;
    }

}