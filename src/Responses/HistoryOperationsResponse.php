<?php
/**
 * Created by PhpStorm.
 * User: s.hulko
 * Date: 8/30/19
 * Time: 12:28 PM
 */

namespace Enfins\Responses;


class HistoryOperationsResponse
{
    /** @var OperationResponse[] */
    public $operations;
    /** @var integer */
    public $total;
    /** @var integer */
    public $limit;
    /** @var integer */
    public $offset;

}