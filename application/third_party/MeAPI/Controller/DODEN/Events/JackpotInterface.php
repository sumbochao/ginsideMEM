<?php
interface MeAPI_Controller_DODEN_Events_JackpotInterface extends MeAPI_Response_ResponseInterface {
    public function config(MeAPI_RequestInterface $request);
    public function history(MeAPI_RequestInterface $request);
}
