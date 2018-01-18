<?php
/* @var $cache_user CI_Cache */
interface MeAPI_Controller_ReportInterface extends MeAPI_Response_ResponseInterface {

    public function index(MeAPI_RequestInterface $request);
    public function reset(MeAPI_RequestInterface $request);
	public function exportdata(MeAPI_RequestInterface $request);
	public function callurl(MeAPI_RequestInterface $request);
	public function giftcode(MeAPI_RequestInterface $request);
}
