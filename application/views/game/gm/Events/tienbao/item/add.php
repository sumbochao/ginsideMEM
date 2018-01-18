<link rel="stylesheet" href="<?php echo base_url('assets/datetime/css/style.css'); ?>"/>
<link rel="stylesheet" href="<?php echo base_url('assets/datetime/css/bootstrap.css'); ?>"/>
<script src="<?php echo base_url('assets/datetime/js/currency.js'); ?>"></script>
<?php
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
        .form-group {
            float: left;
            width: 22%;
        }
        .form-group input {
            width: 70%;
        }
        .form-horizontal .form-group{
            margin-left: 0px;
            margin-right: 0px;
        }
        .form-horizontal .listItem .control-label{
            padding-right: 5px;
            width: 27% !important;
            color: green;
        }
        .form-horizontal .listItem .sublistItem .control-label{
            color: #f36926;
        }
        .form-horizontal .sublistItem{
            margin-left: 15px;
        }
        .remove_field,.remove_field_receive{
            cursor: pointer;
            color: green;
        }
        .input_fields .control-group{
            padding-top: 23px; padding-bottom: 0px;margin-left: 0px; padding-left: 0px;border: 1px solid #ccc; margin-top: 10px; margin-bottom: 10px;
        }
        .input_fields_wrap .control-group .form-group{
            padding-bottom: 0px; margin-bottom: 0px;
        }
        
        .input_fields_wrap .control-group .sublistItem .remove_sub{
            top:4px;
        }
        .loadContent{
            text-align: center;
            color: red;
        }
        .input_fields_wrap .control-group .sublistItem .remove_sub .remove_field{
            color: #f36926 !important;
        }
        .form-horizontal .control-label{
            text-align: center;
        }
        .form-group.remove{
            width: 10%;
            position: relative;
            top:6px;
        }
        .subItems{
            margin-left: 20px;
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
            <?php include APPPATH . 'views/game/gm/Events/tienbao/tab.php'; ?>
            <div class="widget-name">
                <div class="clearboth"></div>
            </div>

            <!--END CONTROL ADD CHEST-->
            <div class="widget" id="viewport">
                <form id="frmSendChest" name="frmSendChest" action="/?control=tienbao_gm&func=post_item&module=all" method="POST" enctype="multipart/form-data">
                    <div class="well form-horizontal">
                        <?php
                            $statusOn = 'checked';
                            $start = gmdate('d-m-Y G:i:s',time()+7*3600);
                            $end = gmdate('d-m-Y G:i:s',time()+7*3600);
                            if($_GET['id']>0){
                                $statusOn =  $items['status']==1 ? 'checked="checked"':'';
                                $statusOff =  $items['status']==0 ? 'checked="checked"':'';
                                if(!empty($items['start']) && $items['start']!='0000-00-00 00:00:00'){
                                    $start = date_format(date_create($items['start']),"d-m-Y G:i:s");
                                }else{
                                    $start = gmdate('d-m-Y G:i:s',time()+7*3600);
                                }
                                if(!empty($items['end']) && $items['start']!='0000-00-00 00:00:00'){
                                    $end = date_format(date_create($items['end']),"d-m-Y G:i:s");
                                }else{
                                    $end = gmdate('d-m-Y G:i:s',time()+7*3600);
                                }
                            }
                        ?>
                        <div class="control-group">
                            <label class="control-label">Tên:</label>
                            <div class="controls">
                                <input name="name" id="name" value="<?php echo $items['name'];?>" type="text" class="span3 validate[required]" style="width: 80%"/>
                            </div>
                        </div>
                        <div class="control-group">
                            <label class="control-label">Picture:</label>
                            <div class="controls">
                                <input type="file" name="picture"/>
                                <?php
                                    if($_GET['id']>0){
                                ?>
                                <div id="load-content" style="margin-top:10px;">
                                    <?php
                                        if(!empty($items['picture'])){
                                            $removeLink = $url_service.'/cms/tienbao/remove_image?id='.$items['id'];
                                    ?>
                                    <img src="<?php echo $url_picture.'/'.$items['picture'];?>" style="max-height:34px;"/>
                                    <div style="padding-top:5px;"><a href="javascript:loadPage('div#load-content','<?php echo $removeLink;?>')">remove</a></div>
                                    <?php
                                        }
                                    ?>

                                    <input type="hidden" class="span12" id="current_image" name="current_picture" value="<?php echo $items['picture'];?>"/>
                                </div>
                                <?php
                                    }
                                ?>
                            </div>
                        </div>
                        <?php
                            include_once 'json_rule.php';
                        ?>
                        <div class="control-group">
                            <label class="control-label">Server:</label>
                            <div class="controls">
                                <input name="server_id" id="server_id" value="<?php echo $items['server_id'];?>" type="text" style="width: 80%"/>
                                <div>Ví dụ : [60001][60002][60003]</div>
                            </div>
                        </div>
                        <div class="control-group">
                            <label class="control-label">Số tiền (VNĐ):</label>
                            <div class="controls">
                                <input name="money" id="money" value="<?php echo $items['money'];?>" type="text" style="width: 80%" onKeyUp="this.value = FormatNumber(this.value);"/>
                            </div>
                        </div>
                        <div class="control-group">
                            <label class="control-label">Số lần đổi:</label>
                            <div class="controls">
                                <input name="quantity" id="quantity" value="<?php echo $items['quantity'];?>" type="text" style="width: 80%"/>
                            </div>
                        </div>
                        <script>
                            function typeSelect(item){
                                switch(item){
                                    case "3":
                                        $(".vipitem").show();
                                        $(".orderitem").hide();
                                        $(".datetimepicker").show();
                                        break;
                                    case "4":
                                        $(".vipitem").hide();
                                        $(".orderitem").show();
                                        $(".datetimepicker").show();
                                        break;
                                    default:
                                        $(".vipitem").hide();
                                        $(".orderitem").hide();
                                        $(".datetimepicker").hide();
                                        break;
                                }
                            }
                            $(function(){
                                var item = "<?php echo $items['type'];?>";
                                typeSelect(item);
                                $('select[name=type]').click(function() {
                                    typeSelect($(this).val());
                                });
                            });
                        </script>
                        <div class="control-group">
                            <label class="control-label">Loại quà:</label>
                            <div class="controls">
                                <select name="type" class="validate[required,custom[onlyNumberSp]]">
                                    <option value="">Chọn loại quà</option>
                                    <option value="1" <?php echo ($items['type']=='1')?'selected="selected"':'';?>>Thẻ tướng</option>
                                    <option value="2" <?php echo ($items['type']=='2')?'selected="selected"':'';?>>Item khác</option>
                                    <option value="3" <?php echo ($items['type']=='3')?'selected="selected"':'';?>>Item vip</option>
                                    <option value="4" <?php echo ($items['type']=='4')?'selected="selected"':'';?>>Kì ngộ</option>
                                </select>
                            </div>
                        </div>
                        <div class="control-group vipitem">
                            <label class="control-label">Level vip:</label>
                            <div class="controls">
                                <input type="text" name="levelvip" value="<?php echo ($items['levelvip']>0)?$items['levelvip']:'0';?>"/>
                            </div>
                        </div>
                        <div class="control-group orderitem">
                            <label class="control-label">Order:</label>
                            <div class="controls">
                                <input type="text" name="order" value="<?php echo ($items['order']>0)?$items['order']:'1';?>"/>
                            </div>
                        </div>
                        <div class="control-group datetimepicker">
                            <label class="control-label">Bắt đầu nhận:</label>
                            <div class="controls">
                                <input type="text" class="datetime" name="start" value="<?php echo $start;?>"/>
                            </div>
                        </div>

                        <div class="control-group datetimepicker">
                            <label class="control-label">Kết thúc nhận:</label>
                            <div class="controls">
                                <input type="text" class="datetime" name="end" value="<?php echo $end;?>"/>
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
<script>
    $('.datetime').datetimepicker({
        dateFormat: 'dd-mm-yy',
        timeFormat: 'hh:mm:ss'//
    });
</script>