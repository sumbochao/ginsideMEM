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

        /* Important part */
        .modal-dialog {
            overflow-y: initial !important
        }

        .modal-body {
            height: 300px;
            overflow-y: auto;
        }

        #ad-img {
            text-align: center;
        }

        #ad-img img {
            margin: 3px;
            width: 90px;
            height: 80px;
        }

        #ad-img img.active {
            border: 3px solid orange;
        }
    </style>
    <script type="text/javascript">
        var image = [];
        function choseImage(img) {
//            $(img).toggleClass('active');

            $(img).toggleClass(function () {
                if ($(img).hasClass('active')) {
                    //remove image out of image_string
                    image.splice($.inArray($(img).attr('name'), image), 1);
                } else {
                    //add image into image_string
                    image.push($(img).attr('name'));
                }
                $('#image_name').val(image.toString());
                return 'active';
            });


        }

        function removeHeadline(el) {
            if ($('.headline').length > 1) {
                $(el).closest('.form-group').remove();
            }
            return false;
        }


        function removeMessage(el) {
            if ($('.message').length > 1) {
                $(el).closest('.form-group').remove();
            }
            return false;
        }

        $(document).ready(function () {

            $('#app').change(function () {
                var appID = $(this).val();
                if (appID == '') {
                    $('.app-url').remove();
                    $('.tracking').remove();
                    return false;
                }

                var platform = $('#platform').val();
                if (platform == null) {
                    alert('Chưa chọn platform');
                    return false;
                }
                $('.app-url').remove();
                $('.tracking').remove();
                $.post('/?control=facebook_ads&func=appChangeEvent', {
                    appID: appID,
                    platform: platform
                }, function (response) {
                    $(response).insertAfter('.app');
                });
            });


            $('#add-headline').click(function () {
                $('.headline:last').clone().insertAfter('.headline:last');
            });


            $('#add-message').click(function () {
                $('.message:last').clone().insertAfter('.message:last');
            });

            //Set DateTime Format
//            $("#start_time").jqxDateTimeInput({ width: '150px', height: '28px', formatString: 'yyyy-MM-dd HH:mm:ss' });
//            $("#stop_time").jqxDateTimeInput({ width: '150px', height: '28px', formatString: 'yyyy-MM-dd HH:mm:ss' });


            $('#comeback').on('click', function () {
                window.history.go(-1);
                return false;
            });


            $('#onSubmit').click(function () {
                if ($('#frmSendChest').validationEngine('validate') === false)
                    return false;

                $(".loading").fadeIn("fast");
                $('#frmSendChest').ajaxForm(function (data) {
                    $(".modal-body #messgage").html(data);
                    $('.bs-example-modal-sm').modal('show');
                    $('#frmSendChest').clearForm();
                    $(".loading").fadeOut("fast");
                });
            });

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
                        <form id="frmSendChest" action="/?control=facebook_ads&func=createAds&module=all" method="POST"
                              enctype="multipart/form-data">
                            <div class="well form-horizontal">
                                <div class="form-group">
                                    <label class="col-sm-2 control-label">Select Platform</label>

                                    <div class="col-sm-10">
                                        <select multiple name="platform[]" id="platform" class="form-control">
                                            <option value="itunes">iOS</option>
                                            <option value="google_play">Android</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group app">
                                    <label class="col-sm-2 control-label">App</label>

                                    <div class="col-sm-10">
                                        <select id="app" name="app" class="form-control">
                                            <option value="">--Select App--</option>
                                            <?php foreach ($apps as $app): ?>
                                                <option value="<?php echo $app['id']; ?>"><?php echo $app['name']; ?></option>
                                            <?php endforeach ?>
                                        </select>
                                    </div>
                                </div>


                                <div class="form-group">
                                    <label class="col-sm-2 control-label">Call to action</label>

                                    <div class="col-sm-10">
                                        <select name="action" class="form-control">
                                            <?php foreach ($listAction as $action): ?>
                                                <option value="<?php echo $action; ?>"><?php echo $action; ?></option>
                                            <?php endforeach ?>
                                        </select>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-sm-2 control-label">Publishing page</label>

                                    <div class="col-sm-10">
                                        <select name="page" class="form-control">
                                            <?php foreach ($listPage as $page): ?>
                                                <option
                                                    value="<?php echo $page['id']; ?>"><?php echo $page['name']; ?></option>
                                            <?php endforeach ?>
                                        </select>
                                    </div>
                                </div>

                                <div class="panel panel-primary">
                                    <div class="panel-heading">
                                        <h3 class="panel-title">Create Campaign</h3>
                                    </div>

                                    <div class="panel-body">
                                        <div class="form-group headline">
                                            <label class="col-sm-2 control-label">Campaign</label>

                                            <div class="col-sm-10">
                                                <input name="campaign" class="form-control" value=""/>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-sm-2 control-label">Ad Objectives</label>

                                            <div class="col-sm-10">
                                                <select name="adObjectives" class="form-control">
                                                    <option value="MOBILE_APP_INSTALLS">MOBILE APP INSTALLS</option>
                                                    <option value="MOBILE_APP_ENGAGEMENT">MOBILE APP ENGAGEMENT</option>
                                                    <!--                                            --><?php //foreach($listAdObjectives as $obj):?>
                                                    <!--                                                <option value="-->
                                                    <?php //echo $obj;?><!--">--><?php //echo $obj;?><!--</option>-->
                                                    <!--                                            --><?php //endforeach?>
                                                </select>
                                            </div>
                                        </div>

                                        <!--                                <div class="form-group">-->
                                        <!--                                    <label class="col-sm-2 control-label">Start Time</label>-->
                                        <!--                                    <div class="col-sm-10">-->
                                        <!--                                        <div id="start_time" name="start_time"></div>-->
                                        <!--                                    </div>-->
                                        <!--                                </div>-->
                                        <!--                                <div class="form-group">-->
                                        <!--                                    <label class="col-sm-2 control-label">End Time</label>-->
                                        <!--                                    <div class="col-sm-10">-->
                                        <!--                                        <div id="stop_time" name="stop_time"></div>-->
                                        <!--                                    </div>-->
                                        <!--                                </div>-->
                                    </div>
                                </div>

                                <div class="panel panel-default">
                                    <div class="panel-heading">
                                        <button id="add-headline" type="button" class="btn btn-primary">Add headline
                                        </button>
                                    </div>

                                    <div class="panel-body">
                                        <div class="form-group headline">
                                            <div class="col-sm-10">
                                                <input name="headline[]" class="form-control" value=""/>
                                            </div>
                                            <div class="col-sm-2">
                                                <button type="button" onclick="removeHeadline(this);"
                                                        class="btn btn-primary">DELETE
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="panel panel-default">
                                    <div class="panel-heading">
                                        <button id="add-message" type="button" class="btn btn-primary">Add message
                                        </button>
                                    </div>

                                    <div class="panel-body">
                                        <div class="form-group message">
                                            <div class="col-sm-10">
                                                <input name="message[]" class="form-control" value=""/>
                                            </div>
                                            <div class="col-sm-2">
                                                <button type="button" onclick="removeMessage(this);"
                                                        class="btn btn-primary">DELETE
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="panel panel-default">
                                    <div class="panel-heading">
                                        <div class="form-group">
                                            <div class="col-sm-2">
                                                <button class="btn btn-primary" data-toggle="modal"
                                                        data-target="#myModal">Chose uploaded images
                                                </button>
                                            </div>
                                        </div>

                                    </div>

                                    <div class="panel-body">
                                        <div class="form-group images">
                                            <label class="col-sm-2 control-label">Ad new images</label>

                                            <div class="col-sm-4">
                                                <input class="form-control" type="file" name="image[]" multiple>
                                            </div>

                                            <!-- Modal -->
                                            <div class="modal fade" id="myModal" tabindex="-1" role="dialog"
                                                 aria-labelledby="myModalLabel" aria-hidden="true">

                                                <div class="modal-dialog">
                                                    <div class="modal-content">

                                                        <div class="modal-header">
                                                            <button type="button" class="close" data-dismiss="modal"
                                                                    aria-hidden="true">
                                                                &times;
                                                            </button>

                                                            <h4 class="modal-title" id="myModalLabel">
                                                                Images
                                                            </h4>
                                                        </div>

                                                        <div class="modal-body">
                                                            <div id="ad-img">
                                                                <?php foreach ($listImg as $img): ?>
                                                                    <img onclick="choseImage(this)"
                                                                         name="<?php echo $img['name']; ?>" onclick=""
                                                                         src="<?php echo $img['url']; ?>">
                                                                <?php endforeach ?>
                                                                <input type="hidden" name="image_name" id="image_name"
                                                                       value="">
                                                            </div>
                                                        </div>

                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-default"
                                                                    data-dismiss="modal">Close
                                                            </button>
                                                        </div>

                                                    </div>
                                                    <!-- /.modal-content -->
                                                </div>
                                                <!-- /.modal-dialog -->

                                            </div>
                                            <!-- /.modal -->


                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <div class="col-sm-7 pull-right">
                                        <button class="btn btn-primary">CREATE</button>
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
