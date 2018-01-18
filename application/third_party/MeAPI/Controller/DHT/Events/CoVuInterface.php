<?php

/* @var $cache_user CI_Cache */

interface MeAPI_Controller_DHT_Events_CoVuInterface extends MeAPI_Response_ResponseInterface {

    //Load Template
    public function index(MeAPI_RequestInterface $request);
    
    public function giaidau(MeAPI_RequestInterface $request);
    
    public function themgiaidau(MeAPI_RequestInterface $request);
    
    public function chinhsuagiaidau(MeAPI_RequestInterface $request);
    
    public function trandau(MeAPI_RequestInterface $request);
    
    public function themtrandau(MeAPI_RequestInterface $request);
    
    public function chinhsuatrandau(MeAPI_RequestInterface $request);
    
    public function ketquatrandau(MeAPI_RequestInterface $request);
    
    public function quanlyqua(MeAPI_RequestInterface $request);
    
    public function themqua(MeAPI_RequestInterface $request);
    
    public function chinhsuaqua(MeAPI_RequestInterface $request);
    
    public function lichsu(MeAPI_RequestInterface $request);
    
    public function thongke(MeAPI_RequestInterface $request);
    
    //Process
    public function edit_tournament_details(MeAPI_RequestInterface $request);
    
    public function add_match(MeAPI_RequestInterface $request);
    
    public function edit_match_details(MeAPI_RequestInterface $request);
    
    public function add_gift(MeAPI_RequestInterface $request);
    
    public function edit_gift_details(MeAPI_RequestInterface $request);
}
