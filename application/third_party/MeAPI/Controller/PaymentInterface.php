<?php
/* @var $cache_user CI_Cache */
interface MeAPI_Controller_PaymentInterface extends MeAPI_Response_ResponseInterface {

    public function add(MeAPI_RequestInterface $request);
    public function success(MeAPI_RequestInterface $request);
}
