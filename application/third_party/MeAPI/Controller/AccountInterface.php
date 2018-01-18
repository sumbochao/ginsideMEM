<?php

/* @var $cache_user CI_Cache */
interface MeAPI_Controller_AccountInterface extends MeAPI_Response_ResponseInterface {

    public function index(MeAPI_RequestInterface $request);
    public function getListUser(MeAPI_RequestInterface $request);
    public function add(MeAPI_RequestInterface $request);
    public function searchUserName(MeAPI_RequestInterface $request);
    public function searchUserMenu(MeAPI_RequestInterface $request);
    public function addMenu(MeAPI_RequestInterface $request);
    public function removeMenu(MeAPI_RequestInterface $request);
    public function addUser(MeAPI_RequestInterface $request);
    public function getAllMenu(MeAPI_RequestInterface $request);
    public function changeStatusUser(MeAPI_RequestInterface $request);
	public function noaccess(MeAPI_RequestInterface $request);
}
