<?php
interface MeAPI_Controller_FISH_Search_SearchAccountInterface extends MeAPI_Response_ResponseInterface {
    public function accountwallet(MeAPI_RequestInterface $request);
    public function cashin(MeAPI_RequestInterface $request);
    public function cashout(MeAPI_RequestInterface $request);
}