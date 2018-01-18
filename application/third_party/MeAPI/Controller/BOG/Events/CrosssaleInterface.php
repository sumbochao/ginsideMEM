<?php
interface MeAPI_Controller_BOG_Events_CrosssaleInterface extends MeAPI_Response_ResponseInterface {
    public function history(MeAPI_RequestInterface $request);
}