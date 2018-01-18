<?php

/* @var $cache_user CI_Cache */

interface MeAPI_Controller_GM_Events_DoPhuongInterface extends MeAPI_Response_ResponseInterface {

    //Load Template
    public function index(MeAPI_RequestInterface $request);
    
    public function quanlyphong(MeAPI_RequestInterface $request);
    
    public function themphong(MeAPI_RequestInterface $request);
    
    public function chinhsuaphong(MeAPI_RequestInterface $request);
    
    public function quanlyphien(MeAPI_RequestInterface $request);
    
    public function themphien(MeAPI_RequestInterface $request);
    
    public function chinhsuaphien(MeAPI_RequestInterface $request);
    
    //NP Shop    
    public function quanlyqua(MeAPI_RequestInterface $request);
    
    public function quanlygoiquagame(MeAPI_RequestInterface $request);
    
    //Report
    public function thongketopdiem(MeAPI_RequestInterface $request);
    
    public function lichsu(MeAPI_RequestInterface $request);
    
    public function lichsutop(MeAPI_RequestInterface $request);
    
    //Process
    public function edit_reward_details(MeAPI_RequestInterface $request);
}
