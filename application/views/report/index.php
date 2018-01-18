<script src="<?php echo base_url('assets/datetime/js/jquery-1.11.1.min.js') ?>"></script>
<link rel="stylesheet" href="<?php echo base_url('assets/datetime/css/style.css'); ?>"/>
<link rel="stylesheet" href="<?php echo base_url('assets/datetime/css/bootstrap.css'); ?>"/>
<script src="<?php echo base_url('assets/datetime/js/submit.js'); ?>"></script>
<script src="<?php echo base_url('assets/js/ajax.js'); ?>"></script>
<link rel="stylesheet" href="<?php echo base_url('assets/css/lightbox.css'); ?>"/>
<script src="<?php echo base_url('assets/js/lightbox.js'); ?>"></script>

<script src="<?php echo base_url('assets/datetime/js/jquery-ui.min.js') ?>"></script>
<script src="<?php echo base_url('assets/datetime/js/jquery-ui-timepicker-addon.js') ?>"></script>
<link rel="stylesheet" href="<?php echo base_url('assets/datetime/css/jquery-ui.css') ?>"/>
<link rel="stylesheet" href="<?php echo base_url('assets/datetime/css/jquery-ui-timepicker-addon.css') ?>"/>

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

<script src="<?php echo base_url('assets/popup/bootstrap-modal.js') ?>"></script>
<script src="<?php echo base_url('assets/popup/bootstrap-transition.js') ?>"></script>
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
div.coppi_data {
	position: relative;
}
.copied::after {
	position: absolute;
	top: 12%;
	right: 110%;
	display: block;
	content: "copied";
	font-size: 13px;
	padding: 5px 5px;
	color: #fff;
	background-color:#f0ad4e;
	border-radius: 3px;
	opacity: 0;
	will-change: opacity, transform;
	animation: showcopied 1.5s ease;
}
@keyframes showcopied {
	0% {
		opacity: 0;
		transform: translateX(100%);
	}
	70% {
		opacity: 1;
		transform: translateX(0);
	}
	100% {
		opacity: 0;
	}
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
		
			<select name="slbGame" onchange="getServerIndex(this.value)">
                <option value="" <?php echo ($arrFilter['slbGame']=='')?'selected="selected"':'';?>>Chọn game</option>
                <?php
                    if(empty($slbScopes) !== TRUE){
                        foreach($slbScopes as $v){
                            if((@in_array($v['app_name'], $_SESSION['permission']) && $_SESSION['account']['id_group']==2)|| $_SESSION['account']['id_group']==1){
                ?>
                <option value="<?php echo $v['app_name'].'-'.$v['type'];?>" <?php echo ($arrFilter['slbGame']==$v['app_name'])?'selected="selected"':'';?>><?php echo $v['app_fullname'];?></option>
                <?php
                            }
                        }
                    }
                ?>
            </select>
            
            <span class="loadserver">
                <select name="game_server_id">
                    <option value="">Chọn server</option>
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
            <input type="text" name="keyword" value="<?php echo $arrFilter['keyword'];?>" class="textinput" placeholder="moboid, mobo service id, transactionid, characterid, character name, serial card" title="moboid, mobo service id, transactionid, characterid, character name, serial card"/>
            <input type="text" name="date_from" placeholder="Ngày bắt đầu" value="<?php echo (!empty($arrFilter['date_from']))?$arrFilter['date_from']:date('d-m-Y G:i:s',  strtotime('-14 day'));?>"/>
            <input type="text" name="date_to" placeholder="Ngày kết thúc" value="<?php echo (!empty($arrFilter['date_to']))?$arrFilter['date_to']:date('d-m-Y G:i:s');?>"/>
            <select name="slbStatus">
                <option value="0" <?php echo ($arrFilter['slbStatus']=='0')?'selected="selected"':'';?>>Tất cả</option>
                <option value="1" <?php echo ($arrFilter['slbStatus']==1)?'selected="selected"':'';?>>Khởi tạo [0]</option>
                <option value="2" <?php echo ($arrFilter['slbStatus']==2)?'selected="selected"':'';?>>Thành công [1]</option>
                <option value="3" <?php echo ($arrFilter['slbStatus']==3)?'selected="selected"':'';?>>Thất bại [2]</option>
            </select>
            <select name="slbPlatform">
                <option value="">Chọn nền tảng</option>
                <option value="android" <?php echo ($arrFilter['slbPlatform']=='android')?'selected="selected"':'';?>>Android</option>
                <option value="ios" <?php echo ($arrFilter['slbPlatform']=='ios')?'selected="selected"':'';?>>Ios</option>
                <option value="wp" <?php echo ($arrFilter['slbPlatform']=='wp')?'selected="selected"':'';?>>Wp</option>
            </select>
            <select name="slbType">
                <option value="0">Chọn hình thức</option>
                <option value="bank" <?php echo ($arrFilter['slbType']=='bank')?'selected="selected"':'';?>>Bank</option>
                <option value="card" <?php echo ($arrFilter['slbType']=='card')?'selected="selected"':'';?>>Card</option>
                <option value="inapp" <?php echo ($arrFilter['slbType']=='inapp')?'selected="selected"':'';?>>Inapp</option>
                <option value="sms" <?php echo ($arrFilter['slbType']=='sms')?'selected="selected"':'';?>>Sms</option>
                <option value="mopay" <?php echo ($arrFilter['slbType']=='mopay')?'selected="selected"':'';?>>Mopay</option>
            </select>
			<?php
                if((@in_array($_GET['control'].'-filter_index', $_SESSION['permission']) && $_SESSION['account']['id_group']==2)|| $_SESSION['account']['id_group']==1){
            ?>
            <input type="button" onclick="onSubmitFormAjax('appForm','<?php echo base_url().'?control=report&func=index&type=filter';?>')" value="Tìm" class="btnB btn-primary"/>
            <?php
                }else{
            ?>
            <input type="button" onclick='alert("Bạn không có quyền truy cập chức năng này !")' value="Tìm" class="btn btn-primary"/>
            <?php
                }
            ?>
            
        </div>
        <div class="wrapper_scroolbar">
            <div class="scroolbar">
			<?php
				$type_post = explode("-",$_POST['slbGame']);
				if($arrFilter['type']=='local'){
			?>
            <table width="100%" border="0" class="table table-striped table-bordered table-condensed table-hover">
                <thead>
                    <tr>
                        <th align="center">Ngày thực hiện</th>
                        <th align="center">Ngày giao dịch</th>
                        <th align="center">Mobo ID</th>
                        <th align="center">Mobo Service ID</th>
                        <th align="center">Transaction ID</th>
                        <th align="center">Character ID</th>
                        <th align="center">Character Name</th>
                        <th align="center">Server ID</th>     
                        <th align="center">Type</th>
                        <th align="center">Amount</th>
                        <th align="center">Mcoin</th>
                        <th align="center">Money</th>
						<th align="center">Promotion Money</th>
						<th align="center">Total Money</th>
                        <th align="center">Platform</th>
                        <th align="center">Payment desc</th>
                        <th align="center">Channel</th>
                        <th align="center">Description</th>
                        <th align="center">Lịch sử recall</th>
                        <th align="center">Nạp lại?</th>
						<th align="center">Full request</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        if(empty($listItems) !== TRUE){
							$i=0;
                            foreach($listItems as $data){
								$i++;
								$v = (array)$data;
                                $status ='';
                                switch ($v['status']){
                                    case 0:
                                       $status = 'Khởi tạo [0].';
                                       break;
                                    case 1:
                                       $status = 'Giao dịch thành công [1].';
                                       break;
                                    case 2:
                                       $status = 'Giao dịch thất bại [2].';
                                       break;
                                }
                    ?>
                    <tr>
                        <td align="center" class="space_wrap"><?php echo gmdate('d-m-Y G:i:s',  strtotime($v['date'])+7*3600);?></td>
                        <td align="center" class="space_wrap">
                            <?php 
                                $arrBr = explode(" ", $v['time_stamp']);$dateArr = explode('-', $arrBr[0]);
                                echo $dateArr['2'].'-'.$dateArr['1'].'-'.$dateArr['0'].' '.$arrBr[1];
                            ?>
                        </td>
                        <td align="center"><?php echo hightlight($arrFilter['keyword'],$v['mobo_id']);?></td>
                        <td align="center"><?php echo hightlight($arrFilter['keyword'],$v['mobo_service_id']);?></td>
                        <td align="center"><?php echo hightlight($arrFilter['keyword'],$v['transaction_id']);?></td>
                        <td align="center"><?php echo hightlight($arrFilter['keyword'],$v['character_id']);?></td>
                        <td align="center"><?php echo hightlight($arrFilter['keyword'],$v['character_name']);?></td>
                        <td align="center"><?php echo $v['server_id'];?></td>
                        <td align="center"><?php echo $v['type'];?></td>
                        <td align="center"><?php echo $v['amount'];?></td>
                        <td align="center"><?php echo $v['mcoin'];?></td>
                        <td align="center"><?php echo $v['money'];?></td>
						<td align="center"><?php echo $v['promo_money'];?></td>
						<td align="center"><b><?php echo $v['money']+$v['promo_money'];?></b></td>
                        <td align="center"><?php echo $v['platform'];?></td>
                        <td align="center"><?php echo $v['payment_desc'];?></td>
                        <td align="center"><?php echo $v['channel'];?></td>
                        <td align="center">
                            <div class="w_scroolbar_des">
                            <div class="scrool_des">
                            <script class="brush: php" type="syntaxhighlighter">
                                <?php echo $v['description'];?>
                            </script>
                                </div>
                            </div>
                        </td>
                        <td align="center">
                            <?php 
                                if((int)$v['recall'] > 1){
							?>
                                    <div class="viewhistory" onclick="viewHistory('<?php echo $v['transaction_id'];?>')">Xem lịch sử [<?php echo $v['recall'];?> lần]</div>
                            <?php
								}
                            ?>
                        </td>
                        <td align="center">
                            <?php
                                if($v['status'] !=1){
                            ?>
                            <a type="button" title="<?php echo $status;?>" class="btnB <?php echo ($v['status']==1)?'btn-success':'btn-danger';?> btnB_<?php echo $v['id'];?>" onclick="fullRequest('<?php echo $v['full_request'];?>','?control=report&func=ajaxrequest','<?php echo $v['id'];?>','<?php echo $v['status'];?>')">Nạp lại</a>
                            <?php
                                }
                            ?>
                            <?php echo ($v['status'] ==1)?'<span class="success">Thành công</span>':'';?>
                        </td>
                        <td>
                                <input type="text" id="a<?php echo $i.$v['mobo_service_id'];?>" value="<?php echo $v['full_request'];?>"/>
                                <div class="btn btn-primary coppi_data" data-copytarget="#a<?php echo $i.$v['mobo_service_id'];?>">Copy</div>
                        </td>
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
			<?php
				}else{//global
			?>
			<table width="100%" border="0" class="table table-striped table-bordered table-condensed table-hover">
                <thead>
                    <tr>
                        <th align="center">Ngày thực hiện</th>
                        <th align="center">Ngày giao dịch</th>
                        <th align="center">Account ID</th>
                        <th align="center">Transaction ID</th>
                        <th align="center">Character ID</th>
                        <th align="center">Character Name</th>
                        <th align="center">Server ID</th>     
                        <th align="center">Type</th>
                        <th align="center">Amount</th>
                        <th align="center">Mcoin</th>
                        <th align="center">Money</th>
						<th align="center">Latency</th>
						<th align="center">Promotion Money</th>
						<th align="center">Total Money</th>
                        <th align="center">Platform</th>
                        <th align="center">Payment desc</th>
                        <th align="center">Channel</th>
                        <th align="center">Description</th>
                        <th align="center">Lịch sử recall</th>
                        <th align="center">Nạp lại?</th>
						<th align="center">Full request</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        if(empty($listItems) !== TRUE){
							$i=0;
                            foreach($listItems as $data){
								$i++;
								$v = (array)$data;
                                $status ='';
                                switch ($v['status']){
                                    case 0:
                                       $status = 'Khởi tạo [0].';
                                       break;
                                    case 1:
                                       $status = 'Giao dịch thành công [1].';
                                       break;
                                    case 2:
                                       $status = 'Giao dịch thất bại [2].';
                                       break;
                                }
                    ?>
                    <tr>
                        <td align="center" class="space_wrap"><?php echo gmdate('d-m-Y G:i:s',  strtotime($v['date'])+7*3600);?></td>
                        <td align="center" class="space_wrap">
                            <?php 
                                $arrBr = explode(" ", $v['time_stamp']);$dateArr = explode('-', $arrBr[0]);
                                echo $dateArr['2'].'-'.$dateArr['1'].'-'.$dateArr['0'].' '.$arrBr[1];
                            ?>
                        </td>
                        <td align="center"><?php echo hightlight($arrFilter['keyword'],$v['account_id']);?></td>
                        <td align="center"><?php echo hightlight($arrFilter['keyword'],$v['transaction_id']);?></td>
                        <td align="center"><?php echo hightlight($arrFilter['keyword'],$v['character_id']);?></td>
                        <td align="center"><?php echo hightlight($arrFilter['keyword'],$v['character_name']);?></td>
                        <td align="center"><?php echo $v['server_id'];?></td>
                        <td align="center"><?php echo $v['type'];?></td>
                        <td align="center"><?php echo $v['amount'];?></td>
                        <td align="center"><?php echo $v['mcoin'];?></td>
                        <td align="center"><?php echo $v['money'];?></td>
						<td align="center"><?php echo $v['latency'];?></td>
						<td align="center"><?php echo $v['promo_money'];?></td>
						<td align="center"><b><?php echo $v['money']+$v['promo_money'];?></b></td>
                        <td align="center"><?php echo $v['platform'];?></td>
                        <td align="center"><?php echo $v['payment_desc'];?></td>
                        <td align="center"><?php echo $v['channel'];?></td>
                        <td align="center">
                            <div class="w_scroolbar_des">
                            <div class="scrool_des">
                            <script class="brush: php" type="syntaxhighlighter">
                                <?php echo $v['description'];?>
                            </script>
                                </div>
                            </div>
                        </td>
                        <td align="center">
                            <?php 
                                if((int)$v['recall'] > 1){
							?>
                                    <div class="viewhistory" onclick="viewHistory('<?php echo $v['transaction_id'];?>')">Xem lịch sử [<?php echo $v['recall'];?> lần]</div>
                            <?php
								}
                            ?>
                        </td>
                        <td align="center">
                            <?php
                                if($v['status'] !=1){
                            ?>
                            <a type="button" title="<?php echo $status;?>" class="btnB <?php echo ($v['status']==1)?'btn-success':'btn-danger';?> btnB_<?php echo $v['id'];?>" onclick="fullRequest('<?php echo $v['full_request'];?>','?control=report&func=ajaxrequest','<?php echo $v['id'];?>','<?php echo $v['status'];?>')">Nạp lại</a>
                            <?php
                                }
                            ?>
                            <?php echo ($v['status'] ==1)?'<span class="success">Thành công</span>':'';?>
                        </td>
						<td>
							<input type="text" id="a<?php echo $i.$v['mobo_service_id'];?>" value="<?php echo $v['full_request'];?>"/>
							<div class="btn btn-primary coppi_data" data-copytarget="#a<?php echo $i.$v['mobo_service_id'];?>">Copy</div>
						</td>
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
			<?php
				}
			?>
            </div>
        </div>
        <?php echo $pages?>
    </form>
</div>
<script>
	(function () {
		'use strict';
		// click events
		document.body.addEventListener('click', copy, true);
		// event handler
		function copy(e) {
			// find target element
			var
				t = e.target,
				c = t.dataset.copytarget,
				inp = (c ? document.querySelector(c) : null);
			// is element selectable?
			if (inp && inp.select) {
				// select text
				inp.select();
				try {
					// copy text
					document.execCommand('copy');
					inp.blur();
					// copied animation
					t.classList.add('copied');
					setTimeout(function () {
						t.classList.remove('copied');
					}, 1500);
				}
				catch (err) {
					alert('please press Ctrl/Cmd+C to copy');
				}
			}
		}
	})();
</script>
<script type="text/javascript">
	function getServerIndex(game){
		var url =baseUrl +'?control=report&func=getserver';
		jQuery.ajax({
			url:url,
			type:"POST",
			data:{game:game},
			async:false,
			dataType:"json",
			success:function(f){
				if(f.status==0){
					jQuery('.loadserver').html(f.html);
				}else{
					jQuery('.loadserver').html(f.html);
				}
			}
		});
	}
    $('input[name=date_from]').datetimepicker({
        dateFormat: 'dd-mm-yy',
        timeFormat: 'HH:mm:ss'
    });
    $('input[name=date_to]').datetimepicker({
        dateFormat: 'dd-mm-yy',
        timeFormat: 'HH:mm:ss',
        /*onSelect: function(date){
            var date2 = $('input[name=date_to]').datetimepicker('getDate');
            date2.setDate(date2.getDate()+1);
            $('input[name=date_to]').datetimepicker('setDate', date2);
        }*/
    });
	jQuery('input[name=keyword]').keypress(function(event) {
        if (event.keyCode == '13') {
			<?php
				if((@in_array($_GET['control'].'-filter_index', $_SESSION['permission']) && $_SESSION['account']['id_group']==2)|| $_SESSION['account']['id_group']==1){
			?>
			onSubmitFormAjax('appForm','<?php echo base_url().'?control=report&func=index&type=filter';?>');
			<?php
				}else{
			?>
			alert('Bạn không có quyền truy cập chức năng này !');
			<?php } ?>
			return false;
        }
        return true;
    });
	function onSubmitFormAjax(formName,url){
        var dateForm = $('input[name=date_from]').val();
        var dateTo = $('input[name=date_to]').val();
        $.ajax({
            url:baseUrl+'?control=report&func=getvalidate',
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
	