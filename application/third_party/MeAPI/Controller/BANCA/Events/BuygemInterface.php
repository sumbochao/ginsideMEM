<?php
interface MeAPI_Controller_BANCA_Events_BuygemInterface extends MeAPI_Response_ResponseInterface {
    public function config(MeAPI_RequestInterface $request);
    public function history(MeAPI_RequestInterface $request);
}
