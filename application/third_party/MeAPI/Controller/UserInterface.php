<?php

/* @var $cache_user CI_Cache */
interface MeAPI_Controller_UserInterface extends MeAPI_Response_ResponseInterface {

    public function authorize(MeAPI_RequestInterface $request);
    public function userInfomation(MeAPI_RequestInterface $request);
	
}
