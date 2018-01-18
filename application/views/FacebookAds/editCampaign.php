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
            $("#start_time").jqxDateTimeInput({width: '150px', height: '28px', formatString: 'yyyy-MM-dd HH:mm:ss' });
            $("#stop_time").jqxDateTimeInput({width: '150px', height: '28px', formatString: 'yyyy-MM-dd HH:mm:ss' });

            var start_time = '<?php echo $campaign["start_time"]; ?>';
            $('#start_time').jqxDateTimeInput('setDate', start_time);
            var stop_time = '<?php echo $campaign["stop_time"];; ?>';
            $('#stop_time').jqxDateTimeInput('setDate', stop_time);

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
                        <form id="frmSendChest" action="/?control=facebook_ads&func=updateCampaign&module=all#campaign" method="POST"
                              enctype="multipart/form-data">
                            <div class="well form-horizontal">

                                <div class="form-group headline">
                                    <label class="col-sm-2 control-label">Campaign</label>

                                    <div class="col-sm-10">
                                        <input name="campaign" class="form-control" value="<?php echo $campaign['name'];?>"/>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-2 control-label">Ad Objectives</label>

                                    <div class="col-sm-10">
                                        <select name="adObjectives" class="form-control">
                                            <option <?php if($campaign['objective'] == 'MOBILE_APP_INSTALLS') echo 'selected';?> value="MOBILE_APP_INSTALLS">MOBILE APP INSTALLS</option>
                                            <option <?php if($campaign['objective'] == 'MOBILE_APP_ENGAGEMENT') echo 'selected';?> value="MOBILE_APP_ENGAGEMENT">MOBILE APP ENGAGEMENT</option>
                                        </select>
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
