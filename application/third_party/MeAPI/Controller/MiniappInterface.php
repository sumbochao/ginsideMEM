<?php

/* @var $cache_user CI_Cache */
interface MeAPI_Controller_MiniappInterface extends MeAPI_Response_ResponseInterface {

    public function index(MeAPI_RequestInterface $request);
	public function addmenu(MeAPI_RequestInterface $request);

 }