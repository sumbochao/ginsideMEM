<link rel="stylesheet" href="<?php echo base_url('assets/datetime/css/style.css'); ?>"/>
<link rel="stylesheet" href="<?php echo base_url('assets/datetime/css/bootstrap.css'); ?>"/>
<div id="content-t" style="min-height: 500px; padding-top: 10px">
    <style>
        #loading {
            width: 100%;
            height: 100%;
            top: 0px;
            left: 0px;
            position: fixed;
            display: block;
            z-index: 99;
        }

        #loading-image {
            position: absolute;
            top: 40%;
            left: 45%;
            z-index: 100;
        }

        label {
            width: auto !important;
            color: #f36926;
        }
    </style>
    <script type="text/javascript">


        $(document).ready(function () {

            $('#comeback').on('click', function () {
                window.history.go(-1);
                return false;
            });

            //Set DateTime Format
//            $("#start_time").jqxDateTimeInput({width: '150px', height: '28px', formatString: 'yyyy-MM-dd HH:mm:ss' });
            $("#end_time").jqxDateTimeInput({width: '150px', height: '28px', formatString: 'yyyy-MM-dd HH:mm:ss' });

//            var start_time = '<?php //echo (new DateTime($ad['start_time']))->format('Y-m-d H:i:s'); ?>//';
//            $('#start_time').jqxDateTimeInput('setDate', start_time);
            var end_time = '<?php echo (new DateTime($ad['end_time']))->format('Y-m-d H:i:s'); ?>';
            $('#end_time').jqxDateTimeInput('setDate', end_time);

        });
    </script>
    <!-- Content -->
    <div id="content">
        <!-- Content wrapper -->
        <div class="wrapper">
            <?php include 'tab.php'; ?>
            <div class="widget-name">
                <div class="clearboth"></div>
            </div>

            <!--END CONTROL ADD CHEST-->
            <div class="widget" id="viewport">
                <div class="panel panel-default">
                    <div class="panel-body">
                        <form id="frmSendChest" action="/?control=facebook_ads&func=updateAdset&module=all#campaign" method="POST"
                              enctype="multipart/form-data">
                            <div class="well form-horizontal">
                                <div class="form-group">
                                    <label class="col-sm-2 control-label">Select Campaign</label>

                                    <div class="col-sm-10">
                                        <select name="campaign" id="campaign" class="form-control">
                                            <?php foreach($campaigns as $camp):?>
                                                <option <?php if($camp['id'] == $ad['campaign_id']) echo 'selected';?> platform="<?php echo $camp['platform'];?>" objective="<?php echo $camp['objective'];?>" value="<?php echo $camp['id'];?>"><?php echo $camp['name'];?></option>
                                            <?php endforeach?>
                                        </select>
                                    </div>

                                </div>
                                <div class="form-group">
                                    <label class="col-sm-2 control-label">Name</label>

                                    <div class="col-sm-10">
                                        <input type="text" class="form-control" name="ads_name" value="<?php echo $ad['name'];?>" />
                                    </div>

                                </div>

                                <div class="form-group">
                                    <label class="col-sm-2 control-label">Daily Budge</label>
                                    <div class="col-sm-4">
                                        <input type="text" class="form-control" name="ads_daily_budge" value="<?php echo $ad['daily_budget'];?>" />
                                    </div>
                                    <div class="col-sm-6"><span style="color: red; font-size: 9px; font-weight: bold;"> * Chỉ được phép thay đổi tối đa 4 lần trong 1 tiếng</span></div>
                                </div>

                                <div class="form-group">
                                    <label class="col-sm-2 control-label">Bid Amount</label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control" name="ads_bid_amount" value="<?php echo $ad['bid_amount'];?>" />
                                    </div>
                                </div>


                                <div class="form-group">
                                    <label class="col-sm-2 control-label">Optimization Goals</label>
                                    <div class="col-sm-10">
                                        <select name="ads_optimization_goals" class="form-control">
                                            <?php foreach($goals as $goal):?>
                                                <option <?php if($goal == $ad['optimization_goal']) echo 'seleted';?> value="<?php echo $goal;?>"><?php echo $goal;?></option>
                                            <?php endforeach?>
                                        </select>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-sm-2 control-label">Billing Event</label>
                                    <div class="col-sm-10">
                                        <select name="ads_billing_event" class="form-control">
                                            <?php foreach($billings as $b):?>
                                                <option <?php if($b == $ad['billing_event']) echo 'selected';?> value="<?php echo $b;?>"><?php echo $b;?></option>
                                            <?php endforeach?>
                                        </select>
                                    </div>
                                </div>


<!--                                <div class="form-group">-->
<!--                                    <label class="col-sm-2 control-label">Start Time</label>-->
<!--                                    <div class="col-sm-10">-->
<!--                                        <div id="start_time" name="start_time"></div>-->
<!--                                    </div>-->
<!--                                </div>-->
                                <div class="form-group">
                                    <label class="col-sm-2 control-label">End Time</label>
                                    <div class="col-sm-10">
                                        <div id="end_time" name="end_time"></div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <div class="col-sm-8 pull-right">
                                        <button id="comeback" class="btn btn-primary" type="button">Back</button>
                                        <button id="onSubmit" class="btn btn-primary" type="submit">Submit</button>
                                        <input type="hidden" name="id" value="<?php echo $id;?>">
                                    </div>
                                </div>


                            </div>
                        </form>
                    </div>
                </div>
            </div>

        </div>
        <!-- /content wrapper -->
    </div>
    <!-- /content -->
</div>
