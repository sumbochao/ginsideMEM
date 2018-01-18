<html xmlns="http://www.w3.org/1999/xhtml">
    <head>        
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    </head>
    <body>
        <?php
        session_start();
        /*
         * To change this license header, choose License Headers in Project Properties.
         * To change this template file, choose Tools | Templates
         * and open the template in the editor.
         */
// Configurations
        require_once 'autoload.php';


        define("SDK_DIR", __DIR__);

        $access_token = "CAAHlIzZAAHKgBANhL1F06f4jhK0doYXoZBW1wTS72INPPtPXJuc3S6ZCJOndxt2OJ0Krh2IsPkxgg4SFzZBXxxIuA1wFKT4Jvo1CQXWA9qIdVXN7cSE92P5PPZAxSXkpEfjf3oQaQ4rgZBAHvsDJTtYJZAYBBVEFb3DMqZAT0eEgkETA3M4BOYIejXuZAvWMTCzAZD";
        $app_id = "533414373498024";
        $app_secret = "e48719db47bce8cae1005809cd0ab192";
        $account_id = "act_763957013734840";
        $account_id = "act_1563437377305791";
        if (is_null($access_token) || is_null($app_id) || is_null($app_secret)) {
            throw new \Exception(
            'You must set your access token, app id and app secret before executing'
            );
        }
        if (is_null($account_id)) {
            throw new \Exception(
            'You must set your account id before executing');
        }

        use FacebookAds\Api;

$api = Api::init($app_id, $app_secret, $access_token);

        /**
         * Step 1 Read the AdAccount (optional)
         */
        use FacebookAds\Object\AdAccount;
        use FacebookAds\Object\Fields\AdAccountFields;

//get info account marketing
        $account = (new AdAccount($account_id))->read(array(
            AdAccountFields::ID,
            AdAccountFields::NAME,
            AdAccountFields::BUSINESS,
            AdAccountFields::ACCOUNT_STATUS,
            AdAccountFields::BALANCE
        ));

        echo "<br>" . $account->id . " - " . $account->name . " - " . $account->account_status . " - " . $account->balance . "<br>";
        //var_dump($account);
        echo "<br>";

//echo "\nUsing this account: ";
//echo $account->id."\n";

        use FacebookAds\Object\Fields\AdSetFields;

$adsets = $account->getAdSets(array(
            AdSetFields::ID,
            AdSetFields::NAME
        ));

        echo "<br>adset<br>";
        foreach ($adsets as $adset) {
            echo $adset->{AdSetFields::ID} . " - " . $adset->{AdSetFields::NAME} . PHP_EOL;
            echo "<br>";
        }

//die;
        use FacebookAds\Object\Fields\ConnectionObjectFields;

        /* $objects = $account->getConnectionObjects();

          foreach ($objects as $object) {
          //var_dump($object);
          } */
        //die;
        //$lables = $account->getAdLabels();
        //var_dump($lables);
        // Check the account is active
        /* if($account->{AdAccountFields::ACCOUNT_STATUS} !== 1) {
          throw new \Exception(
          'This account is not active');
          } */
        use FacebookAds\Object\AdLabel;
        use FacebookAds\Object\Fields\AdLabelFields;

$label = new AdLabel(null, $account->id);
        $label->{AdLabelFields::NAME} = 'AdLabel My Name';

        //$label->create();

        use FacebookAds\Object\Campaign;
        use FacebookAds\Object\Fields\CampaignFields;
        use FacebookAds\Object\Values\AdObjectives;

//create campaign
        $campaign = new Campaign(null, $account_id);
        $campaign->setData(array(
            CampaignFields::NAME => 'Install My Campaign',
            CampaignFields::OBJECTIVE => AdObjectives::MOBILE_APP_INSTALLS,
            //CampaignFields::BUYING_TYPE => "RESERVED",
            CampaignFields::START_TIME => (new \DateTime("+1 week"))->format(\DateTime::ISO8601),
            CampaignFields::STOP_TIME => (new \DateTime("+2 week"))->format(\DateTime::ISO8601)
        ));

//        $res = $campaign->create(array(
//            Campaign::STATUS_PARAM_NAME => Campaign::STATUS_PAUSED,
//        ));
//        var_dump($res);
//
//        die;

        use FacebookAds\Object\AdUser;
        use FacebookAds\Object\Fields\AdUserFields;

//get account marketing info
        /* $user = new AdUser('me');
          $user->read(array(AdUserFields::ID));

          $accounts = $user->getAdAccounts(array(
          AdAccountFields::ID,
          AdAccountFields::NAME,
          AdAccountFields::AGE
          ));

          // Print out the accounts
          echo "Accounts:<br>";
          foreach ($accounts as $account) {
          echo $account->id . ' - ' . $account->name . " - " . $account->{AdAccountFields::AGE} . "<br>";
          }

          // Grab the first account for next steps (you should probably choose one)
          $account = (count($accounts)) ? $accounts->getObjects()[0] : null;
          echo "\nUsing this account: ";
          echo $account->id . "\n";
         */
        //get info campaign
        //die;
        $campaign = new Campaign('6041449417901');
        $campaign->read(array(
            CampaignFields::ID,
            CampaignFields::NAME,
            CampaignFields::OBJECTIVE,
            CampaignFields::START_TIME,
            CampaignFields::STOP_TIME
        ));
        //$res = $campaign->read();
        echo "<br>" . $campaign->id . " - " . $campaign->name . " - " . $campaign->{CampaignFields::OBJECTIVE} . " - " . $campaign->{CampaignFields::START_TIME} . " - " . $campaign->{CampaignFields::STOP_TIME} . "<br>";
        //die;
        //lay danh sach campaign
        /* $account = (new AdAccount($account_id));
          $comapigns = $account->getCampaigns(array(
          CampaignFields::ID,
          CampaignFields::NAME
          ));
          echo "<br>";
          foreach ($comapigns as $key => $value) {
          echo $value->id . " - " . $value->name . "</br>";
          } */

        //get list page
//        $graphObject = $api->call("/me/accounts");        
        //var_dump(json_decode($graphObject->getBody(), true));
        //die;

        /**
         * Step 3 Search Targeting
         */
        use FacebookAds\Object\TargetingSearch;
        use FacebookAds\Object\Search\TargetingSearchTypes;
        use FacebookAds\Object\TargetingSpecs;
        use FacebookAds\Object\Fields\TargetingSpecsFields;
        use FacebookAds\Object\Values\PageTypes;

//tim kiem danh sach quoc gia
        $result = TargetingSearch::search(
                        TargetingSearchTypes::GEOLOCATION, null,
                        /* 'un', array(
                          'location_types' => array('country'), */ null, array(
                    'location_types' => array('country'),
                    'limit' => 3
        ));
        foreach ($result as $key => $value) {
            echo "<br>" . $value->name . " - " . $value->country_code . "<br>";
        }

        //die;
        $results = TargetingSearch::search(
                        $type = TargetingSearchTypes::INTEREST, $class = null, $query = 'facebook');
// we'll take the top result for now
        $target = (count($results)) ? $results->current() : null;
        echo "Using target: " . $target->name . "\n";

        use FacebookAds\Object\AdImage;
        use FacebookAds\Object\Fields\AdImageFields;
        use FacebookAds\Object\ObjectStory\LinkData;
        use FacebookAds\Object\Fields\ObjectStory\LinkDataFields;
        use FacebookAds\Object\ObjectStorySpec;
        use FacebookAds\Object\Fields\ObjectStorySpecFields;
        use FacebookAds\Object\Values\CallToActionTypes;
        use FacebookAds\Object\AdCreative;
        use FacebookAds\Object\Fields\AdCreativeFields;
        use FacebookAds\Object\Ad;
        use FacebookAds\Object\Fields\AdFields;
        use FacebookAds\Object\AdSet;
        use FacebookAds\Object\Values\OptimizationGoals;
        use FacebookAds\Object\Values\BillingEvents;

$age_lists = array(
            array("min" => 18, "max" => 25)            
        );
        foreach ($age_lists as $key => $agevalue) {



            $targeting = new TargetingSpecs();
            $targeting->{TargetingSpecsFields::GEO_LOCATIONS} = array('countries' => array('VN'));
            /* $targeting->{TargetingSpecsFields::INTERESTS} = array(
              array(
              'id' => $target->id,
              'name' => $target->name,
              ),
              ); */
            $targeting->{TargetingSpecsFields::PAGE_TYPES} = array(
                //PageTypes::DESKTOP_FEED,
                //PageTypes::RIGHT_COLUMN,
                PageTypes::MOBILE_FEED,
                PageTypes::MOBILE_EXTERNAL
            );
            $targeting->{TargetingSpecsFields::AGE_MIN} = $agevalue["min"];
            $targeting->{TargetingSpecsFields::AGE_MAX} = $agevalue["max"];

            /* Accepts one or multiple values. The values must be in the OS option table below. Please note that it is invalid to target the minimal version of one platform with the other platform together. However it is fine to target both platforms without specifying minimal versions of either.
              Valid Examples
              - ['iOS', 'Android']
              - ['iOS']
              - ['Android_ver_4.2_and_above']
              - ['iOS_ver_8.0_to_9.0']
              Invalid Examples
              - ['Android', 'iOS_ver_8.0_and_above']
              - ['iOS', 'Android_ver_4.0_and_above']
             */
            $targeting->{TargetingSpecsFields::USER_OS} = array('iOS_ver_8.0_to_9.0');

            //var_dump($targeting->getData());
            //die;
//die;
            /**
             * Step 4 Create the AdSet
             */
            echo $account->id;
            echo "<br>";

            $adset = new AdSet(null, $account->id);

            $adset->setData(array(
                AdSetFields::ACCOUNT_ID => $account->id,
                AdSetFields::NAME => 'My First AdSet',
                AdSetFields::CAMPAIGN_ID => $campaign->id,
                AdSetFields::PROMOTED_OBJECT => array(
                    'application_id' => '381650398662512',
                    'object_store_url' => 'https://itunes.apple.com/app/id964783889',
                ),
                AdSetFields::DAILY_BUDGET => 100,
                AdSetFields::TARGETING => $targeting,
                AdSetFields::OPTIMIZATION_GOAL => OptimizationGoals::APP_INSTALLS,
                AdSetFields::BILLING_EVENT => BillingEvents::IMPRESSIONS,
                AdSetFields::BID_AMOUNT => 1,
                AdSetFields::CREATED_TIME => (new \DateTime("now"))->format(\DateTime::ISO8601),
                AdSetFields::START_TIME =>
                (new \DateTime("+1 week"))->format(\DateTime::ISO8601),
                AdSetFields::END_TIME =>
                (new \DateTime("+2 week"))->format(\DateTime::ISO8601),
            ));
            //var_dump($adset);die;
            try {
                $adset->validate()->create(array(
                    AdSet::STATUS_PARAM_NAME => AdSet::STATUS_PAUSED,
                ));
            } catch (\FacebookAds\Http\Exception\RequestException $ex) {
                var_dump($ex->getErrorUserMessage());
            }
//        echo 'AdSet  ID: ' . $adset->id . "\n";
//        die;
            //$adset = new AdSet("6041456608501");
//        $adset->read(array(
//            AdSetFields::ACCOUNT_ID,
//            AdSetFields::ADSET_SCHEDULE,
//            AdSetFields::BID_AMOUNT,
//            AdSetFields::BILLING_EVENT,
//            AdSetFields::BUDGET_REMAINING,
//            AdSetFields::CAMPAIGN_ID,
//            AdSetFields::CREATED_TIME,
//            AdSetFields::CREATIVE_SEQUENCE,
//            AdSetFields::DAILY_BUDGET,
//            AdSetFields::END_TIME,
//            AdSetFields::ID,
//            AdSetFields::IS_AUTOBID,
//            AdSetFields::LIFETIME_BUDGET,
//            AdSetFields::LIFETIME_IMPS,
//            AdSetFields::NAME,
//            AdSetFields::OPTIMIZATION_GOAL,
//            AdSetFields::PACING_TYPE,
//            AdSetFields::RF_PREDICTION_ID,
//            AdSetFields::START_TIME,
//            AdSetFields::UPDATED_TIME,
//            AdSetFields::TARGETING,
//            AdSetFields::PROMOTED_OBJECT,
//            AdSetFields::ADLABELS,
//            AdSetFields::PRODUCT_AD_BEHAVIOR
//        ));
//
//        var_dump($adset);
            //die;
            /* $adset->setData(array(
              AdSetFields::DAILY_BUDGET => 4000,
              AdSetFields::BILLING_EVENT => BillingEvents::APP_INSTALLS,
              )); */

//        try {
//            $adset->update();
//        } catch (\FacebookAds\Http\Exception\RequestException $ex) {
//            var_dump($ex->getErrorUserMessage());
//        }
//die;
            /**
             * Step 5 Create an AdImage
             */
            $image_lists = array(
                "/misc/image.jpg"
            );
            $message_lists = array(
                "Những BỘ CÁNH siêu ĐẸP, dễ thương không khiến bạn thất vọng! Free 1 bộ cánh cho ANH EM"
            );
            $title_lists = array(
                "Tặng Cánh Hoàn Kim"
            );
            foreach ($image_lists as $key => $imgvalue) {
                foreach ($message_lists as $key => $msgvalue) {
                    foreach ($title_lists as $key => $titvalue) {


                        $image = new AdImage(null, $account->id);
                        $image->{AdImageFields::FILENAME} = SDK_DIR . $imgvalue;
                        $image->create();
                        echo '<br>Image Hash: ' . $image->hash . "\n";



                        $link_data = new LinkData();
                        $link_data->setData(array(
                            LinkDataFields::MESSAGE => $msgvalue,
                            LinkDataFields::LINK => 'https://itunes.apple.com/app/id964783889',
                            LinkDataFields::CAPTION => $titvalue,
                            LinkDataFields::NAME => $titvalue,                            
                            LinkDataFields::CALL_TO_ACTION => array(
                                'type' => CallToActionTypes::INSTALL_MOBILE_APP,
                                'value' => array(
                                    'link' => 'https://itunes.apple.com/app/id964783889',
                                    'link_caption' => 'Install Now!',
                                    'link_title' => $titvalue,
                                ),
                            ),
                            LinkDataFields::IMAGE_HASH => $image->hash                            
                        ));

                        $object_story_spec = new ObjectStorySpec();
                        $object_story_spec->setData(array(
                            ObjectStorySpecFields::PAGE_ID => '665726200221998',
                            ObjectStorySpecFields::LINK_DATA => $link_data,
                        ));

                        /**
                         * Step 6 Create an AdCreative
                         */
                        $creative = new AdCreative(null, $account->id);
                        $creative->setData(array(
                            AdCreativeFields::NAME => $titvalue,
                            AdCreativeFields::TITLE =>$titvalue,
                            //AdCreativeFields::OBJECT_URL => 'https://itunes.apple.com/app/id964783889',
                            AdCreativeFields::OBJECT_STORY_SPEC => $object_story_spec,
                        ));
                        try {
                            $creative->create();
                        } catch (\FacebookAds\Http\Exception\RequestException $ex) {
                            var_dump($ex->getErrorUserMessage());
                        }
//
//                        echo '<br>Creative ID: ' . $creative->id . "\n";
//                        die;
                        //6044793025568 


                        /* $creative = new AdCreative('6041468238901');
                          $creative->read(array(
                          AdCreativeFields::ID,
                          AdCreativeFields::NAME,
                          AdCreativeFields::TITLE,
                          AdCreativeFields::BODY,
                          AdCreativeFields::OBJECT_STORY_SPEC,
                          )
                          );
                          echo '<br>Creative ID: ' . $creative->id . " - " . $creative->name . " - " . $creative->title . "\n";

                          var_dump($creative->object_story_spec); */
                        //die;

                        /**
                         * Step 7 Create an Ad
                         */
//        echo "<br>AD - 6041454380301 - Test<br>";
//        $ad = new Ad('6041454380301');
//        $ad->read(array(
//            AdFields::ACCOUNT_ID,
//            AdFields::BID_AMOUNT,
//            AdFields::ADSET_ID,
//            AdFields::CAMPAIGN_ID,
//            AdFields::CONVERSION_SPECS,
//            AdFields::CREATED_TIME,
//            AdFields::AD_REVIEW_FEEDBACK,
//            AdFields::ID,
//            AdFields::NAME,
//            AdFields::TARGETING,
//            AdFields::TRACKING_SPECS,
//            AdFields::UPDATED_TIME,
//            AdFields::CREATIVE,
//            AdFields::SOCIAL_PREFS,
//            AdFields::FAILED_DELIVERY_CHECKS,
//            AdFields::ADLABELS,
//            AdFields::ENGAGEMENT_AUDIENCE
//        ));
//        var_dump($ad);
//        var_dump($ad->{AdFields::CONVERSION_SPECS});
//        var_dump($ad->{AdFields::TRACKING_SPECS});
//        var_dump($ad->{AdFields::TARGETING});
//
//        $ad = new Ad('6041457711901');
//        $ad->read(array(
//            AdFields::ACCOUNT_ID,
//            AdFields::BID_AMOUNT,
//            AdFields::ADSET_ID,
//            AdFields::CAMPAIGN_ID,
//            AdFields::CONVERSION_SPECS,
//            AdFields::CREATED_TIME,
//            AdFields::AD_REVIEW_FEEDBACK,
//            AdFields::ID,
//            AdFields::NAME,
//            AdFields::TARGETING,
//            AdFields::TRACKING_SPECS,
//            AdFields::UPDATED_TIME,
//            AdFields::CREATIVE,
//            AdFields::SOCIAL_PREFS,
//            AdFields::FAILED_DELIVERY_CHECKS,
//            AdFields::ADLABELS,
//            AdFields::ENGAGEMENT_AUDIENCE
//        ));
//        var_dump($ad);
//        var_dump($ad->{AdFields::CONVERSION_SPECS});
//        var_dump($ad->{AdFields::TRACKING_SPECS});
//        var_dump($ad->{AdFields::TARGETING});
                        //die;
                        $ad = new Ad(null, $account->id);
                        $ad->setData(array(
                            AdFields::NAME => $titvalue,
                            AdFields::ADSET_ID => $adset->id,
                            AdFields::STATUS => Ad::STATUS_PAUSED,
                            AdFields::CREATIVE => array(
                                'creative_id' => $creative->id,
                            ),
//            AdFields::TRACKING_SPECS => array(
//                array(
//                    'action.type' => 'post_engagement',
//                    'page' => '665726200221998',
//                    'page' => '849064455221504'
//                ),
//                array(
//                    'action.type' => 'app_custom_event',
//                    'application' => '665726200221998'
//                )
//            ),
                                //AdFields::TARGETING => $targeting->getData()
                        ));

                        try {
                            //$ad->create($fields);
                            //var_dump($ad);
                            $ad->create();
                        } catch (\FacebookAds\Http\Exception\RequestException $ex) {
                            var_dump($ex->getErrorUserMessage());
                        }


                        echo 'Ad ID:' . $ad->id . "\n";
                    }
                }
            }
        }
        ?>
    </body>
</html>
