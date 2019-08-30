<?php
/**
 * Created by PhpStorm.
 * User: s.hulko
 * Date: 8/30/19
 * Time: 11:41 AM
 */

namespace Enfins\responses;


class RatesResponse
{
    /** @var string */
    public $withdraw_amount;
    /** @var string */
    public $withdraw_curr;
    /** @var string */
    public $receive_amount;
    /** @var string */
    public $receive_curr;
    /** @var string */
    public $exchange_rate;
}