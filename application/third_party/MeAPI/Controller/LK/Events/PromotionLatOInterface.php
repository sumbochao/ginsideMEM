<?php

/* @var $cache_user CI_Cache */

interface MeAPI_Controller_LK_Events_PromotionLatOInterface extends MeAPI_Response_ResponseInterface {

    //Load Template
    public function index(MeAPI_RequestInterface $request);

    public function productbox(MeAPI_RequestInterface $request);
    
    public function productboxediting(MeAPI_RequestInterface $request);
    
    public function thongke(MeAPI_RequestInterface $request);
    
    public function logdoiqua(MeAPI_RequestInterface $request);
    
    public function logthamgia(MeAPI_RequestInterface $request);
    
    public function logdoiluotbangtien(MeAPI_RequestInterface $request);
    
    public function clearcached(MeAPI_RequestInterface $request);
    
    //Process
    public function test(MeAPI_RequestInterface $request);
    
    public function add_new_item(MeAPI_RequestInterface $request);
    
    public function edit_item(MeAPI_RequestInterface $request);
}
