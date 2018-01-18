<?php

/* @var $cache_user CI_Cache */

interface MeAPI_Controller_KOA_Events_TriAnVipInterface extends MeAPI_Response_ResponseInterface {

    //Load Template
    public function index(MeAPI_RequestInterface $request);
    
    public function giaidau(MeAPI_RequestInterface $request);
    
    public function themgiaidau(MeAPI_RequestInterface $request);
    
    public function chinhsuagiaidau(MeAPI_RequestInterface $request);
    
    public function thongke(MeAPI_RequestInterface $request);
    
    public function lichsu(MeAPI_RequestInterface $request);
    
}
