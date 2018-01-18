<?php
interface MeAPI_Controller_Game_Reports_SearchInfoInterface extends MeAPI_Response_ResponseInterface {
    public function index(MeAPI_RequestInterface $request);
    public function loadserver(MeAPI_RequestInterface $request);
}