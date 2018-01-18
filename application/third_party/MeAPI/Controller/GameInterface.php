<?php
/* @var $cache_user CI_Cache */
interface MeAPI_Controller_GameInterface extends MeAPI_Response_ResponseInterface {

    public function infouser(MeAPI_RequestInterface $request);
    public function infolog(MeAPI_RequestInterface $request);
    public function mission(MeAPI_RequestInterface $request);
    public function infotop(MeAPI_RequestInterface $request);
    public function infouslgi(MeAPI_RequestInterface $request);
	public function giftcode(MeAPI_RequestInterface $request);
	public function giftcodeapi(MeAPI_RequestInterface $request);
	public function addgiftcode(MeAPI_RequestInterface $request);
	public function download(MeAPI_RequestInterface $request);
	public function downloadapi(MeAPI_RequestInterface $request);
 }