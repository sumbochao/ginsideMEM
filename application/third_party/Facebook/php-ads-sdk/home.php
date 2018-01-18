<?php
session_start();
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
//
//get info account marketing
$account = (new AdAccount($account_id))->read(array(
    AdAccountFields::ID,
    AdAccountFields::NAME,
    AdAccountFields::BUSINESS,
    AdAccountFields::ACCOUNT_STATUS,
    AdAccountFields::BALANCE
));


//use FacebookAds\Object\Fields\ConnectionObjectFields;




?>
<!DOCTYPE html>
<html>
<head lang="en">
    <meta charset="UTF-8">
    <title>APP INSTALL ADS</title>
    <link href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.1/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
    <script>
        $(document).ready(function () {
            $('#app').change(function () {
                var appID = $(this).val();
                var platform = $('#platform').val();
                $.post('ajaxAppChangeEvent.php',{appID:appID,platform:platform}, function (response) {
                    var data = $.parseJSON(response);
                });
            });
        });
    </script>
</head>
<body>
<div class="container">
    <div class="panel panel-default">
        <div class="panel-body">
            <form class="form-horizontal" role="form">

                <div class="form-group">
                    <label class="col-sm-2 control-label">Select Platform</label>

                    <div class="col-sm-10">
                        <select multiple name="platform" id="platform" class = "form-control">
                            <option value="itunes">Itunes</option>
                            <option value="google_play">Goodle Play</option>
                        </select>
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-sm-2 control-label">App</label>

                    <div class="col-sm-10">
                        <select id="app" name="app" class = "form-control">
                            <option value="">--Select App--</option>
                            <!-- get list app -->
                            <?php $connectionObjects = $_SESSION['ConnectionObjects'] = $account->getConnectionObjects();?>
                            <?php foreach($connectionObjects as $object):?>
                            <?php $data = $object->getData();?>
                                <option value="<?php echo $data['id'];?>"><?php echo $data['name'];?></option>
                            <?php endforeach?>
                        </select>
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-sm-2 control-label">App URL</label>

                    <div class="col-sm-10">
                        <input type="text" class="form-control" name="appURL[]">
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-sm-2 control-label">Tracking via</label>

                    <div class="col-sm-10">
                        <input type="text" class="form-control" name="tracking_via[]">
                    </div>
                </div>


            </form>
        </div>
    </div>
</div>

</body>
</html>
