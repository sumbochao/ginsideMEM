<script src="<?php echo base_url('assets/datetime/js/jquery-1.11.1.min.js') ?>"></script>
<link rel="stylesheet" href="<?php echo base_url('assets/datetime/css/style.css');?>"/>
<link rel="stylesheet" href="<?php echo base_url('assets/datetime/css/bootstrap.css'); ?>"/>

<script src="<?php echo base_url('assets/datetime/js/jquery-ui.min.js') ?>"></script>
<script src="<?php echo base_url('assets/datetime/js/jquery-ui-timepicker-addon.js') ?>"></script>
<link rel="stylesheet" href="<?php echo base_url('assets/datetime/css/jquery-ui.css') ?>"/>
<link rel="stylesheet" href="<?php echo base_url('assets/datetime/css/jquery-ui-timepicker-addon.css') ?>"/>

<link rel="stylesheet" href="<?php echo base_url('assets/css/lightbox.css'); ?>"/>
<script src="<?php echo base_url('assets/js/lightbox.js'); ?>"></script>

<script src="<?php echo base_url('assets/multiselect/js/bootstrap-multiselect.js') ?>"></script>
<script src="<?php echo base_url('assets/multiselect/js/prettify.js') ?>"></script>
<link rel="stylesheet" href="<?php echo base_url('assets/multiselect/css/bootstrap-multiselect.css') ?>"/>
<link rel="stylesheet" href="<?php echo base_url('assets/multiselect/css/prettify.css') ?>"/>
<style>
    .receivegame{
        padding-top: 10px;
    }
</style>
<div class="loading_warning"></div>
<div id="content-t" class="content_form" style="min-height:500px; padding-top:10px">
    <form id="appForm" action="" method="post" name="appForm">
        <?php include_once 'include/toolbar.php'; ?>
        <div id="adminfieldset">
            <div class="adminheader">Nhập thông tin</div>
            <div class="group_left">
                <div class="rows">	
                    <label for="menu_group_id">Config</label>
                    <select name="configID">
                        <option value="0">Chọn config</option>
                        <?php
                            if(count($slbConfig)>0){
                                foreach($slbConfig as $v){
                        ?>
                        <option value="<?php echo $v['idx'];?>" <?php echo ($v['idx']==$items['configID'])?'selected="selected"':'';?>><?php echo $v['name'];?></option>
                        <?php
                                }
                            }
                        ?>
                    </select>
                    <?php echo $errors['configID'];?>
                </div>
                <div class="rows">	
                    <label for="menu_group_id">Name</label>
                    <input type="text" name="name" class="textinput" value="<?php echo $items['name'];?>"/>
                    <?php echo $errors['name'];?>
                </div>
                <div class="rows">	
                    <label for="menu_group_id">Url</label>
                    <textarea cols="50" rows="5" style="width: 60%;" name="url"><?php echo $items['url'];?></textarea>
                    <?php echo $errors['url'];?>
                </div>
                <div class="rows">	
                    <label for="menu_group_id">Desc</label>
                    <textarea cols="50" style="width: 60%;" rows="5" name="desc"><?php echo $items['desc'];?></textarea>
                    <?php echo $errors['desc'];?>
                </div>
                <div class="rows">	
                    <label for="menu_group_id">Duyệt</label>
                    <input type="radio" name="status" value="0" <?php echo ($items['status']==0)?'checked="checked"':'';?>/> Tắt 
                    <input type="radio" name="status" value="1" <?php echo ($items['status']==1)?'checked="checked"':'';?>/> Bật
                </div>
            </div>
            <div class="group_right">
                <div class="rows">	
                    <label for="menu_group_id">Date Start</label>
                    <input type="text" name="startDate" placeholder="Ngày bắt đầu" value="<?php echo (!empty($arrFilter['startDate']))?$arrFilter['startDate']:date('d-m-Y G:i:s',  strtotime('-1 day'));?>"/>
                </div>
                <div class="rows">	
                    <label for="menu_group_id">Date To</label>
                    <input type="text" name="endDate" placeholder="Ngày kết thúc" value="<?php echo (!empty($arrFilter['endDate']))?$arrFilter['endDate']:date('d-m-Y G:i:s');?>"/>
                </div>
                <div class="rows">	
                    <label for="menu_group_id">Game</label>
                    <select name="gameID" onchange="getReceiveGame(this.value)">
                        <option value="0">Chọn game</option>
                        <?php
                            if(count($slbGame)>0){
                                foreach($slbGame as $v){
                        ?>
                        <option value="<?php echo $v['gameID'];?>" <?php echo ($v['gameID']==$items['gameID'])?'selected="selected"':'';?>><?php echo $v['name'];?></option>
                        <?php
                                }
                            }
                        ?>
                    </select>
                    <?php echo $errors['gameID'];?>
                </div>
                <div class="rows">	
                    <label for="menu_group_id">List Game</label>
                    <span class="loadReceiveGame">
                        <script>
                            jQuery('.dropdown input, .dropdown label').click(function (event) {
                                event.stopPropagation();
                            });
                            jQuery(document).ready(function () {
                                jQuery('#receiveGame').multiselect({
                                    includeSelectAllOption: true,
                                    enableCaseInsensitiveFiltering: true
                                });
                            });
                        </script>
                        <?php
                            $arrReceiveGame = explode(',', $items['receiveGame']);
                            $arrNewRecei = array();
                            if(count($arrReceiveGame)>0){
                                foreach($arrReceiveGame as $are){
                                    $arrNewRecei[$are] = $are;
                                }
                            }
                        ?>
                        <select id="receiveGame" class="server" name="receiveGame[]" multiple="multiple">
                            <?php

                                if(count($slbReceiveGame)>0){
                                    foreach($slbReceiveGame as $vs){
                            ?>
                            <option value="<?php echo $vs['gameID'];?>" <?php echo ($vs['gameID']==$arrNewRecei[$vs['gameID']])?'selected="selected"':'';?>><?php echo $vs['name'];?></option>
                            <?php
                                    }
                                }
                            ?>
                        </select>
                        <?php echo $errors['receiveGame'];?>
                    </span>
                </div>
            </div>
            <div class="clr"></div>
        </div>
    </form>
</div>
<script type="text/javascript">
    $('input[name=startDate]').datetimepicker({
        dateFormat: 'dd-mm-yy',
        timeFormat: 'HH:mm:ss'
    });
    $('input[name=endDate]').datetimepicker({
        dateFormat: 'dd-mm-yy',
        timeFormat: 'HH:mm:ss',
        /*onSelect: function(date){
            var date2 = $('input[name=date_to]').datetimepicker('getDate');
            date2.setDate(date2.getDate()+1);
            $('input[name=date_to]').datetimepicker('setDate', date2);
        }*/
    });
    function getReceiveGame(id){
        $.ajax({
            url:baseUrl+'/?control=request_cat&func=ajax_receive',
            type:"POST",
            data:{id:id},
            async:false,
            dataType:"json",
            beforeSend:function(){
                $('.loading_warning').show();
            },
            success:function(f){
                if(typeof f.status!="undefined"&&f.status==0){
                    $(".loadReceiveGame").html(f.html);
                    $('.loading_warning').hide();
                }else{
                    Lightboxt.showemsg('Thông báo', '<b>'+f.messg+'</b>', 'Đóng');
                    $('.loading_warning').hide();
                }
            }
        });
    }
</script>