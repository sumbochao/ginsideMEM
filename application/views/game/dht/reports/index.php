<link rel="stylesheet" href="<?php echo base_url('assets/datetime/css/style.css'); ?>"/>
<link rel="stylesheet" href="<?php echo base_url('assets/datetime/css/bootstrap.css'); ?>"/>
<script src="<?php echo base_url('assets/datetime/js/submit.js'); ?>"></script>
<script src="<?php echo base_url('assets/js/ajax.js'); ?>"></script>
<link rel="stylesheet" href="<?php echo base_url('assets/css/lightbox.css'); ?>"/>
<script src="<?php echo base_url('assets/js/lightbox.js'); ?>"></script>

<script src="<?php echo base_url('assets/popup/bootstrap-modal.js') ?>"></script>
<script src="<?php echo base_url('assets/popup/bootstrap-transition.js') ?>"></script>

<script type="text/javascript" src="<?php echo base_url('assets/code/js/shCore.js'); ?>"></script>
<script type="text/javascript" src="<?php echo base_url('assets/code/js/shBrushJScript.js'); ?>"></script>     
<script type="text/javascript" src="<?php echo base_url('assets/code/js/shBrushSql.js'); ?>"></script>    
<script type="text/javascript" src="<?php echo base_url('assets/code/js/shBrushXml.js'); ?>"></script>
<script type="text/javascript" src="<?php echo base_url('assets/code/js/shBrushCss.js'); ?>"></script>     
<script type="text/javascript" src="<?php echo base_url('assets/code/js/shBrushPhp.js'); ?>"></script>    
<link type="text/css" rel="stylesheet" href="<?php echo base_url('assets/code/css/shCore.css'); ?>"/>
<link type="text/css" rel="stylesheet" href="<?php echo base_url('assets/code/css/shThemeDefault.css'); ?>"/>
<script type="text/javascript">
        SyntaxHighlighter.config.clipboardSwf = '<?php echo base_url('assets/code/images/clipboard.swf') ?>';
        SyntaxHighlighter.all();
</script> 
<style>
.loadserver .textinput{
    width:205px;
	margin-top:-10px;
}
.syntaxhighlighter .toolbar{
    display: none;
}
.w_scroolbar_des{
    overflow: scroll;
}
.scrool_des{
    height: 100px;
    width: 250px;
}
</style>
<?php
    function hightlight($keyword,$value){
        if(isset($keyword)){
            $xhtml = str_replace($keyword,'<span class="hightlight">'.$keyword.'</span>',$value);
        }else{
            $xhtml = $value;
        }
        return $xhtml;
    }
    function cmsSort($name, $arrFilter , $col, $sort = 'DESC'){
        $order = $sort;
        if ($arrFilter ['col'] == $col) {
            $order = ($arrFilter ['order'] == $sort) ? "ASC" : 'DESC';
            $sortIcon = ($arrFilter ['order'] == "DESC") ? "arrow_down.png" : 'arrow_up.png';
            $sortIcon = base_url('assets/img/' . $sortIcon);
            $sortIcon = '<br><img src="' . $sortIcon . '" align="center"/>';
        }
        $lnkID = base_url()."?control=report&func=index&type=sort&col=$col&order=$order&page=".$arrFilter['page'];
        $title = ($order=='ASC')?'Tăng dần':'Giảm dần';
        $xhtml = '<a href="' . $lnkID . '" title="'.$title.'">' . $name . '</a>' . $sortIcon;
        return $xhtml;
    }
    
?>
<div class="loading_warning"></div>
<div id="content-t" style="min-height:500px; padding-top:10px">
    <form id="appForm" action="" method="post" name="appForm">
        <div class="filter">
            <select name="server_id">
                <option value="0">Chọn server</option>
                <?php
                    if(empty($slbServer) !== TRUE){
                        foreach($slbServer as $v){
                ?>
                <option value="<?php echo $v['server_id'];?>" <?php echo ($v['server_id']==$arrFilter['server_id'])?'selected="selected"':'';?>><?php echo $v['server_name'];?></option>
                <?php
                        }
                    }
                ?>
            </select>
            <input type="text" name="keyword" value="<?php echo $arrFilter['keyword'];?>" class="textinput" placeholder="moboid, mobo service id, transactionid, characterid, character name, serial card" title="moboid, mobo service id, transactionid, characterid, character name, serial card"/>
            <input type="text" name="date_from" placeholder="Ngày bắt đầu" value="<?php echo (!empty($arrFilter['date_from']))?$arrFilter['date_from']:date('d-m-Y G:i:s',  strtotime('-14 day'));?>"/>
            <input type="text" name="date_to" placeholder="Ngày kết thúc" value="<?php echo (!empty($arrFilter['date_to']))?$arrFilter['date_to']:date('d-m-Y G:i:s');?>"/>
            <select name="slbStatus">
                <option value="0" <?php echo ($arrFilter['slbStatus']=='0')?'selected="selected"':'';?>>Tất cả</option>
                <option value="1" <?php echo ($arrFilter['slbStatus']==1)?'selected="selected"':'';?>>Khởi tạo [0]</option>
                <option value="2" <?php echo ($arrFilter['slbStatus']==2)?'selected="selected"':'';?>>Thành công [1]</option>
            </select>
            <input type="button" onclick="onSubmitFormAjax('appForm','<?php echo base_url().'?control=payment_promo_dht&func=index&module=all&type=filter';?>')" value="Tìm" class="btn btn-primary"/>
        </div>
        <div class="wrapper_scroolbar">
            <div class="scroolbar">
            <table width="100%" border="0" class="table table-striped table-bordered table-condensed table-hover">
                <thead>
                    <tr>
                        <th align="center">Ngày thực hiện</th>
                        <th align="center">Mobo ID</th>
                        <th align="center">Mobo Service ID</th>
                        <th align="center">Transaction ID</th>
                        <th align="center">Character ID</th>
                        <th align="center">Character Name</th>
                        <th align="center">Server ID</th>     
                        <th align="center">Promo Item Mcoin</th>
                        <th align="center">Mcoin</th>
                        <th align="center">Promo Ruby</th>
                        <th align="center">Promo item description</th>
                        <th align="center">Status</th>
                        <th align="center">Cash to game trans_id</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        if(empty($listItems) !== TRUE){
                            foreach($listItems as $v){
                                $status ='';
                                switch ($v['status']){
                                    case 0:
                                       $status = 'Khởi tạo [0].';
                                       break;
                                    case 1:
                                       $status = '<span class="success">Giao dịch thành công [1].</span>';
                                       break;
                                }
                    ?>
                    <tr>
                        <td align="center" class="space_wrap"><?php echo date_format(date_create($v['date']),"d-m-Y G:i:s");?></td>
                        <td align="center"><?php echo hightlight($arrFilter['keyword'],$v['mobo_id']);?></td>
                        <td align="center"><?php echo hightlight($arrFilter['keyword'],$v['mobo_service_id']);?></td>
                        <td align="center"><?php echo hightlight($arrFilter['keyword'],$v['transaction_id']);?></td>
                        <td align="center"><?php echo hightlight($arrFilter['keyword'],$v['character_id']);?></td>
                        <td align="center"><?php echo hightlight($arrFilter['keyword'],$v['character_name']);?></td>
                        <td align="center"><?php echo $v['server_id'];?></td>
                        <td align="center"><?php echo $v['promo_item_mcoin']>0?number_format($v['promo_item_mcoin'],0):0;?></td>
                        <td align="center"><?php echo $v['mcoin']>0?number_format($v['mcoin'],0):0;?></td>
                        <td align="center"><?php echo ($v['promo_ruby']>0)?number_format($v['promo_ruby'],0):0;?></td>
                        <td align="center"><?php echo $v['promo_item_description'];?></td>
                        <td align="center"><?php echo $status;?></td>
                        <td align="center"><?php echo $v['cash_to_game_trans_id'];?></td>
                    </tr>
                    <?php
                            }
                        }else{
                    ?>
                    <tr>
                        <td colspan="11" class="emptydata">Dữ liệu không tìm thấy</td>
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
    });
    jQuery('input[name=keyword]').keypress(function(event) {
        if (event.keyCode == '13') {
            onSubmitFormAjax('appForm','<?php echo base_url().'?control=payment_promo&func=index&module=all&type=filter';?>');
            return false;
        }
        return true;
    });
	function onSubmitFormAjax(formName,url){
        var dateForm = $('input[name=date_from]').val();
        var dateTo = $('input[name=date_to]').val();
        $.ajax({
            url:baseUrl+'?control=payment_promo&func=getvalidate',
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
	