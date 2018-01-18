<?php

/* @var $cache_user CI_Cache */

interface MeAPI_Controller_Gmtool_GmtoolInterface extends MeAPI_Response_ResponseInterface {

    //Load Template
    public function index(MeAPI_RequestInterface $request);
	public function submiteventitems(MeAPI_RequestInterface $request);
	public function updateeventitems(MeAPI_RequestInterface $request);

}
