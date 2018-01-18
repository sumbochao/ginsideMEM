<?php

/* @var $cache_user CI_Cache */
interface MeAPI_Controller_LoginInterface extends MeAPI_Response_ResponseInterface {

    public function apisetmenu(MeAPI_RequestInterface $request);
    public function apilogin(MeAPI_RequestInterface $request);
    public function index(MeAPI_RequestInterface $request);
    public function captcha(MeAPI_RequestInterface $request);
    public function logout(MeAPI_RequestInterface $request);
	
}
