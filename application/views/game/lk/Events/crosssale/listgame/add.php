<link rel="stylesheet" href="<?php echo base_url('assets/datetime/css/style.css'); ?>"/>
<link rel="stylesheet" href="<?php echo base_url('assets/datetime/css/bootstrap.css'); ?>"/>
<?php
    if($_SERVER['SERVER_ADDR']=='127.0.0.1'){
        $url_service = 'http://localhost.game.mobo.vn/hiepkhach/index.php';
        $url_pciture = 'http://localhost.game.mobo.vn/hiepkhach';
    }else{
        $url_service = 'http://game.mobo.vn/hiepkhach';
        $url_pciture = $url_service;
    }
    
    $url_redirect = $_SERVER['REQUEST_URI'];
?>
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
                window.history.go(-1); return false;
            });

            $('#frmSendChest').ajaxForm(function (data) {
                if ($('#frmSendChest').validationEngine('validate') === false)
                    return false;

                $(".loading").fadeIn("fast");
                json_data = $.parseJSON($.parseJSON(data));
                if (data.result != "-1") {
                    $(".modal-body #messgage").html(json_data.message);
                    $('.bs-example-modal-sm').modal('show');
                    $(".loading").fadeOut("fast");
                    <?php
                        if($_GET['id']>0){
                    ?>
                    window.location.href='<?php echo $url_redirect;?>';
                    <?php
                        }
                    ?>
                }
                else {
                    $(".modal-body #messgage").html(json_data.message);
                    $('.bs-example-modal-sm').modal('show');
                    $(".loading").fadeOut("fast");
                }
            });
        });
        function loadPage(area, url){
            $(area).load(url);
	}
    </script>

    <!-- Content -->
    <div id="content">
        <!-- Content wrapper -->
        <div class="wrapper">
            <?php include APPPATH . 'views/game/lk/Events/crosssale/tab.php'; ?>
            <div class="widget-name">
                <div class="clearboth"></div>
            </div>

            <!--END CONTROL ADD CHEST-->
            <div class="widget" id="viewport">
                <form id="frmSendChest" name="frmSendChest" action="/?control=crosssale&func=add_match" method="POST" enctype="multipart/form-data">
                    <div class="well form-horizontal">
                        <h5 class="widget-name">
                        <?php
                            $statusOn = 'checked';
                            if($_GET['id']>0){
                                $statusOn =  $items['status']==1 ? 'checked="checked"':'';
                                $statusOff =  $items['status']==0 ? 'checked="checked"':'';
                            }
                        ?>
                        <div class="control-group">
                            <label class="control-label">Game ID:</label>
                            <div class="controls">
                                <input name="gameID" id="gameID" value="<?php echo $items['gameID'];?>" type="text" class="span3 validate[required]" />
                            </div>
                        </div>
                        <div class="control-group">
                            <label class="control-label">Tên:</label>
                            <div class="controls">
                                <input name="name" id="name" value="<?php echo $items['name'];?>" type="text" class="span3 validate[required]" />
                            </div>
                        </div>
                        <div class="control-group">
                            <label class="control-label">Alias:</label>
                            <div class="controls">
                                <input name="alias" id="alias" value="<?php echo $items['alias'];?>" type="text" class="span3 validate[required]" />
                            </div>
                        </div>
                        <div class="control-group">
                            <label class="control-label">Picture:</label>
                            <div class="controls">
                                <input type="file" name="url"/>
                                <?php
                                    if($_GET['id']>0){
                                ?>
                                <div id="load-content" style="margin-top:10px;">
                                    <?php
                                        if(!empty($items['url'])){
                                            $removeLink = $url_service.'/cms/crosssale/remove_pic?id='.$items['idx'];
                                    ?>
                                    <img src="<?php echo $url_pciture.$items['url'];?>" height="100px"/>
                                    <div style="padding-top:5px;"><a href="javascript:loadPage('div#load-content','<?php echo $removeLink;?>')">remove</a></div>
                                    <?php
                                        }
                                    ?>
                                    
                                    <input type="hidden" class="span12" id="current_url" name="current_url" value="<?php echo $items['url'];?>"/>
                                </div>
                                <?php
                                    }
                                ?>
                            </div>
                        </div>
                        <div class="control-group">
                            <label class="control-label">Link Android:</label>
                            <div class="controls">
                                <textarea style="width:50%;" name="linkandroid"><?php echo $items['linkandroid'];?></textarea>
                            </div>
                        </div>
                        <div class="control-group">
                            <label class="control-label">Link IOS:</label>
                            <div class="controls">
                                <textarea style="width:50%;" name="linkios"><?php echo $items['linkios'];?></textarea>
                            </div>
                        </div>
                        <div class="control-group">
                            <label class="control-label">Link WP:</label>
                            <div class="controls">
                                <textarea style="width:50%;" name="linkwp"><?php echo $items['linkwp'];?></textarea>
                            </div>
                        </div>
                        <div class="control-group">
                            <label class="control-label">Trạng thái:</label>
                            <div class="controls">
                                Enable:<input type="radio" name="status" id="status" value="1" <?php echo $statusOn;?>/>
                                &nbsp;&nbsp;
                                Disable:<input type="radio" name="status" id="status" value="0" <?php echo $statusOff;?>/>
                            </div>
                        </div>
                        <div class="control-group">
                            <div style="padding-left: 20%; text-align: left;">
                                <?php
                                    if($_GET['id']>0){
                                ?>
                                <input type="hidden" name="id" value="<?php echo $_GET['id'];?>"/>
                                <?php
                                    }
                                ?>
                                <input type="hidden" name='email' value="<?php echo $_SESSION['auth']['user']->ause_username;?>">
                                <button id="onSubmit" class="btn btn-primary"><span>Thực hiện</span></button>
                                <button id="comeback" class="btn btn-primary"><span>Quay lại</span></button>
                                <div style="display: inline-block">
                                    <span id="message" style="color: green"></span>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <!-- /content wrapper -->
    </div>
    <!-- /content -->
</div>
