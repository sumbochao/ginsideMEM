<?php
interface MeAPI_Controller_FISH_Events_BuycardInterface extends MeAPI_Response_ResponseInterface {
    public function config(MeAPI_RequestInterface $request);
    public function history(MeAPI_RequestInterface $request);
}
