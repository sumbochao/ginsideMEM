<?php
interface MeAPI_Controller_HERO_Events_TransferDiamonInterface extends MeAPI_Response_ResponseInterface {
    public function index(MeAPI_RequestInterface $request);
    public function history(MeAPI_RequestInterface $request);
    public function excel(MeAPI_RequestInterface $request);
}