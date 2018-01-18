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
    .titlesub{
        position: relative;
        top:-4px;
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
            var j_top_level = '';
            var json_level = {
                'server_id':$("input[name=level_server]").val(),
                'limit':$("input[name=level_limit]").val()
            };
            j_top_level = JSON.stringify(json_level);
            var j_top_win = '';
            var json_win = {
                'server_id':$("input[name=win_server]").val(),
                'limit':$("input[name=win_limit]").val()
            };
            j_top_win = JSON.stringify(json_win);
            $.ajax({
                type: "POST",
                dataType: 'jsonp',
                url: "<?php echo $url_service;?>/cms/top_event/<?php echo $_GET['id']>0?'edit_'.$_GET['view'].'?id='.$_GET['id']:'add_'.$_GET['view'];?>",
                data:{
                        name:$("input[name=name]").val(),
                        content_id:$("input[name=content_id]").val(),
                        top_level:j_top_level,
                        top_win:j_top_win,
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
            <?php include APPPATH . 'views/game/moba/Events/top_event/tab.php'; ?>
            <div class="widget-name">
                <div class="clearboth"></div>
            </div>
            <!--END CONTROL ADD CHEST-->
            <div class="widget" id="viewport">
                <form id="frmSendChest" name="frmSendChest" action="" method="POST" onsubmit="return false;" autocomplete="off">
                    <div class="well form-horizontal">
                        <?php
                            if($_GET['id']>0){
                                $level = json_decode($items['top_level'],true);
                                $win = json_decode($items['top_win'],true);
                            }
                        ?>
                        <div class="control-group">
                            <label class="control-label">Tên:</label>
                            <div class="controls">
                                <input name="name" id="name" value="<?php echo $items['name'];?>" type="text" class="span3 validate[required]" style="width: 80%"/>
                            </div>
                        </div>
                        <div class="control-group">
                            <label class="control-label">Nội dung bài viết:</label>
                            <div class="controls">
                                <input name="content_id" id="content_id" value="<?php echo $items['content_id'];?>" type="text" class="span3 validate[required]" style="width: 80%"/>
                            </div>
                        </div>
                        <div class="control-group">
                            <label class="control-label">Top level:</label>
                            <div class="controls">
                                <span class="titlesub">Server :</span> <input type="text" name="level_server" value="<?php echo $level['server_id'];?>"/> 
                                <span class="titlesub" style="padding-left:10px;">Limit :</span> <input type="text" name="level_limit" value="<?php echo $level['limit'];?>"/>
                            </div>
                        </div>

                        <div class="control-group">
                            <label class="control-label">Top win:</label>
                            <div class="controls">
                                <span class="titlesub">Server :</span> <input type="text" name="win_server" value="<?php echo $win['server_id'];?>"/> 
                                <span class="titlesub" style="padding-left:10px;">Limit :</span> <input type="text" name="win_limit" value="<?php echo $win['limit'];?>"/>
                            </div>
                        </div>
                        <div class="control-group">
                            <div style="padding-left: 20%; text-align: left;">
                                <input type="hidden" name='email' value="<?php echo $_SESSION['auth']['user']->ause_username;?>">
                                <input type="hidden" name='game_id' value="<?php echo $_GET['game'];?>">
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
