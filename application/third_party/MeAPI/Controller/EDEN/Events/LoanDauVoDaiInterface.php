<?php

/* @var $cache_user CI_Cache */

interface MeAPI_Controller_EDEN_Events_LoanDauVoDaiInterface extends MeAPI_Response_ResponseInterface {

    //Load Template
    public function index(MeAPI_RequestInterface $request); 
    
    public function logxephang(MeAPI_RequestInterface $request);  
    
    public function lognhanqua(MeAPI_RequestInterface $request);
    
    public function logthamgia(MeAPI_RequestInterface $request);
    
    //Process   
    public function get_sv_filters(MeAPI_RequestInterface $request);
    
    public function edit_sv_filters(MeAPI_RequestInterface $request);
    
    public function get_server_list(MeAPI_RequestInterface $request);
    
    public function get_top_100(MeAPI_RequestInterface $request);
}
