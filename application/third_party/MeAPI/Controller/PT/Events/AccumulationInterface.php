<?php
interface MeAPI_Controller_PT_Events_AccumulationInterface extends MeAPI_Response_ResponseInterface {
    public function index_event(MeAPI_RequestInterface $request);
    public function add_event(MeAPI_RequestInterface $request);
    public function history(MeAPI_RequestInterface $request);
}