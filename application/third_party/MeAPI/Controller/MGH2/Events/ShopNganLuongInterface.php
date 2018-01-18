<?php

/* @var $cache_user CI_Cache */

interface MeAPI_Controller_MGH2_Events_ShopNganLuongInterface extends MeAPI_Response_ResponseInterface {

    //Load Template
    public function index(MeAPI_RequestInterface $request);
    
    public function giaidau(MeAPI_RequestInterface $request);
    
    public function themgiaidau(MeAPI_RequestInterface $request);
    
    public function chinhsuagiaidau(MeAPI_RequestInterface $request);
    
    public function quanlyqua(MeAPI_RequestInterface $request);
    
    public function themqua(MeAPI_RequestInterface $request);
    
    public function chinhsuaqua(MeAPI_RequestInterface $request);
    
    public function quanlygoiqua(MeAPI_RequestInterface $request);
    
    public function themgoiqua(MeAPI_RequestInterface $request);
    
    public function chinhsuagoiqua(MeAPI_RequestInterface $request);
    
    public function thongke(MeAPI_RequestInterface $request);
    
    public function lichsu(MeAPI_RequestInterface $request);
    
    public function napthe(MeAPI_RequestInterface $request);
    
    public function doithe(MeAPI_RequestInterface $request);
    
    //Process
    public function add_gift(MeAPI_RequestInterface $request);
    
    public function edit_gift(MeAPI_RequestInterface $request);
    
    public function add_gift_pakage(MeAPI_RequestInterface $request);
    
    public function edit_gift_pakage(MeAPI_RequestInterface $request);
}
