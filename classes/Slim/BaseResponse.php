<?php
/**
 * @package    PHP Advanced API Guide
 * @author     Isabelle Minel <isabelleminel@gmail.com>
 * @copyright  2019 TCCSolution
 * @version    1.0.0
 * @since      File available since Release 1.0.0
 */

namespace TCCSolution\Slim;

use Slim\Http\Response;

class BaseResponse extends Response {
    public function withHeaders(array $headers) {
        foreach($headers as $name => $value) {
            $this->headers->set($name, $value);
        }

        return $this;
    }

    public function setHeader($name, $value) {
        return $this->withHeaders([$name => $value]);
    }
}
