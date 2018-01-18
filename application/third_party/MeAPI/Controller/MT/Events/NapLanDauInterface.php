<?php

/* @var $cache_user CI_Cache */

interface MeAPI_Controller_MT_Events_NapLanDauInterface extends MeAPI_Response_ResponseInterface {

    //Load Template
    public function index(MeAPI_RequestInterface $request);
    
    public function sukien(MeAPI_RequestInterface $request);
    
    public function themsukien(MeAPI_RequestInterface $request);
    
    public function chinhsuasukien(MeAPI_RequestInterface $request);
    
    public function lichsu(MeAPI_RequestInterface $request);
    
    //Process     
}
