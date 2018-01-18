<?php
/* @var $cache_user CI_Cache */
interface MeAPI_Controller_ApiInterface extends MeAPI_Response_ResponseInterface {

    public function apilogin(MeAPI_RequestInterface $request);
    public function index(MeAPI_RequestInterface $request);
	
}
