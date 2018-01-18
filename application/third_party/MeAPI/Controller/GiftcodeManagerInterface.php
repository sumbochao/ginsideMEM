<?php

/* @var $cache_user CI_Cache */
interface MeAPI_Controller_GiftcodeManagerInterface extends MeAPI_Response_ResponseInterface {

    public function index(MeAPI_RequestInterface $request);
    public function addmenu(MeAPI_RequestInterface $request);
    
    public function groupmenu(MeAPI_RequestInterface $request);
    public function addgroupmenu(MeAPI_RequestInterface $request);
    public function addtypegiftcode(MeAPI_RequestInterface $request);
    public function checkgc(MeAPI_RequestInterface $request);
	public function taigc(MeAPI_RequestInterface $request);
 }