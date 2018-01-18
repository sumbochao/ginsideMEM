<?php

/* @var $cache_user CI_Cache */
interface MeAPI_Controller_CronInterface extends MeAPI_Response_ResponseInterface {

    public function activeMobo(MeAPI_RequestInterface $request);
    public function activeCharacter(MeAPI_RequestInterface $request);
    public function activeGameAccount(MeAPI_RequestInterface $request);
    public function inactiveCharacter(MeAPI_RequestInterface $request);
    public function newRegisterMobo(MeAPI_RequestInterface $request);
    public function newRegisterGameAccount(MeAPI_RequestInterface $request);
    public function newRegisterCharacter(MeAPI_RequestInterface $request);
    public function CCU(MeAPI_RequestInterface $request);
    public function payment(MeAPI_RequestInterface $request);
    public function download(MeAPI_RequestInterface $request);
    public function topLevel(MeAPI_RequestInterface $request);
}
