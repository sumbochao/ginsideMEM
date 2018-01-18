<?php

/* @var $cache_user CI_Cache */

interface MeAPI_Controller_ShareFacebookInterface extends MeAPI_Response_ResponseInterface {

    public function index(MeAPI_RequestInterface $request);

    public function edit(MeAPI_RequestInterface $request);
    public function domain_list(MeAPI_RequestInterface $request);
    public function domain_edit(MeAPI_RequestInterface $request);
    public function domain_delete(MeAPI_RequestInterface $request);
    
}
