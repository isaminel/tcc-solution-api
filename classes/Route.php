<?php
/**
 * @package    PHP Advanced API Guide
 * @author     Isabelle Minel <isabelleminel@gmail.com>
 * @copyright  2019 TCCSolution
 * @version    1.0.0
 * @since      File available since Release 1.0.0
 */

namespace TCCSolution;

use TCCSolution\Api;

abstract class Route
{
    /**
     * @var \Slim\Slim
     */
    protected $api;

    public function __construct(Api $api)
    {
        $this->api = $api;
    }
}
