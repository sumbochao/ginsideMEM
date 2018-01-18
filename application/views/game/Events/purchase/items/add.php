<link rel="stylesheet" href="<?php echo base_url('assets/datetime/css/style.css'); ?>"/>
<link rel="stylesheet" href="<?php echo base_url('assets/datetime/css/bootstrap.css'); ?>"/>
<script src="<?php echo base_url('assets/datetime/js/currency.js'); ?>"></script>
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

            $('#onSubmit').on('click', function () {
                if ($('#frmSendChest').validationEngine('validate') === false)
                    return false;

                var rules = [];
                $(".item_rule").each(function(e, item) {
                    rules[e] = {};
                    rules[e].item_id = $($(item).find("input")[0]).val();
                    rules[e].name = $($(item).find("input")[1]).val();
                    rules[e].img = $($(item).find("input")[2]).val();
                    rules[e].count = $($(item).find("input")[3]).val();
                    rules[e].rate = $($(item).find("input")[4]).val();
                    rules[e].type = $($(item).find("input")[5]).val();
                });
                var items = JSON.stringify(rules);
                $.ajax({
                    type: "POST",
                    dataType: 'jsonp',
                    url: "<?php echo $url_service;?>/cms/purchase/<?php echo $_GET['id']>0?'edit_'.$_GET['view'].'?id='.$_GET['id']:'add_'.$_GET['view'];?>",
                    data:{
                        game_id:$("input[name=game_id]").val(),
                        server_id:$("input[name=content_server]").val(),
                        items:items,
						name:$("input[name=name]").val(),
                        buymin:$("input[name=buymin]").val(),
                        price:$("input[name=price]").val(),
                        percent:$("input[name=percent]").val(),
                        start:$("input[name=start]").val(),
                        end:$("input[name=end]").val(),
                        status:$("input:radio[name='status']:checked").val(),
                        issell:$("select[name=issell]").val(),
                        value_name:$("input[name=value_name]").val(),
                    },
                    beforeSend: function () {
                        $(".loading").fadeIn("fast");
                    }
                }).done(function (result) {
                    console.log(result);
                    $(".modal-body #messgage").html(result.message);
                    $('.bs-example-modal-sm').modal('show');
                    $(".loading").fadeOut("fast");

                });
            });
        });
    </script>

    <!-- Content -->
    <div id="content">
        <!-- Content wrapper -->
        <div class="wrapper">
            <?php include APPPATH . 'views/game/Events/purchase/tab.php'; ?>
            <div class="widget-name">
                <div class="clearboth"></div>
            </div>
            <!--END CONTROL ADD CHEST-->
            <div class="widget" id="viewport">
                <form id="frmSendChest" name="frmSendChest" action="" method="POST" onsubmit="return false;" autocomplete="off">
                    <div class="well form-horizontal">
                        <?php
                            $statusOn = 'checked';
                            $start = date('d-m-Y G:i:s',time());
                            $end = date('d-m-Y G:i:s',time());
                            if($_GET['id']>0){
                                $statusOn =  $items['status']==1 ? 'checked="checked"':'';
                                $statusOff =  $items['status']==0 ? 'checked="checked"':'';
                                if(!empty($items['start'])){
                                    $start = date_format(date_create($items['start']),"d-m-Y G:i:s");
                                }else{
                                    $start = date('d-m-Y G:i:s',time());
                                }
                                if(!empty($items['end'])){
                                    $end = date_format(date_create($items['end']),"d-m-Y G:i:s");
                                }else{
                                    $end = date('d-m-Y G:i:s',time());
                                }
                            }
                        ?>
                        <?php include_once 'common/server.php';?>
						<div class="control-group">
                            <label class="control-label">Tên:</label>
                            <div class="controls">
                                <input name="name" value="<?php echo $items['name'];?>" type="text" style="width: 80%"/>
                            </div>
                        </div>
                        <div class="control-group">
                            <label class="control-label">Số lượng:</label>
                            <div class="controls">
                                <input name="buymin" value="<?php echo $items['buymin'];?>" type="text" style="width: 80%"/>
                            </div>
                        </div>
                        <div class="control-group">
                            <label class="control-label">Giá:</label>
                            <div class="controls">
                                <input name="price" onkeyup="this.value = FormatNumber(this.value);" value="<?php echo ($items['price']>0)?number_format($items['price'],0,',','.'):'0';?>" type="text" style="width: 80%" class="span3 validate[required]"/>
                            </div>
                        </div>
                        <div class="control-group">
                            <label class="control-label">Phần trăm:</label>
                            <div class="controls">
                                <input name="percent" value="<?php echo $items['percent'];?>" type="text" style="width: 80%" class="span3 validate[required]"/>
                            </div>
                        </div>
                        <div class="control-group">
                            <label class="control-label">Đơn vị:</label>
                            <div class="controls">
                                <input name="value_name" value="<?php echo $items['value_name'];?>" type="text" style="width: 80%"/>
                            </div>
                        </div>
                        <div class="control-group">
                            <label class="control-label">Được bán:</label>
                            <div class="controls">
                                <?php
                                    if($_GET['func']=='add'){
                                ?>
                                <select name="issell">
                                    <option value="-1">Khởi tạo</option>
                                    <option value="0">Không đồng ý bán</option>
                                    <option value="1">Đồng ý bán</option>
                                </select>
                                <?php
                                    }else{
                                ?>
                                <select name="issell">
                                    <option value="-1" <?php echo $items['issell']==-1?'selected="selected"':'';?>>Khởi tạo</option>
                                    <option value="0" <?php echo $items['issell']==0?'selected="selected"':'';?>>Không đồng ý bán</option>
                                    <option value="1" <?php echo $items['issell']==1?'selected="selected"':'';?>>Đồng ý bán</option>
                                </select>
                                <?php
                                    }
                                ?>
                            </div>
                        </div>
                        <div class="control-group">
                            <label class="control-label">Bắt đầu sự kiện:</label>
                            <div class="controls">
                                <input type="text" class="datetime" name="start" value="<?php echo $start;?>"/>
                            </div>
                        </div>

                        <div class="control-group">
                            <label class="control-label">Kết thúc sự kiện:</label>
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
                        <?php include_once 'json_rule.php'; ?>
                        <div class="control-group">
                            <div style="padding-left: 20%; text-align: left;">
                                <input type="hidden" name='email' value="<?php echo $_SESSION['auth']['user']->ause_username;?>">
                                <input type="hidden" name='game_id' value="<?php echo $_GET["game"];?>"/>
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
