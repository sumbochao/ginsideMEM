<?php

/* @var $cache_user CI_Cache */

interface MeAPI_Controller_Game_Reports_ReportsInterface extends MeAPI_Response_ResponseInterface {
    public function user_active_byserver(MeAPI_RequestInterface $request); 
    public function topup_byserver(MeAPI_RequestInterface $request);
}
