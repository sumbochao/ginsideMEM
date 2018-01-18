<?php
interface MeAPI_Controller_PushNotification_PushNotificationInterface extends MeAPI_Response_ResponseInterface {
    public function index(MeAPI_RequestInterface $request);
    public function add(MeAPI_RequestInterface $request);
}