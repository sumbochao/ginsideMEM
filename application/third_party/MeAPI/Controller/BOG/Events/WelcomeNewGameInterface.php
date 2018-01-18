<?php

/* @var $cache_user CI_Cache */

interface MeAPI_Controller_BOG_Events_WelcomeNewGameInterface extends MeAPI_Response_ResponseInterface {

    //Load Template
    public function index(MeAPI_RequestInterface $request);
}
