<?php

/* @var $cache_user CI_Cache */

interface MeAPI_Controller_GM_Events_DoiNgocInterface extends MeAPI_Response_ResponseInterface {

    //Load Template
    public function index(MeAPI_RequestInterface $request);
    
    public function lichsu(MeAPI_RequestInterface $request);
    
    //Process
    public function edit_config(MeAPI_RequestInterface $request);
}
