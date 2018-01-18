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
    .error.item{
        padding-left: 0%;
        margin-top: 0px;
    }
    .receivegame{
        padding-top: 10px;
    }
    .remove_field{
        cursor: pointer;
    }
    .form-group{
        float: left;
        width: 20%;
    }
    .form-group.remove{
        width: 5%;
        color: green;
        cursor: pointer;
    }
    .form-group label{
        width: 35%;
    }
    .form-group input{
        width: 56%;
    }
    .listItem{
        margin-top: 10px;
    }
    .form-horizontal .form-group{
        margin-left: 0px;margin-right: 0px;
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
        .input_fields_wrap .control-group,.input_fields_wrap_receive .control-group{
            padding-top: 15px; padding-bottom: 0px;margin-left: 0px; padding-left: 0px;border: 1px solid #ccc; padding-top:15px; padding-bottom: 15px; margin-top: 10px; margin-bottom: 10px;
        }
        .input_fields_wrap .control-group .form-group,.input_fields_wrap_receive .control-group .form-group{
            padding-bottom: 0px; margin-bottom: 0px;
        }
        .input_fields_wrap .control-group .sublistItem,.input_fields_wrap_receive .control-group .sublistItem{
            border: 0px;
            margin-bottom: 0px;
            padding-bottom: 0px;
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
            top:7px;
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
                    rules[e].count = $($(item).find("input")[2]).val();
                    rules[e].type = $($(item).find("input")[3]).val();
                });
                var strRule = JSON.stringify(rules);                    
                $.ajax({
                    type: "POST",
                    dataType: 'json',
                    url: "<?php echo $url_service;?>/cms/quayso/<?php echo $_GET['id']>0?'edit_filters?id='.$_GET['id']:'add_filters';?>",
                    data:{
                        name:$("input[name=name]").val(),
                        card:$("input[name=card]").val(),
                        total:$("input[name=total]").val(),
                        used:$("input[name=used]").val(),
                        rules:strRule,
                        position:$("input[name=position]").val(),
                        angel_to:$("input[name=angel_to]").val(),
                        angel_from:$("input[name=angel_from]").val(),
                        bg_color:$("input[name=bg_color]").val(),
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
            <?php include APPPATH . 'views/game/lg/GOK/Events/quayso/tab.php'; ?>
            <div class="widget-name">
                <div class="clearboth"></div>
            </div>
            <!--END CONTROL ADD CHEST-->
            <div class="widget" id="viewport">
                <form id="frmSendChest" name="frmSendChest" action="" method="POST" onsubmit="return false;" autocomplete="off">
                    <div class="well form-horizontal">
                        <h5 class="widget-name"><i class=" ico-th-large"></i><?php echo $title; ?></h5>                        
                        <div class="control-group">
                            <label class="control-label">Tên:</label>
                            <div class="controls">
                                <input name="name" id="name" value="<?php echo $items['name'];?>" type="text" class="span3 validate[required]" style="width: 80%"/>
                            </div>
                        </div>
                        <div class="control-group">
                            <label class="control-label">Card:</label>
                            <div class="controls">
                                <input name="card" id="card" value="<?php echo $items['card'];?>" type="text" class="span3 validate[required]" style="width: 80%"/>
                            </div>
                        </div>
                        <div class="control-group">
                            <label class="control-label">Số lượng:</label>
                            <div class="controls">
                                <input name="total" id="total" value="<?php echo $items['total'];?>" type="text" class="span3 validate[required]" style="width: 80%"/>
                            </div>
                        </div>
                        <div class="control-group">
                            <label class="control-label">Sử dụng:</label>
                            <div class="controls">
                                <input name="used" id="used" value="<?php echo $items['used'];?>" type="text" style="width: 80%"/>
                            </div>
                        </div>
                        <div class="control-group">
                            <label class="control-label">Vị trí:</label>
                            <div class="controls">
                                <input name="position" id="position" value="<?php echo $items['position'];?>" type="text" style="width: 80%"/>
                            </div>
                        </div>
                        <div class="control-group">
                            <label class="control-label">Khoảng cách từ:</label>
                            <div class="controls">
                                <input name="angel_to" id="angel_to" value="<?php echo $items['angel_to'];?>" type="text" style="width: 80%"/>
                            </div>
                        </div>
                        <div class="control-group">
                            <label class="control-label">Khoảng cách đến:</label>
                            <div class="controls">
                                <input name="angel_from" id="angel_from" value="<?php echo $items['angel_from'];?>" type="text" style="width: 80%"/>
                            </div>
                        </div>
                        <div class="control-group">
                            <label class="control-label">Màu nền:</label>
                            <div class="controls">
                                <input name="bg_color" id="bg_color" value="<?php echo $items['bg_color'];?>" type="text" style="width: 80%"/>
                            </div>
                        </div>
                        <?php
                            include_once 'json_rule.php';
                        ?>                        
                        <div class="control-group">
                            <div style="padding-left: 20%; text-align: left;">
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