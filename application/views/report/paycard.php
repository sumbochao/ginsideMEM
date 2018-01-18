<link rel="stylesheet" href="<?php echo base_url('assets/datetime/css/style.css'); ?>"/>
<link rel="stylesheet" href="<?php echo base_url('assets/datetime/css/bootstrap.css'); ?>"/>
<script src="<?php echo base_url('assets/datetime/js/submit.js'); ?>"></script>
<script src="<?php echo base_url('assets/js/ajax.js'); ?>"></script>
<link rel="stylesheet" href="<?php echo base_url('assets/css/lightbox.css'); ?>"/>
<script src="<?php echo base_url('assets/js/lightbox.js'); ?>"></script>

<script src="<?php echo base_url('assets/popup/bootstrap-modal.js') ?>"></script>
<script src="<?php echo base_url('assets/popup/bootstrap-transition.js') ?>"></script>
<style>
.loadserver .textinput{
    width:205px;
    margin-top:-10px;
}
.scroolbar{
    height: 500px;
}
</style>
<div class="loading_warning"></div>
<div id="content-t" style="min-height:500px; padding-top:10px">
    <form id="appForm" action="" method="post" name="appForm">
        <div class="filter">
            <select name="slbGame" onchange="getServer(this.value)" style="width:150px;">
                <option value="" <?php echo ($arrFilter['slbGame']=='')?'selected="selected"':'';?>>Chọn game</option>
                <?php
                    if(empty($slbScopes) !== TRUE){
                        foreach($slbScopes as $v){
                            if((@in_array($v['app_name'], $_SESSION['permission']) && $_SESSION['account']['id_group']==2)|| $_SESSION['account']['id_group']==1){
                ?>
                <option value="<?php echo $v['app_name'];?>" <?php echo ($arrFilter['slbGame']==$v['app_name'])?'selected="selected"':'';?>><?php echo $v['app_fullname'];?></option>
                <?php
                            }
                        }
                    }
                ?>
            </select>
            
            <span class="loadserver">
                <select name="game_server_id">
                    <option value="0">Chọn server</option>
                    <?php
                        if(empty($slbServer) !== TRUE){
                            foreach($slbServer as $v){
                    ?>
                    <option value="<?php echo $v['server_id'];?>" <?php echo ($v['server_id']==$arrFilter['game_server_id'])?'selected="selected"':'';?>><?php echo $v['server_name'];?></option>
                    <?php
                            }
                        }
                    ?>
                </select>
            </span>
            <input type="text" name="keyword" value="<?php echo $arrFilter['keyword'];?>" class="textinput" placeholder="character id, character name, mobo service id, event, money" title="character id, character name, mobo service id, event, money"/>
            <input type="text" style="width:150px;" name="date_from" placeholder="Ngày bắt đầu" value="<?php echo (!empty($arrFilter['date_from']))?$arrFilter['date_from']:date('d-m-Y G:i:s',  strtotime('-14 day'));?>"/>
            <input type="text" style="width:150px;" name="date_to" placeholder="Ngày kết thúc" value="<?php echo (!empty($arrFilter['date_to']))?$arrFilter['date_to']:date('d-m-Y G:i:s');?>"/>
            <input type="button" onclick="onSubmitFormAjax('appForm','<?php echo base_url().'?control=report&func=paycard&type=filter_paycard';?>')" value="Tìm" class="btn btn-primary"/>
			<input type="button" onclick="onSubmitFormAjax('appForm','<?php echo base_url().'?control=report&func=paycard_excel';?>')" value="Xuất Excel" class="btn btn-success"/>
        </div>
        <div class="wrapper_scroolbar">
            <div class="scroolbar">
            <table width="100%" border="0" class="table table-striped table-bordered table-condensed table-hover">
                <thead>
                    <tr>
                        <th align="center">Character Name</th>
                        <th align="center">Character ID</th>
                        <th align="center">Mobo Service ID</th>
                        <th align="center">Server ID</th>     
                        <th align="center">Mobo ID</th>
                        <th align="center">Mobo Account</th>
                        <th align="center">Event</th>
                        <th align="center">Serial</th>
                        <th align="center" style="display:none">Pin</th>
                        <th align="center">Money</th>
                        <th align="center">Type</th>
                        <th align="center">App</th>
                        <th align="center" style="display:none">Status</th>
                        <th align="center">Description</th>
                        <th align="center">Date</th>
                        <th align="center" style="display:none">Latency</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        if(empty($listItems) !== TRUE){
                            foreach($listItems as $v){
                    ?>
                    <tr>
                        <td align="center"><?php echo $v['character_name'];?></td>
                        <td align="center"><?php echo $v['character_id'];?></td>
                        <td align="center"><?php echo $v['mobo_service_id'];?></td>
                        <td align="center"><?php echo $v['server_id'];?></td>
                        <td align="center"><?php echo $v['mobo_id'];?></td>
                        <td align="center"><?php echo $v['mobo_account'];?></td>
                        <td align="center"><?php echo $v['event'];?></td>
                        <td align="center"><?php echo $v['serial'];?></td>
                        <td align="center" style="display:none"><?php echo $v['pin'];?></td>
                        <td align="center"><?php echo ($v['money']>0)?number_format($v['money'],0,',',','):0;?></td>
                        <td align="center"><?php echo $v['type'];?></td>
                        <td align="center"><?php echo $v['app'];?></td>
                        <td align="center" style="display:none"><?php echo $v['status'];?></td>
                        <td align="center">
                            <?php 
                                $description = json_decode($v['description'],true);
                                echo 'ID: '.$description['id'].'<br>';
                                echo 'Value: '.$description['value'].'<br>';
                                echo 'Msg: '.$description['msg'].'<br>';
                            ?>
                        </td>
                        <td align="center" class="space_wrap">
                            <?php 
                                $datec = DateTime::createFromFormat('Y-m-d G:i:s',$v['date']);
                                echo $datec->format('d-m-Y G:i:s');
                            ?>
                        </td>
                        <td align="center" style="display:none"><?php echo $v['latency'];?></td>
                    </tr>
                    <?php
                            }
                        }else{
                    ?>
                    <tr>
                        <td colspan="16" class="emptydata">Dữ liệu không tìm thấy</td>
                    </tr>
                    <?php
                        }
                    ?>
                </tbody>
            </table>
            </div>
        </div>
        <?php echo $pages?>
    </form>
</div>
<script type="text/javascript">
    $('input[name=date_from]').datetimepicker({
        dateFormat: 'dd-mm-yy',
        timeFormat: 'hh:mm:ss'
    });
    $('input[name=date_to]').datetimepicker({
        dateFormat: 'dd-mm-yy',
        timeFormat: 'hh:mm:ss',
        /*onSelect: function(date){
            var date2 = $('input[name=date_to]').datetimepicker('getDate');
            date2.setDate(date2.getDate()+1);
            $('input[name=date_to]').datetimepicker('setDate', date2);
        }*/
    });
	jQuery('input[name=keyword]').keypress(function(event) {
        if (event.keyCode == '13') {
            onSubmitFormAjax('appForm','<?php echo base_url().'?control=report&func=paycard&type=filter_paycard';?>');
            return false;
        }
        return true;
    });
	function onSubmitFormAjax(formName,url){
        var dateForm = $('input[name=date_from]').val();
        var dateTo = $('input[name=date_to]').val();
        $.ajax({
            url:baseUrl+'?control=report&func=getvalidate_paycard',
            type:"POST",
            data:{dateForm:dateForm,dateTo:dateTo},
            async:false,
            dataType:"json",
            beforeSend:function(){
                $('.loading_warning').show();
            },
            success:function(f){
                if(typeof f.error!="undefined" && f.error==0){
                    $('.loading_warning').hide();
                    var theForm = document.getElementById(formName);
                    theForm.action = url;	
                    theForm.submit();	
                    return true;
                }else{
                    Lightboxt.showemsg('Thông báo', '<b>'+f.messg+'</b>', 'Đóng');
                    $('.loading_warning').hide();
                }
            }
        });
        
    }
</script>
	