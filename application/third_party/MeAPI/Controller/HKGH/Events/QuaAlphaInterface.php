<?php
interface MeAPI_Controller_HKGH_Events_QuaAlphaInterface extends MeAPI_Response_ResponseInterface {
    public function index(MeAPI_RequestInterface $request);
    public function add(MeAPI_RequestInterface $request);
    public function edit(MeAPI_RequestInterface $request);
    public function delete(MeAPI_RequestInterface $request);
    public function history(MeAPI_RequestInterface $request);
    public function excel(MeAPI_RequestInterface $request);
}