<?php
interface MeAPI_Controller_LK_Events_PrimetimeInterface extends MeAPI_Response_ResponseInterface {
    public function config(MeAPI_RequestInterface $request);
    public function history(MeAPI_RequestInterface $request);
}
