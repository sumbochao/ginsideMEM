<?php

/* @var $cache_user CI_Cache */

interface MeAPI_Controller_HERO_Events_TopThapBongDemInterface extends MeAPI_Response_ResponseInterface {

    //Load Template
    public function index(MeAPI_RequestInterface $request);
    
    public function giaidau(MeAPI_RequestInterface $request);
    
    public function themgiaidau(MeAPI_RequestInterface $request);
    
    public function chinhsuagiaidau(MeAPI_RequestInterface $request);    
   
    public function giaithuongtop(MeAPI_RequestInterface $request);
    
    public function giaithuongpremiership(MeAPI_RequestInterface $request); 
    
    public function giaithuong(MeAPI_RequestInterface $request);
    
    public function thongke(MeAPI_RequestInterface $request);
    
    public function lichsu(MeAPI_RequestInterface $request);
    
    public function cacheconfig(MeAPI_RequestInterface $request);
    
    public function addcache(MeAPI_RequestInterface $request);
    
    public function cacheedit(MeAPI_RequestInterface $request);
    
    //Process
    public function edit_reward_details(MeAPI_RequestInterface $request);
}