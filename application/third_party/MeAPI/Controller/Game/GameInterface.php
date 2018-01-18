<?php
interface MeAPI_Controller_Game_GameInterface extends MeAPI_Response_ResponseInterface {
    public function index(MeAPI_RequestInterface $request);
}