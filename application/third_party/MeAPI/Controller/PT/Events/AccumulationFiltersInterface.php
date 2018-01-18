<?php
interface MeAPI_Controller_PT_Events_AccumulationFiltersInterface extends MeAPI_Response_ResponseInterface {
    public function index_filters(MeAPI_RequestInterface $request);
    public function add_filters(MeAPI_RequestInterface $request);
}