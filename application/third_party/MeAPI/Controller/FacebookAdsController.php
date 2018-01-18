<?php
require_once APPPATH . 'third_party/Facebook/php-ads-sdk/autoload.php';
require_once APPPATH . 'third_party/Facebook/facebook-php-sdk-v4-master/src/Facebook/autoload.php';

use FacebookAds\Object\AdUser;

use FacebookAds\Api;
use FacebookAds\Object\AdAccount;
use FacebookAds\Object\Fields\ConnectionObjectFields;
use FacebookAds\Object\Fields\AdAccountFields;
use FacebookAds\Object\Values\CallToActionTypes;

use FacebookAds\Object\Campaign;
use FacebookAds\Object\Fields\CampaignFields;
use FacebookAds\Object\Values\AdObjectives;

use FacebookAds\Object\AdImage;
use FacebookAds\Object\Fields\AdImageFields;


use FacebookAds\Object\TargetingSearch;
use FacebookAds\Object\Search\TargetingSearchTypes;


use FacebookAds\Object\TargetingSpecs;
use FacebookAds\Object\Fields\TargetingSpecsFields;


use FacebookAds\Object\AdSet;
use FacebookAds\Object\Fields\AdSetFields;
use FacebookAds\Object\Values\BillingEvents;
use FacebookAds\Object\Values\OptimizationGoals;


use FacebookAds\Object\AdCreative;
use FacebookAds\Object\ObjectStory\LinkData;
use FacebookAds\Object\Fields\ObjectStory\LinkDataFields;
use FacebookAds\Object\ObjectStorySpec;
use FacebookAds\Object\Fields\ObjectStorySpecFields;
use FacebookAds\Object\Fields\AdCreativeFields;
use FacebookAds\Object\Values\PageTypes;

use FacebookAds\Object\Ad;
use FacebookAds\Object\Fields\AdFields;



use Facebook\Facebook;
use Facebook\Exceptions\FacebookResponseException;
use Facebook\Exceptions\FacebookSDKException;

class MeAPI_Controller_FacebookAdsController  implements MeAPI_Controller_FacebookAdsInterface
{
    /* @var $cache_user CI_Cache */
    /* @var $cache CI_Cache */
    protected $_response;

    /**
     *
     * @var CI_Controller
     */
    private $CI;
    private $api;
    private $account_id = '';
    private $app_id = '';
    private $access_token = '';
    private $app_secret = '';
    public function __construct()
    {

        $this->CI = &get_instance();

        /*
         * Load default
         */
        $this->CI->load->MeAPI_Library('Session');
        $this->CI->load->library('cache');
        $this->CI->load->library('Template');
        $this->CI->load->helper('url');
        $this->CI->load->library('pagination');
        $this->CI->load->library('Quick_CSV_import');
        $this->CI->load->MeAPI_Model('FacebookAdsModel');

        $this->data['session_account'] = $this->CI->Session->get_session('account');
        $this->data['session_menu'] = $this->CI->Session->get_session('menu');

        $this->authorize = new MeAPI_Controller_AuthorizeController();


        $this->view_data = new stdClass();
        $this->app_id = "533414373498024";
        $this->app_secret = "e48719db47bce8cae1005809cd0ab192";




        //login facebook
       $fb = new Facebook([
            'app_id' => $this->app_id,
            'app_secret' => $this->app_secret,
        ]);

        $helper = $fb->getRedirectLoginHelper();

        if (!isset($_SESSION['facebook_access_token'])) {
            $_SESSION['facebook_access_token'] = null;
        }

        if (!$_SESSION['facebook_access_token']) {
            $helper = $fb->getRedirectLoginHelper();
            try {
                $_SESSION['facebook_access_token'] = (string) $helper->getAccessToken();
            } catch(FacebookResponseException $e) {
                // When Graph returns an error
                echo 'Graph returned an error: ' . $e->getMessage();
                exit;
            } catch(FacebookSDKException $e) {
                // When validation fails or other local issues
                echo 'Facebook SDK returned an error: ' . $e->getMessage();
                exit;
            }
        }

        if (!$_SESSION['facebook_access_token']) {
            $permissions = ['ads_management'];
            $loginUrl = $helper->getLoginUrl('http://ginside.mobo.vn/?control=facebook_ads&func=index&module=all', $permissions);
            echo '<a href="' . $loginUrl . '">Log in with Facebook</a>';die;
        }
        $this->access_token = $_SESSION['facebook_access_token'];
        $this->access_token = "CAAHlIzZAAHKgBANhL1F06f4jhK0doYXoZBW1wTS72INPPtPXJuc3S6ZCJOndxt2OJ0Krh2IsPkxgg4SFzZBXxxIuA1wFKT4Jvo1CQXWA9qIdVXN7cSE92P5PPZAxSXkpEfjf3oQaQ4rgZBAHvsDJTtYJZAYBBVEFb3DMqZAT0eEgkETA3M4BOYIejXuZAvWMTCzAZD";
//        echo "<pre>";print_r($this->access_token);die;

        if (is_null($this->access_token) || is_null($this->app_id) || is_null($this->app_secret)) {
            throw new \Exception(
                'You must set your access token, app id and app secret before executing'
            );
        }


        if(is_null($this->api))
            $this->api = Api::init($this->app_id, $this->app_secret, $this->access_token);


        //get ad account_id
        if($this->account_id == ''){
            $me = new AdUser('me');
            $my_adaccount = $me->getAdAccounts()->current();
            $this->account_id = $my_adaccount->getData()['account_id'];
            $this->account_id = "act_1563437377305791";
        }
        if (is_null($this->account_id)) {
            throw new \Exception(
                'You must set your account id before executing');
        }
    }

    //Load Template
    public function index(MeAPI_RequestInterface $request)
    {

        $target = new TargetingSpecs();
        $target->setData(array(
            TargetingSpecsFields::GEO_LOCATIONS => array(
                'countries' => array(
                    'US',
                ),
            )));
//        die('index');
        $account_id = $this->account_id;

        $account = (new AdAccount($account_id))->read(array(
            AdAccountFields::ID,
            AdAccountFields::NAME,
            AdAccountFields::BUSINESS,
            AdAccountFields::ACCOUNT_STATUS,
            AdAccountFields::BALANCE
        ));
        if(isset($_SESSION['apps'])){
            $this->data['apps'] = $_SESSION['apps'];
        }else{
            $connectionObjects = $account->getConnectionObjects();
            $apps = array();
            foreach($connectionObjects as $object){
                $apps[] = $object->getData();
            }
//        echo "<pre>";print_r($apps);die;
            $_SESSION['apps'] = $this->data['apps'] = $apps;
        }


        //get list action
        $actionObject = CallToActionTypes::getInstance();
        $listAction = $actionObject->getValues();
        $this->data['listAction'] = $listAction;


        //get list page
        if (isset($_SESSION['listPage'])) {
            $listPage = $_SESSION['listPage'];
        } else {
            $graphObject = $this->api->call("/me/accounts");
            $listPage = json_decode($graphObject->getBody(), true)['data'];
            $_SESSION['listPage'] = $listPage;
        }
        $this->data['listPage'] = $listPage;
        //get list objectives of campaign
        /*$adObjectives = AdObjectives::getInstance();
        $listAdObjectives = $adObjectives->getValues();
        $this->data['listAdObjectives'] = $listAdObjectives;*/


        //get uploaded images
        $images = $account->getAdImages(
            array(
                AdImageFields::URL,
                AdImageFields::HASH,
                AdImageFields::NAME,

            )
        );
        $listImg = array();
        foreach($images as $img){
            $listImg[] = array(
                'name' => $img->{AdImageFields::NAME},
                'hash' => $img->{AdImageFields::HASH},
                'url' => $img->{AdImageFields::URL},
            );
        }
        $_SESSION['listImg'] =  $this->data['listImg'] = $listImg;

//        echo "<pre>";print_r($listImg);die;

        $this->authorize->validateAuthorizeRequest($request, 0);
        $this->CI->template->write_view('content', 'FacebookAds/createAds', $this->data);
        $this->_response = new MeAPI_Response_HTMLResponse($request, $this->CI->template->getHTML());

    }



    public function getResponse()
    {
        return $this->_response;
    }

    public function appChangeEvent()
    {
        $appID = $_POST['appID'];
        $platform = $_POST['platform'];
        $arr['platform'] = $platform;
        $apps = $_SESSION['apps'];
        foreach ($apps as $app) {
            if ($appID == $app['id']) {
                $arr['object_store_urls'] = $app['object_store_urls'];
                $arr['id'] = $app['id'];
                $arr['name'] = $app['name'];
                break;
            }
        }
//        echo "<pre>";print_r($arr);die;
        echo $view = $this->CI->load->view('FacebookAds/object_store_urls', $arr, true);
        die;

    }

    public function createAds()
    {

//        echo "<pre>";print_r(phpversion());die;


        $appURL_IOS = '';
        $appURL_Android = '';
        $campaign = $_POST['campaign'];
        $start_time = $_POST['start_time'];
        $stop_time = $_POST['stop_time'];
        $adObjectives = $_POST['adObjectives'];


        $platform = $_POST['platform'];
        $app = $_POST['app'];


        $this->api = Api::init($app, $this->app_secret, $this->access_token);

        $campaign_data = array(
            'app_id' => $app,
            'access_token' => $this->access_token,
            'app_secret' => $this->app_secret,
            'account_id' => $this->account_id
        );


        if (isset($_POST['appURL_IOS']))
            $appURL_IOS = $_POST['appURL_IOS'];

        if (isset($_POST['appURL_Android']))
            $appURL_Android = $_POST['appURL_Android'];

        $action = $_POST['action'];
        $page = $_POST['page'];
        $headline = $_POST['headline'];
        $message = $_POST['message'];
        $image = array();
        if (isset($_FILES['image']['name']) && $_FILES['image']['name'][0] != '')
            $image = $_FILES['image']['name'];

        //user chose uploaded images, update $image variable
        $update_data2 = array();
        $listImg = $_SESSION['listImg'];
        $image_string = $_POST['image_name'];
        if(trim($image_string)  != ''){
            $uploaded_images = explode(',',$image_string);
            foreach($uploaded_images as $u_image){
                foreach($listImg as $l_img){
                    if($l_img['name'] == $u_image){
                        $image[] = $u_image;
                        $update_data2[] = array('image' => $u_image, 'image_hash' => $l_img['hash']);
                        break;
                    }
                }
            }
        }

//        echo "<pre>";print_r($update_data2);die;
        $data = array();
        foreach ($_POST['platform'] as $plat) {
            //call facebook to create campaign
            if ($plat == 'itunes')
                $appURL = $appURL_IOS;
            elseif ($plat == 'google_play')
                $appURL = $appURL_Android;
            $campaign_data['appURL'] = $appURL;
            $campaign_data['platform'] = $plat;
            $campaignID = $this->createCampaign($campaign . ' - ' . $plat, $start_time, $stop_time, $adObjectives, $campaign_data);
            foreach ($headline as $h) {
                foreach ($message as $m) {
                    foreach ($image as $i => $img) {
                        $data[] = array(
                            'app' => $app,
                            'appURL_IOS' => $appURL_IOS,
                            'appURL_Android' => $appURL_Android,
                            'platform' => $plat,
                            'action' => $action,
                            'page' => $page,
                            'headline' => $h,
                            'message' => $m,
                            'image' => $img,
                            'created_time' => date('Y-m-d H:i:s'),
                            'campaignID' => $campaignID,
                            'campaign_name' => $campaign . ' - ' . $plat,
                            'account_id' => $this->account_id
                        );
                    }
                }
            }
        }
        if ($this->CI->FacebookAdsModel->insert_batch('f_ads', $data)) {
            //upload file
            $number_of_files = sizeof($_FILES['image']['tmp_name']);
            $update_data = array();
            if($number_of_files > 0 && $_FILES['image']['tmp_name'][0] != ''){
                $files = $_FILES['image'];
                $this->CI->load->library('upload');
                $config['upload_path'] = FCPATH . '/assets/img/FacebookAds';
                $config['allowed_types'] = 'gif|jpg|png';
                //now we initialize the upload library
                $this->CI->upload->initialize($config);

//            echo "<pre>";print_r($config);die;
                $listImage = array();
                for ($i = 0; $i < $number_of_files; $i++) {
                    $_FILES['image']['name'] = $files['name'][$i];
                    $_FILES['image']['type'] = $files['type'][$i];
                    $_FILES['image']['tmp_name'] = $files['tmp_name'][$i];
                    $_FILES['image']['error'] = $files['error'][$i];
                    $_FILES['image']['size'] = $files['size'][$i];

                    // we retrieve the number of files that were uploaded
                    $this->CI->upload->do_upload('image');


                    //upload image to facebook
                    $image = new AdImage(null, $this->account_id);
                    $image->{AdImageFields::FILENAME} = FCPATH . '/assets/img/FacebookAds/' . $files['name'][$i];

                    $image->create();
                    $image_hash = $image->{AdImageFields::HASH};
                    $listImage[$files['name'][$i]] = $image_hash;
//                    echo 'Image Hash: '.$image->{AdImageFields::HASH}.PHP_EOL;
                }

                //update hash for image
                foreach ($listImage as $k => $v) {
                    $update_data[] = array('image' => $k, 'image_hash' => $v);
                }

            }

            if(count($update_data2) > 0 || count($update_data) > 0){
                $u_data = array_merge($update_data2,$update_data);
            }
            $this->CI->FacebookAdsModel->update_batch('f_ads', $u_data, 'image');

        }
        $_SESSION['new_ads'] =  json_encode($data);
        header("Location:?control=facebook_ads&func=showAds&module=all#create_ads");
    }

    public function showAds(MeAPI_RequestInterface $request)
    {

       $new_ads = json_decode($_SESSION['new_ads']) ;
        foreach($new_ads as $i => $ad){
            if(file_exists(APPLICATION_URL.'/assets/img/FacebookAds/'.$ad->image)){
                $new_ads[$i]['img_src']= APPLICATION_URL.'/assets/img/FacebookAds/'.$ad->image;
            }else{
                $listImg =  $_SESSION['listImg'] ;
                foreach($listImg as $img){
                    if($img['name'] == $ad->image){
                        $new_ads[$i]->img_src = $img['url'];
                        break;
                    }
                }

            }
        }
//        echo "<pre>";print_r( $new_ads );die;

        $this->data['new_ads'] = json_encode($new_ads) ;
        $this->authorize->validateAuthorizeRequest($request, 0);
        $this->CI->template->write_view('content', 'FacebookAds/newAds', $this->data);
        $this->_response = new MeAPI_Response_HTMLResponse($request, $this->CI->template->getHTML());
    }


    private function createCampaign($name, $start_time, $stop_time, $adObjectives, $campaign_data)
    {

        $account_id = $this->account_id;

        $campaign = new Campaign(null, $account_id);
        $campaign->setData(array(
            CampaignFields::ACCOUNT_ID => $account_id,
            CampaignFields::NAME => $name,
            CampaignFields::OBJECTIVE => $adObjectives/*,
            CampaignFields::START_TIME => $start_time,
            CampaignFields::STOP_TIME => $stop_time*/
        ));

        $cp = $campaign->create(array(
            Campaign::STATUS_PARAM_NAME => Campaign::STATUS_PAUSED,
        ));
        $data = $cp->getData();
        $insert_data = array_merge($data,$campaign_data);
        $insert_data['created_time'] = date('Y-m-d H:i:s');
        $this->CI->FacebookAdsModel->insert('f_campaigns', $insert_data);
        return $data['id'];
    }


    public function createTargetingView(MeAPI_RequestInterface $request)
    {

        /*$adset = new AdSet("6041454374101");
                $adset->read(array(
            AdSetFields::ACCOUNT_ID,
            AdSetFields::ADSET_SCHEDULE,
            AdSetFields::BID_AMOUNT,
            AdSetFields::BILLING_EVENT,
            AdSetFields::BUDGET_REMAINING,
            AdSetFields::CAMPAIGN_ID,
            AdSetFields::CREATED_TIME,
            AdSetFields::CREATIVE_SEQUENCE,
            AdSetFields::DAILY_BUDGET,
            AdSetFields::END_TIME,
            AdSetFields::ID,
            AdSetFields::IS_AUTOBID,
            AdSetFields::LIFETIME_BUDGET,
            AdSetFields::LIFETIME_IMPS,
            AdSetFields::NAME,
            AdSetFields::OPTIMIZATION_GOAL,
            AdSetFields::PACING_TYPE,
            AdSetFields::RF_PREDICTION_ID,
            AdSetFields::START_TIME,
            AdSetFields::UPDATED_TIME,
            AdSetFields::TARGETING,
            AdSetFields::PROMOTED_OBJECT,
            AdSetFields::ADLABELS,
            AdSetFields::PRODUCT_AD_BEHAVIOR
        ));
//
        echo "<pre>";print_r($adset->getData());die;*/


        //get countries
        $countries = array();
        $country_name = array();

        if (isset($_SESSION['countries'])) {
            $countries = $_SESSION['countries'];
            $country_name = $_SESSION['country_name'];
        } else {
            $result = TargetingSearch::search(
                TargetingSearchTypes::GEOLOCATION,
                null,
                null,
                array(
                    'location_types' => array('country'),
                    'limit' => 1000
                )
            );


            foreach ($result as $key => $value) {
                $countries[$value->name] = $value->country_code;
                $country_name[] = $value->name;
//            echo "<br>" . $value->name . " - " . $value->country_code . "<br>";
            }
            $_SESSION['countries'] = $countries;
            $_SESSION['country_name'] = $country_name;
        }
//        echo "<pre>";print_r($result);die;
        $this->data['country_name'] = json_encode($country_name);


        //get locale
        $locale = array();
        $locale_name = array();
        if (isset($_SESSION['locale'])) {
            $locale = $_SESSION['locale'];
            $locale_name = $_SESSION['locale_name'];
        } else {
            $result = TargetingSearch::search(
                TargetingSearchTypes::LOCALE,
                null,
                null);
            foreach ($result as $key => $value) {
                $locale[$value->name] = $value->key;
                $locale_name[] = $value->name;
            }
            $_SESSION['locale'] = $locale;
            $_SESSION['locale_name'] = $locale_name;
        }
        $this->data['locale_name'] = json_encode($locale_name);


        //get interest
        $interest = array();
        $interest_name = array();
        if (isset($_SESSION['interest'])) {
            $interest = $_SESSION['interest'];
            $interest_name = $_SESSION['interest_name'];
        } else {
            $result = TargetingSearch::search(
                TargetingSearchTypes::TARGETING_CATEGORY,
                'interests');

//        echo "<pre>";print_r( $result);die;
            foreach ($result as $key => $value) {
                $interest[$value->name] = $value->id;
                $interest_name[] = $value->name;
            }
            $_SESSION['interest'] = $interest;
            $_SESSION['interest_name'] = $interest_name;
        }

        $this->data['interest_name'] = json_encode($interest_name);

        //ADSET
        //GET Optimization Goals
        $optimizationGoals = new OptimizationGoals();
        $goals = $optimizationGoals->getValues();
        $this->data['goals'] = $goals;


        //get BillingEvents
        $billingEvents = new BillingEvents();
        $billings = $billingEvents->getValues();
        $this->data['billings'] = $billings;
//        echo "<pre>";print_r( $billings);die;

        //get campaigns that be created before
        $campaigns = $this->CI->FacebookAdsModel->getList('*', 'f_campaigns');
        $this->data['campaigns'] = $campaigns;

        $this->authorize->validateAuthorizeRequest($request, 0);
        $this->CI->template->write_view('content', 'FacebookAds/createTargeting', $this->data);
        $this->_response = new MeAPI_Response_HTMLResponse($request, $this->CI->template->getHTML());
    }


    public function createTargeting(MeAPI_RequestInterface $request)
    {

//        echo "<pre>";print_r($_POST['user_os']);die;
        $campaign_id = $_POST['campaign'];
        $campaigns = $this->CI->FacebookAdsModel->getList('*', 'f_campaigns', array('id' => $campaign_id));
        $appURL = $campaigns[0]['appURL'];
        $platform = $campaigns[0]['platform'];

        //init api again
        $app_id = $campaigns[0]['app_id'];
        $access_token = $campaigns[0]['access_token'];
        $app_secret = $campaigns[0]['app_secret'];
        $account_id = $campaigns[0]['account_id'];
        $api = Api::init($app_id, $app_secret, $access_token);


        $tags_country = explode(',', $_POST['tags_country']);
        if (trim(end($tags_country)) == '') {
            array_pop($tags_country);
        }

        $tags_locale = explode(',', $_POST['tags_locale']);
        if (trim(end($tags_locale)) == '') {
            array_pop($tags_locale);
        }

        $tags_interest = explode(',', $_POST['tags_interest']);
        if (trim(end($tags_interest)) == '') {
            array_pop($tags_interest);
        }

        //get all ad depend on this campaign
        $ads = $this->CI->FacebookAdsModel->getList('*', 'f_ads', array('campaignID' => $campaign_id));
//        echo "<pre>";print_r( $tags_locale);die;

        //create targeting
        $targeting = new TargetingSpecs();
        $targeting->{TargetingSpecsFields::PAGE_TYPES} = $_POST['placement'];
        $user_os = array();
        foreach ($_POST['user_os'] as $val) {
            if ($val == 'iOS,Android') {
                $user_os[] = 'iOS';
                $user_os[] = 'Android';
            } else {
                $user_os[] = $val;
            }
        }
//        echo "<pre>";print_r( $user_os);die;
        $targeting->{TargetingSpecsFields::USER_OS} = $user_os;

        $locales = $_SESSION['locale'];
        $interest = $_SESSION['interest'];
        $countries = $_SESSION['countries'];
//        echo "<pre>";print_r( $locales['English (US)']);die;
        $targeting_queue = array();

        //COUNTRY SPLIT
        if ($_POST['rdo_location'] == 'split') {
            foreach ($tags_country as $country) {
                $targeting->{TargetingSpecsFields::GEO_LOCATIONS} = array(
                    'countries' => array($countries[trim($country)])
                );

                //LANGUAGE
                if ($_POST['rdo_lang'] == 'split') {
                    foreach ($tags_locale as $locale) {
                        $targeting->{TargetingSpecsFields::LOCALES} = array(
                            $locales[trim($locale)]
                        );

                        //AGE
                        if ($_POST['rdo_age'] == 'split') {
                            $tags_age = array();
                            for ($i_start_age = 0; $i_start_age < count($_POST['start_age']); $i_start_age++) {

                                $targeting->{TargetingSpecsFields::AGE_MIN} = $_POST['start_age'][$i_start_age];
                                $targeting->{TargetingSpecsFields::AGE_MAX} = $_POST['end_age'][$i_start_age];


                                //GENDER
                                if ($_POST['radio_sex'] == 'split') {

                                    for ($i = 1; $i <= 2; $i++) {

                                        $targeting->{TargetingSpecsFields::GENDERS} = array($i);

                                        //INTEREST
                                        if ($_POST['rdo_interest'] == 'split') {
                                            foreach ($tags_interest as $tag_interest) {

                                                $targeting->{TargetingSpecsFields::INTERESTS} = array(
                                                    array(
                                                        'id' => $interest[trim($tag_interest)],
                                                        'name' => $tag_interest,
                                                    )
                                                );
                                                $target = clone $targeting;
                                                $targeting_queue[] = $target;

                                            }
                                        } else { //INTEREST ANY
                                            $arr = array();
                                            foreach ($tags_interest as $tag_interest) {
                                                $arr[] = array(
                                                    'id' => $interest[trim($tag_interest)],
                                                    'name' => $tag_interest
                                                );
                                            }
                                            $targeting->{TargetingSpecsFields::INTERESTS} = $arr;

                                            $target = clone $targeting;
                                            $targeting_queue[] = $target;
                                        }

                                    }

                                } else { //GENDER ANY
                                    if ($_POST['rdo_sex'] != '')
                                        $targeting->{TargetingSpecsFields::GENDERS} = array($_POST['rdo_sex']);
                                    //INTEREST
                                    if ($_POST['rdo_interest'] == 'split') {
                                        foreach ($tags_interest as $tag_interest) {

                                            $targeting->{TargetingSpecsFields::INTERESTS} = array(
                                                array(
                                                    'id' => $interest[trim($tag_interest)],
                                                    'name' => $tag_interest,
                                                )
                                            );
                                            $target = clone $targeting;
                                            $targeting_queue[] = $target;

                                        }
                                    } else { //INTEREST ANY
                                        $arr = array();
                                        foreach ($tags_interest as $tag_interest) {
                                            $arr[] = array(
                                                'id' => $interest[trim($tag_interest)],
                                                'name' => $tag_interest
                                            );
                                        }
                                        $targeting->{TargetingSpecsFields::INTERESTS} = $arr;

                                        $target = clone $targeting;
                                        $targeting_queue[] = $target;
                                    }
                                }

                            }

                        } else { //AGE ANY
                            $targeting->{TargetingSpecsFields::AGE_MIN} = $_POST['start_age'][0];
                            $targeting->{TargetingSpecsFields::AGE_MAX} = $_POST['end_age'][0];

                            //GENDER
                            if ($_POST['radio_sex'] == 'split') {

                                for ($i = 1; $i <= 2; $i++) {

                                    $targeting->{TargetingSpecsFields::GENDERS} = array($i);

                                    //INTEREST
                                    if ($_POST['rdo_interest'] == 'split') {
                                        foreach ($tags_interest as $tag_interest) {

                                            $targeting->{TargetingSpecsFields::INTERESTS} = array(
                                                array(
                                                    'id' => $interest[trim($tag_interest)],
                                                    'name' => $tag_interest,
                                                )
                                            );
                                            $target = clone $targeting;
                                            $targeting_queue[] = $target;

                                        }
                                    } else { //INTEREST ANY
                                        $arr = array();
                                        foreach ($tags_interest as $tag_interest) {
                                            $arr[] = array(
                                                'id' => $interest[trim($tag_interest)],
                                                'name' => $tag_interest
                                            );
                                        }
                                        $targeting->{TargetingSpecsFields::INTERESTS} = $arr;

                                        $target = clone $targeting;
                                        $targeting_queue[] = $target;
                                    }

                                }

                            } else { //GENDER ANY
                                if ($_POST['rdo_sex'] != '')
                                    $targeting->{TargetingSpecsFields::GENDERS} = array($_POST['rdo_sex']);
                                //INTEREST
                                if ($_POST['rdo_interest'] == 'split') {
                                    foreach ($tags_interest as $tag_interest) {

                                        $targeting->{TargetingSpecsFields::INTERESTS} = array(
                                            array(
                                                'id' => $interest[trim($tag_interest)],
                                                'name' => $tag_interest,
                                            )
                                        );
                                        $target = clone $targeting;
                                        $targeting_queue[] = $target;

                                    }
                                } else { //INTEREST ANY
                                    $arr = array();
                                    foreach ($tags_interest as $tag_interest) {
                                        $arr[] = array(
                                            'id' => $interest[trim($tag_interest)],
                                            'name' => $tag_interest
                                        );
                                    }
                                    $targeting->{TargetingSpecsFields::INTERESTS} = $arr;

                                    $target = clone $targeting;
                                    $targeting_queue[] = $target;
                                }
                            }
                        }
                    }
                } else { //any language
                    $arr = array();
                    foreach ($tags_locale as $locale) {
                        $arr[] = $locales[trim($locale)];
                    }
                    $targeting->{TargetingSpecsFields::LOCALES} = $arr;

                    //AGE
                    if ($_POST['rdo_age'] == 'split') {
                        $tags_age = array();
                        for ($i_start_age = 0; $i_start_age < count($_POST['start_age']); $i_start_age++) {

                            $targeting->{TargetingSpecsFields::AGE_MIN} = $_POST['start_age'][$i_start_age];
                            $targeting->{TargetingSpecsFields::AGE_MAX} = $_POST['end_age'][$i_start_age];


                            //GENDER
                            if ($_POST['radio_sex'] == 'split') {

                                for ($i = 1; $i <= 2; $i++) {

                                    $targeting->{TargetingSpecsFields::GENDERS} = array($i);

                                    //INTEREST
                                    if ($_POST['rdo_interest'] == 'split') {
                                        foreach ($tags_interest as $tag_interest) {

                                            $targeting->{TargetingSpecsFields::INTERESTS} = array(
                                                array(
                                                    'id' => $interest[trim($tag_interest)],
                                                    'name' => $tag_interest,
                                                )
                                            );
                                            $target = clone $targeting;
                                            $targeting_queue[] = $target;

                                        }
                                    } else { //INTEREST ANY
                                        $arr = array();
                                        foreach ($tags_interest as $tag_interest) {
                                            $arr[] = array(
                                                'id' => $interest[trim($tag_interest)],
                                                'name' => $tag_interest
                                            );
                                        }
                                        $targeting->{TargetingSpecsFields::INTERESTS} = $arr;

                                        $target = clone $targeting;
                                        $targeting_queue[] = $target;
                                    }

                                }

                            } else { //GENDER ANY
                                if ($_POST['rdo_sex'] != '')
                                    $targeting->{TargetingSpecsFields::GENDERS} = array($_POST['rdo_sex']);
                                //INTEREST
                                if ($_POST['rdo_interest'] == 'split') {
                                    foreach ($tags_interest as $tag_interest) {

                                        $targeting->{TargetingSpecsFields::INTERESTS} = array(
                                            array(
                                                'id' => $interest[trim($tag_interest)],
                                                'name' => $tag_interest,
                                            )
                                        );
                                        $target = clone $targeting;
                                        $targeting_queue[] = $target;

                                    }
                                } else { //INTEREST ANY
                                    $arr = array();
                                    foreach ($tags_interest as $tag_interest) {
                                        $arr[] = array(
                                            'id' => $interest[trim($tag_interest)],
                                            'name' => $tag_interest
                                        );
                                    }
                                    $targeting->{TargetingSpecsFields::INTERESTS} = $arr;

                                    $target = clone $targeting;
                                    $targeting_queue[] = $target;
                                }
                            }

                        }

                    } else { //AGE ANY
                        $targeting->{TargetingSpecsFields::AGE_MIN} = $_POST['start_age'][0];
                        $targeting->{TargetingSpecsFields::AGE_MAX} = $_POST['end_age'][0];

                        //GENDER
                        if ($_POST['radio_sex'] == 'split') { //GENDER SPLIT

                            for ($i = 1; $i <= 2; $i++) {

                                $targeting->{TargetingSpecsFields::GENDERS} = array($i);

                                //INTEREST
                                if ($_POST['rdo_interest'] == 'split') {
                                    foreach ($tags_interest as $tag_interest) {

                                        $targeting->{TargetingSpecsFields::INTERESTS} = array(
                                            array(
                                                'id' => $interest[trim($tag_interest)],
                                                'name' => $tag_interest,
                                            )
                                        );
                                        $target = clone $targeting;
                                        $targeting_queue[] = $target;

                                    }
                                } else { //INTEREST ANY
                                    $arr = array();
                                    foreach ($tags_interest as $tag_interest) {
                                        $arr[] = array(
                                            'id' => $interest[trim($tag_interest)],
                                            'name' => $tag_interest
                                        );
                                    }
                                    $targeting->{TargetingSpecsFields::INTERESTS} = $arr;

                                    $target = clone $targeting;
                                    $targeting_queue[] = $target;
                                }

                            }

                        } else { //GENDER ANY
                            if ($_POST['rdo_sex'] != '')
                                $targeting->{TargetingSpecsFields::GENDERS} = array($_POST['rdo_sex']);
                            //INTEREST
                            if ($_POST['rdo_interest'] == 'split') {
                                foreach ($tags_interest as $tag_interest) {

                                    $targeting->{TargetingSpecsFields::INTERESTS} = array(
                                        array(
                                            'id' => $interest[trim($tag_interest)],
                                            'name' => $tag_interest,
                                        )
                                    );
                                    $target = clone $targeting;
                                    $targeting_queue[] = $target;

                                }
                            } else { //INTEREST ANY
                                $arr = array();
                                foreach ($tags_interest as $tag_interest) {
                                    $arr[] = array(
                                        'id' => $interest[trim($tag_interest)],
                                        'name' => $tag_interest
                                    );
                                }
                                $targeting->{TargetingSpecsFields::INTERESTS} = $arr;

                                $target = clone $targeting;
                                $targeting_queue[] = $target;
                            }
                        }
                    }
                }
            }
        } else { //COUNTRY ANY
            $country_data = array();
            foreach ($tags_country as $country) {
                $country_data[] = $countries[trim($country)];
            }
            $targeting->{TargetingSpecsFields::GEO_LOCATIONS} = array(
                'countries' => $country_data
            );

            //LANGUAGE
            if ($_POST['rdo_lang'] == 'split') {
                foreach ($tags_locale as $locale) {
                    $targeting->{TargetingSpecsFields::LOCALES} = array(
                        $locales[trim($locale)]
                    );

                    //AGE
                    if ($_POST['rdo_age'] == 'split') {
                        $tags_age = array();
                        for ($i_start_age = 0; $i_start_age < count($_POST['start_age']); $i_start_age++) {

                            $targeting->{TargetingSpecsFields::AGE_MIN} = $_POST['start_age'][$i_start_age];
                            $targeting->{TargetingSpecsFields::AGE_MAX} = $_POST['end_age'][$i_start_age];


                            //GENDER
                            if ($_POST['radio_sex'] == 'split') {

                                for ($i = 1; $i <= 2; $i++) {

                                    $targeting->{TargetingSpecsFields::GENDERS} = array($i);

                                    //INTEREST
                                    if ($_POST['rdo_interest'] == 'split') {
                                        foreach ($tags_interest as $tag_interest) {

                                            $targeting->{TargetingSpecsFields::INTERESTS} = array(
                                                array(
                                                    'id' => $interest[trim($tag_interest)],
                                                    'name' => $tag_interest,
                                                )
                                            );
                                            $target = clone $targeting;
                                            $targeting_queue[] = $target;

                                        }
                                    } else { //INTEREST ANY
                                        $arr = array();
                                        foreach ($tags_interest as $tag_interest) {
                                            $arr[] = array(
                                                'id' => $interest[trim($tag_interest)],
                                                'name' => $tag_interest
                                            );
                                        }
                                        $targeting->{TargetingSpecsFields::INTERESTS} = $arr;

                                        $target = clone $targeting;
                                        $targeting_queue[] = $target;
                                    }

                                }

                            } else { //GENDER ANY
                                if ($_POST['rdo_sex'] != '')
                                    $targeting->{TargetingSpecsFields::GENDERS} = array($_POST['rdo_sex']);
                                //INTEREST
                                if ($_POST['rdo_interest'] == 'split') {
                                    foreach ($tags_interest as $tag_interest) {

                                        $targeting->{TargetingSpecsFields::INTERESTS} = array(
                                            array(
                                                'id' => $interest[trim($tag_interest)],
                                                'name' => $tag_interest,
                                            )
                                        );
                                        $target = clone $targeting;
                                        $targeting_queue[] = $target;

                                    }
                                } else { //INTEREST ANY
                                    $arr = array();
                                    foreach ($tags_interest as $tag_interest) {
                                        $arr[] = array(
                                            'id' => $interest[trim($tag_interest)],
                                            'name' => $tag_interest
                                        );
                                    }
                                    $targeting->{TargetingSpecsFields::INTERESTS} = $arr;

                                    $target = clone $targeting;
                                    $targeting_queue[] = $target;
                                }
                            }

                        }

                    } else { //AGE ANY
                        $targeting->{TargetingSpecsFields::AGE_MIN} = $_POST['start_age'][0];
                        $targeting->{TargetingSpecsFields::AGE_MAX} = $_POST['end_age'][0];

                        //GENDER
                        if ($_POST['radio_sex'] == 'split') {

                            for ($i = 1; $i <= 2; $i++) {

                                $targeting->{TargetingSpecsFields::GENDERS} = array($i);

                                //INTEREST
                                if ($_POST['rdo_interest'] == 'split') {
                                    foreach ($tags_interest as $tag_interest) {

                                        $targeting->{TargetingSpecsFields::INTERESTS} = array(
                                            array(
                                                'id' => $interest[trim($tag_interest)],
                                                'name' => $tag_interest,
                                            )
                                        );
                                        $target = clone $targeting;
                                        $targeting_queue[] = $target;

                                    }
                                } else { //INTEREST ANY
                                    $arr = array();
                                    foreach ($tags_interest as $tag_interest) {
                                        $arr[] = array(
                                            'id' => $interest[trim($tag_interest)],
                                            'name' => $tag_interest
                                        );
                                    }
                                    $targeting->{TargetingSpecsFields::INTERESTS} = $arr;

                                    $target = clone $targeting;
                                    $targeting_queue[] = $target;
                                }

                            }

                        } else { //GENDER ANY
                            if ($_POST['rdo_sex'] != '')
                                $targeting->{TargetingSpecsFields::GENDERS} = array($_POST['rdo_sex']);
                            //INTEREST
                            if ($_POST['rdo_interest'] == 'split') {
                                foreach ($tags_interest as $tag_interest) {

                                    $targeting->{TargetingSpecsFields::INTERESTS} = array(
                                        array(
                                            'id' => $interest[trim($tag_interest)],
                                            'name' => $tag_interest,
                                        )
                                    );
                                    $target = clone $targeting;
                                    $targeting_queue[] = $target;

                                }
                            } else { //INTEREST ANY
                                $arr = array();
                                foreach ($tags_interest as $tag_interest) {
                                    $arr[] = array(
                                        'id' => $interest[trim($tag_interest)],
                                        'name' => $tag_interest
                                    );
                                }
                                $targeting->{TargetingSpecsFields::INTERESTS} = $arr;

                                $target = clone $targeting;
                                $targeting_queue[] = $target;
                            }
                        }
                    }
                }
            } else { //LANGUAGE ANY

                $arr = array();
                foreach ($tags_locale as $locale) {
                    $arr[] = $locales[trim($locale)];
                }
                $targeting->{TargetingSpecsFields::LOCALES} = $arr;

                //AGE
                if ($_POST['rdo_age'] == 'split') {

                    for ($i_start_age = 0; $i_start_age < count($_POST['start_age']); $i_start_age++) {

                        $targeting->{TargetingSpecsFields::AGE_MIN} = $_POST['start_age'][$i_start_age];
                        $targeting->{TargetingSpecsFields::AGE_MAX} = $_POST['end_age'][$i_start_age];


                        //GENDER
                        if ($_POST['radio_sex'] == 'split') {

                            for ($i = 1; $i <= 2; $i++) {

                                $targeting->{TargetingSpecsFields::GENDERS} = array($i);

                                //INTEREST
                                if ($_POST['rdo_interest'] == 'split') {
                                    foreach ($tags_interest as $tag_interest) {

                                        $targeting->{TargetingSpecsFields::INTERESTS} = array(
                                            array(
                                                'id' => $interest[trim($tag_interest)],
                                                'name' => $tag_interest,
                                            )
                                        );
                                        $target = clone $targeting;
                                        $targeting_queue[] = $target;

                                    }
                                } else { //INTEREST ANY
                                    $arr = array();
                                    foreach ($tags_interest as $tag_interest) {
                                        $arr[] = array(
                                            'id' => $interest[trim($tag_interest)],
                                            'name' => $tag_interest
                                        );
                                    }
                                    $targeting->{TargetingSpecsFields::INTERESTS} = $arr;

                                    $target = clone $targeting;
                                    $targeting_queue[] = $target;
                                }

                            }

                        } else { //GENDER ANY
                            if ($_POST['rdo_sex'] != '')
                                $targeting->{TargetingSpecsFields::GENDERS} = array($_POST['rdo_sex']);
                            //INTEREST
                            if ($_POST['rdo_interest'] == 'split') {
                                foreach ($tags_interest as $tag_interest) {

                                    $targeting->{TargetingSpecsFields::INTERESTS} = array(
                                        array(
                                            'id' => $interest[trim($tag_interest)],
                                            'name' => $tag_interest,
                                        )
                                    );
                                    $target = clone $targeting;
                                    $targeting_queue[] = $target;

                                }
                            } else { //INTEREST ANY
                                $arr = array();
                                foreach ($tags_interest as $tag_interest) {
                                    $arr[] = array(
                                        'id' => $interest[trim($tag_interest)],
                                        'name' => $tag_interest
                                    );
                                }
                                $targeting->{TargetingSpecsFields::INTERESTS} = $arr;

                                $target = clone $targeting;
                                $targeting_queue[] = $target;
                            }
                        }

                    }

                } else { //AGE ANY
                    $targeting->{TargetingSpecsFields::AGE_MIN} = $_POST['start_age'][0];
                    $targeting->{TargetingSpecsFields::AGE_MAX} = $_POST['end_age'][0];


                    //GENDER
                    if ($_POST['radio_sex'] == 'split') {

                        for ($i = 1; $i <= 2; $i++) {

                            $targeting->{TargetingSpecsFields::GENDERS} = array($i);

                            //INTEREST
                            if ($_POST['rdo_interest'] == 'split') {
                                foreach ($tags_interest as $tag_interest) {

                                    $targeting->{TargetingSpecsFields::INTERESTS} = array(
                                        array(
                                            'id' => $interest[trim($tag_interest)],
                                            'name' => $tag_interest,
                                        )
                                    );
                                    $target = clone $targeting;
                                    $targeting_queue[] = $target;

                                }
                            } else { //INTEREST ANY
                                $arr = array();
                                foreach ($tags_interest as $tag_interest) {
                                    $arr[] = array(
                                        'id' => $interest[trim($tag_interest)],
                                        'name' => $tag_interest
                                    );
                                }
                                $targeting->{TargetingSpecsFields::INTERESTS} = $arr;

                                $target = clone $targeting;
                                $targeting_queue[] = $target;
                            }

                        }

                    } else { //GENDER ANY
                        if ($_POST['rdo_sex'] != '')
                            $targeting->{TargetingSpecsFields::GENDERS} = array($_POST['rdo_sex']);

                        //INTEREST
                        if ($_POST['rdo_interest'] == 'split') {
                            foreach ($tags_interest as $tag_interest) {

                                $targeting->{TargetingSpecsFields::INTERESTS} = array(
                                    array(
                                        'id' => $interest[trim($tag_interest)],
                                        'name' => $tag_interest,
                                    )
                                );
                                $target = clone $targeting;
                                $targeting_queue[] = $target;

                            }
                        } else { //INTEREST ANY
                            $arr = array();
                            foreach ($tags_interest as $tag_interest) {
                                $arr[] = array(
                                    'id' => $interest[trim($tag_interest)],
                                    'name' => $tag_interest
                                );
                            }
                            $targeting->{TargetingSpecsFields::INTERESTS} = $arr;

                            $target = clone $targeting;
                            $targeting_queue[] = $target;
                        }
                    }
                }
            }
        }
//        echo "<pre>";print_r( $targeting_queue);die();

        //create adset
        $adset_data = array(
            AdSetFields::ACCOUNT_ID => $account_id,
            AdSetFields::NAME => $_POST['ads_name'],
            AdSetFields::CAMPAIGN_ID => $campaign_id,

            //for ios
            //promoted_object will be changed, depends on objective
            AdSetFields::PROMOTED_OBJECT => array(
                'application_id' => $app_id,
                'object_store_url' => $appURL,
            ),


            AdSetFields::DAILY_BUDGET => $_POST['ads_daily_budge'],
            AdSetFields::OPTIMIZATION_GOAL => $_POST['ads_optimization_goals'],
            AdSetFields::BILLING_EVENT => $_POST['ads_billing_event'],
            AdSetFields::BID_AMOUNT => $_POST['ads_bid_amount'],
            AdSetFields::CREATED_TIME => date('Y-m-d H:i:s'),
            AdSetFields::START_TIME => $_POST['start_time'],
            AdSetFields::END_TIME => $_POST['end_time'],
        );

        $insert_data = array();
        foreach ($targeting_queue as $key => $target) {

            $adset = new AdSet(null, $this->account_id);
            $adset_data[AdSetFields::TARGETING] = $target;
            $adset->setData($adset_data);
//            echo "<pre>";print_r( $adset);die;

            try {
                $adset->validate()->create(array(
                    AdSet::STATUS_PARAM_NAME => AdSet::STATUS_PAUSED,
                ));
            } catch (\FacebookAds\Http\Exception\RequestException $ex) {
                var_dump($ex->getErrorUserMessage());
            }
//            echo "<pre>";print_r( $target);
//            echo 'AdSet  ID: ' . $adset->id . PHP_EOL;

            $adset_id = $adset->id;
            if($adset_id != ''){
                foreach ($ads as $index => $a) {

                if ($a['platform'] == $platform) {

                    $a['adset_id'] = $adset_id;
                    $link_data = new LinkData();

                    $data = array(
                        LinkDataFields::MESSAGE => $a['message'],
                        LinkDataFields::CAPTION => $a['headline'],
                        LinkDataFields::IMAGE_HASH => $a['image_hash'],
                        LinkDataFields::LINK => $appURL,
                        LinkDataFields::CALL_TO_ACTION => array(
                            'type' => $a['action'],
                            'value' => array(
                                'link' => $appURL,
                                'link_caption' => $a['action'],
                            ),
                        )
                    );

                    $link_data->setData($data);

                    $object_story_spec = new ObjectStorySpec();
                    $object_story_spec->setData(array(
                        ObjectStorySpecFields::PAGE_ID => $a['page'],
                        ObjectStorySpecFields::LINK_DATA => $link_data,
                    ));

                    $creative = new AdCreative(null, $account_id);

                    $creative->setData(array(
                        AdCreativeFields::NAME => 'AdCreative - ' . $a['id'],
                        AdCreativeFields::OBJECT_STORY_SPEC => $object_story_spec,
                    ));

                    $creative->create();
                    $creative_id = $creative->id;
                    $a['creative_id'] = $creative_id;
//                    echo 'Creative  ID: ' . $creative_id . "<br>";

                    //create ad
                    if($creative_id != ''){
                        $ad_name = 'Ad - '. date('d-m-Y H:i:s'). ' - '.$index;
                        $data = array(
                            AdFields::NAME => $ad_name,
                            AdFields::ADSET_ID => $adset_id,
                            AdFields::STATUS => Ad::STATUS_PAUSED,
                            AdFields::CREATIVE => array(
                                'creative_id' => $creative_id,
                            ),
                        );

                        $ad = new Ad(null, $account_id);
                        $ad->setData($data);
    //                    echo "<pre>";print_r( $ad);die;
                        try {
                            $ad->create();
                        } catch (\FacebookAds\Http\Exception\RequestException $ex) {
                            var_dump($ex->getErrorUserMessage());
                        }

                        $ad_id = $ad->id;
//                        echo 'Ad  ID: ' . $ad_id . "<br>";die;
                        unset($a['id']);
                        $a['ad_id'] = $ad_id;
                        $a['name'] = $ad_name;
                        $a['created_time'] = date('Y-m-d H:i:s');
                        $insert_data[] = $a;

                    }
                }
            }
            }
        }
        $this->CI->FacebookAdsModel->insert_batch('f_real_ads',$insert_data);
//        echo "<pre>";print_r( $insert_data);die;
        header('Location:/?control=facebook_ads&func=createTargetingView&module=all#create_targeting');
    }


    public function manage_campaign(MeAPI_RequestInterface $request){
        $account = new AdAccount($this->account_id);

        $campaigns = $account->getCampaigns(array(
            CampaignFields::ACCOUNT_ID,
            CampaignFields::NAME,
            CampaignFields::OBJECTIVE,
            CampaignFields::START_TIME,
            CampaignFields::STOP_TIME
        ));
//        echo "<pre>";print_r( $campaigns); die;
       $listCampaign = array();
        foreach ($campaigns as $camp) {
            $listCampaign[] = $camp->getData();
        }
//        echo "<pre>";print_r( $listCampaign); die;
        $_SESSION['campaigns'] = $listCampaign;
        $this->data['campaigns'] = json_encode($listCampaign);
        $this->authorize->validateAuthorizeRequest($request, 0);
        $this->CI->template->write_view('content', 'FacebookAds/campaigns', $this->data);
        $this->_response = new MeAPI_Response_HTMLResponse($request, $this->CI->template->getHTML());
    }

    public function updateCampaign(MeAPI_RequestInterface $request){
        $id = $_POST['id'];

        $campaign = new Campaign($id);
        $campaign->setData(array(
            CampaignFields::NAME => $_POST['campaign'],
            CampaignFields::OBJECTIVE => $_POST['adObjectives']/*,
            CampaignFields::START_TIME => (new \DateTime($_POST['start_time']))->format(\DateTime::ISO8601) ,
            CampaignFields::STOP_TIME =>  (new \DateTime($_POST['stop_time']))->format(\DateTime::ISO8601)*/
        ));

//        echo "<pre>";var_dump( (new \DateTime($_POST['stop_time'])));die;
        $campaign->update();

        //update db at local
        $data = $campaign->getData();
        $data['updated_time'] = date('Y-m-d H:i:s');
        $this->CI->FacebookAdsModel->update('f_campaigns',$data,array('id' => $id));
        header('Location:/?control=facebook_ads&func=manage_campaign&module=all#campaign');
    }


    public function updateAdset(MeAPI_RequestInterface $request){
        $id = $_POST['id'];

        $adset = new AdSet($id, $this->account_id);
        $adset->read(array(
            AdSetFields::CAMPAIGN_ID,
            AdSetFields::PROMOTED_OBJECT
        ));



//        echo "<pre>";print_r( $adset);die;
        $data = array(
            AdSetFields::NAME => $_POST['ads_name'],
            AdSetFields::CAMPAIGN_ID => $_POST['campaign'],
            AdSetFields::DAILY_BUDGET => $_POST['ads_daily_budge'],
            AdSetFields::OPTIMIZATION_GOAL => $_POST['ads_optimization_goals'],
            AdSetFields::BILLING_EVENT => $_POST['ads_billing_event'],
            AdSetFields::BID_AMOUNT => $_POST['ads_bid_amount'],
            AdSetFields::UPDATED_TIME => (new \DateTime(date('Y-m-d H:i:s')))->format(\DateTime::ISO8601) ,
            AdSetFields::END_TIME => (new \DateTime($_POST['end_time']))->format(\DateTime::ISO8601),
        );
        $adset->setData($data);
        $adset->update();



        //get object_store_url from app, try to check have a change form user or not
        $account = (new AdAccount($this->account_id))->read(array(
            AdAccountFields::ID,
            AdAccountFields::NAME,
            AdAccountFields::BUSINESS,
            AdAccountFields::ACCOUNT_STATUS,
            AdAccountFields::BALANCE
        ));
        $connectionObjects = $account->getConnectionObjects();
        foreach ($connectionObjects as $object) {
            $data = $object->getData();
            if ($this->app_id == $data['id']) {
                $promoted_object = $data['object_store_urls'];
                break;
            }
        }

        $current_object_store_url = $adset->{AdSetFields::PROMOTED_OBJECT}['object_store_url'];
        if(strpos($current_object_store_url,'play.google.com') != false){
            $new_object_store_url = $promoted_object['google_play'];
        }elseif(strpos($current_object_store_url,'itunes.apple.com') != false){
            $new_object_store_url = $promoted_object['itunes'];
        }

        if(trim($new_object_store_url) != '' && trim($current_object_store_url) != trim($new_object_store_url)){
            //get all another adset have the same campaign
            $campaign_id = $adset->{AdSetFields::CAMPAIGN_ID};
            $campaign = new Campaign($campaign_id);
            $adsets = $campaign->getAdSets();

            foreach ($adsets as $ads) {
//                echo "<pre>";print_r( $ads);
                $ads->{AdSetFields::PROMOTED_OBJECT} = array(
                    'application_id' => $this->app_id,
                    'object_store_url' => $new_object_store_url,
                ) ;
                $ads->update();
            }

        }

        header('Location:/?control=facebook_ads&func=displayAdsetByCampaign&module=all&id='.$_POST['campaign'].'#campaign');
    }


    public function updateTargeting(MeAPI_RequestInterface $request){
        $id = $_POST['id'];
        $campaign_id = $_POST['campaign_id'];
        $campaigns = $this->CI->FacebookAdsModel->getList('*', 'f_campaigns', array('id' => $campaign_id));
        $appURL = $campaigns[0]['appURL'];
        $platform = $campaigns[0]['platform'];
        if($platform == 'google_play')
            $user_os = array('Android');
        elseif($platform == 'itunes')
            $user_os = array('iOS');
        else  $user_os = array('Android');
        $adset = new AdSet($id, $this->account_id);


        $tags_country = explode(',', $_POST['tags_country']);
        if (trim(end($tags_country)) == '') {
            array_pop($tags_country);
        }

        $tags_locale = explode(',', $_POST['tags_locale']);
        if (trim(end($tags_locale)) == '') {
            array_pop($tags_locale);
        }

        $tags_interest = explode(',', $_POST['tags_interest']);
        if (trim(end($tags_interest)) == '') {
            array_pop($tags_interest);
        }


        //create new targeting
        $targeting = new TargetingSpecs();
        $targeting->{TargetingSpecsFields::PAGE_TYPES} = $_POST['placement'];


        //user os
        $targeting->{TargetingSpecsFields::USER_OS} = $user_os;

        //country
        $countries = $_SESSION['countries'];
        $country_data = array();
        foreach ($tags_country as $country) {
            $country_data[] = $countries[trim($country)];
        }
        $targeting->{TargetingSpecsFields::GEO_LOCATIONS} = array(
            'countries' => $country_data
        );

        //locale
        $locales = $_SESSION['locale'];
        $arr = array();
        foreach ($tags_locale as $locale) {
            $arr[] = $locales[trim($locale)];
        }
        $targeting->{TargetingSpecsFields::LOCALES} = $arr;

        //age
        $targeting->{TargetingSpecsFields::AGE_MIN} = $_POST['age_min'];
        $targeting->{TargetingSpecsFields::AGE_MAX} = $_POST['age_max'];


        //sex
        if ($_POST['rdo_sex'] != '')
            $targeting->{TargetingSpecsFields::GENDERS} = array($_POST['rdo_sex']);

        $interest = $_SESSION['interest'];
        $arr = array();
        foreach ($tags_interest as $tag_interest) {
            $arr[] = array(
                'id' => $interest[trim($tag_interest)],
                'name' => $tag_interest
            );
        }
        $targeting->{TargetingSpecsFields::INTERESTS} = $arr;


        $adset->{AdSetFields::TARGETING} = $targeting;
//        echo "<pre>";print_r( $adset);die;
        $adset->update();
        header('Location:/?control=facebook_ads&func=displayAdsetByCampaign&module=all&id='.$campaign_id.'#campaign');
    }


    public function displayEditCampaignForm(MeAPI_RequestInterface $request){
        $id = $_GET['id'];
        $this->data['id'] = $id;
        $campaigns  = $_SESSION['campaigns'];
        $campaign = null;
        foreach($campaigns as $camp){
            if($camp['id'] == $id){
                $campaign = $camp;
                break;
            }

        }
//        echo "<pre>";print_r( $campaign);die;
        $this->data['campaign'] = $campaign;
        $this->authorize->validateAuthorizeRequest($request, 0);
        $this->CI->template->write_view('content', 'FacebookAds/editCampaign', $this->data);
        $this->_response = new MeAPI_Response_HTMLResponse($request, $this->CI->template->getHTML());
    }



    public function displayEditAdsetForm(MeAPI_RequestInterface $request){
        $id = $_GET['id'];
        $this->data['id'] = $id;


        $ads = $_SESSION['listAds'];
        $ad = null;
        foreach($ads as $a){
            if($a['id'] == $id){
                $ad = $a;
                break;
            }

        }
        $this->data['ad'] = $ad;

        $campaigns  = $_SESSION['campaigns'];
//        echo "<pre>";print_r( $ad );die;
        $this->data['campaigns'] = $campaigns;

        $optimizationGoals = new OptimizationGoals();
        $goals = $optimizationGoals->getValues();
        $this->data['goals'] = $goals;

        //get BillingEvents
        $billingEvents = new BillingEvents();
        $billings = $billingEvents->getValues();
        $this->data['billings'] = $billings;


        $this->authorize->validateAuthorizeRequest($request, 0);
        $this->CI->template->write_view('content', 'FacebookAds/editAdset', $this->data);
        $this->_response = new MeAPI_Response_HTMLResponse($request, $this->CI->template->getHTML());
    }


    public function displayEditTargetingForm(MeAPI_RequestInterface $request){
        $id = $_GET['id'];
        $campaign_id = $_GET['campaign_id'];
        $this->data['id'] = $id;
        $this->data['campaign_id'] = $campaign_id;
        $listAds = $_SESSION['listAds'] ;

        $targeting = array();
        foreach($listAds as $ad){
            if($ad['id'] == $id){
                $targeting = $ad['targeting'];
                break;
            }

        }
        $this->data['targeting'] = $targeting;

        //get countries
        $countries = array();
        $country_name = array();

        if (isset($_SESSION['countries'])) {
            $countries = $_SESSION['countries'];
            $country_name = $_SESSION['country_name'];
        } else {
            $result = TargetingSearch::search(
                TargetingSearchTypes::GEOLOCATION,
                null,
                null,
                array(
                    'location_types' => array('country'),
                    'limit' => 1000
                )
            );


            foreach ($result as $key => $value) {
                $countries[$value->name] = $value->country_code;
                $country_name[] = $value->name;
//            echo "<br>" . $value->name . " - " . $value->country_code . "<br>";
            }
            $_SESSION['countries'] = $countries;
            $_SESSION['country_name'] = $country_name;
        }
//        echo "<pre>";print_r($targeting);die;
        $this->data['country_name'] = json_encode($country_name);

        $country_array = $targeting['geo_locations']['countries'];
        $country_string = '';
        foreach($country_array as $key => $country){
            foreach($countries as $k => $v){
                if($country == $v){
                    $country_string .= $k.', ';
                    break;
                }
            }

        }

        $this->data['country_string'] = $country_string;


        //get locale
        $locale = array();
        $locale_name = array();
        if (isset($_SESSION['locale'])) {
            $locale = $_SESSION['locale'];
            $locale_name = $_SESSION['locale_name'];
        } else {
            $result = TargetingSearch::search(
                TargetingSearchTypes::LOCALE,
                null,
                null);
            foreach ($result as $key => $value) {
                $locale[$value->name] = $value->key;
                $locale_name[] = $value->name;
            }
            $_SESSION['locale'] = $locale;
            $_SESSION['locale_name'] = $locale_name;
        }
        $this->data['locale_name'] = json_encode($locale_name);



        $locale_array = $targeting['locales'];
        $locale_string = '';
        foreach($locale_array as $loc){
            foreach($locale as $k => $v){
                if($loc == $v){
                    $locale_string .= $k.', ';
                    break;
                }
            }

        }

        $this->data['locale_string'] = $locale_string;


        //get interest
        $interest = array();
        $interest_name = array();
        if (isset($_SESSION['interest'])) {
            $interest = $_SESSION['interest'];
            $interest_name = $_SESSION['interest_name'];
        } else {
            $result = TargetingSearch::search(
                TargetingSearchTypes::TARGETING_CATEGORY,
                'interests');

//        echo "<pre>";print_r( $result);die;
            foreach ($result as $key => $value) {
                $interest[$value->name] = $value->id;
                $interest_name[] = $value->name;
            }
            $_SESSION['interest'] = $interest;
            $_SESSION['interest_name'] = $interest_name;
        }

        $this->data['interest_name'] = json_encode($interest_name);
        $interest_array = $targeting['interests'];

        $interest_string = '';
        foreach($interest_array as $sub_arr){
            $name = $sub_arr['name'];
            $id = $sub_arr['id'];
            if($interest[$name] == $id)
                $interest_string .= $name.', ';
        }
//        echo "<pre>";print_r($interest_string);die;
        $this->data['interest_string'] = $interest_string;

        //page_types
        $page_types = $targeting['page_types'];
        $this->data['page_types'] = $page_types;

//        echo "<pre>";print_r( $targeting );die;
        $this->authorize->validateAuthorizeRequest($request, 0);
        $this->CI->template->write_view('content', 'FacebookAds/editTargeting', $this->data);
        $this->_response = new MeAPI_Response_HTMLResponse($request, $this->CI->template->getHTML());
    }


    public function displayAdsetByCampaign(MeAPI_RequestInterface $request){
        $listAds = array();
        $campaign_id = $_GET['id'];
        $this->data['campaign_id'] = $campaign_id;
        $campaign = new Campaign($campaign_id);
        $adsets = $campaign->getAdSets(array(
            AdSetFields::CAMPAIGN_ID,
            AdSetFields::NAME ,
            AdSetFields::PROMOTED_OBJECT ,
            AdSetFields::DAILY_BUDGET,
            AdSetFields::OPTIMIZATION_GOAL,
            AdSetFields::BILLING_EVENT,
            AdSetFields::BID_AMOUNT,
            AdSetFields::CREATED_TIME,
            AdSetFields::START_TIME,
            AdSetFields::END_TIME,
            AdSetFields::TARGETING
        ));

        foreach ($adsets as $adset) {
            $listAds[] = $adset->getData();
        }
//        echo "<pre>";print_r( $listAds);die;
        $this->data['listAds'] = json_encode($listAds) ;
        $_SESSION['listAds'] = $listAds;

        $this->authorize->validateAuthorizeRequest($request, 0);
        $this->CI->template->write_view('content', 'FacebookAds/ads', $this->data);
        $this->_response = new MeAPI_Response_HTMLResponse($request, $this->CI->template->getHTML());
    }


    public function displayAds(MeAPI_RequestInterface $request){
        $listAd = array();
        $id = $_GET['id'];
        $adset = new AdSet($id);
        $ads = $adset->getAds(array(
            AdFields::ID,
            AdFields::NAME
        ));

        // Outputs names of Ads .
        foreach ($ads as $ad) {
            $listAd[] = array('id' => $ad->id,'name' => $ad->name);
        }
//        echo "<pre>";print_r( json_encode($listAd));die;
        $this->data['listAd'] = json_encode($listAd) ;
        $this->authorize->validateAuthorizeRequest($request, 0);
        $this->CI->template->write_view('content', 'FacebookAds/listAd', $this->data);
        $this->_response = new MeAPI_Response_HTMLResponse($request, $this->CI->template->getHTML());
    }


    public function deleteCampaign(MeAPI_RequestInterface $request){
        $id = $_GET['id'];
        $campaign = new Campaign($id);
        $campaign->delete();
        $this->_response = new MeAPI_Response_HTMLResponse($request, $this->CI->template->getHTML());
    }


    public function deleteAdset(MeAPI_RequestInterface $request){
        $id = $_GET['id'];
        $adset = new AdSet($id);
        $adset->delete();
        $this->_response = new MeAPI_Response_HTMLResponse($request, $this->CI->template->getHTML());
    }


    public function deleteAd(MeAPI_RequestInterface $request){
        $id = $_GET['id'];
        $ad = new Ad($id);
        $ad->delete();
        $this->_response = new MeAPI_Response_HTMLResponse($request, $this->CI->template->getHTML());
    }
}
