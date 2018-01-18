<link rel="stylesheet" href="<?php echo base_url('assets/datetime/css/style.css'); ?>"/>
<link rel="stylesheet" href="<?php echo base_url('assets/datetime/css/bootstrap.css'); ?>"/>
<!--<script src="<?php echo base_url('assets/js/chosen.jquery.js'); ?>" type="text/javascript"></script>
<link rel="stylesheet" href="<?php echo base_url('assets/css/chosen.css');?>">-->
<link rel="stylesheet" href="<?php echo base_url('assets/css/lightbox.css'); ?>"/>
<script src="<?php echo base_url('assets/js/lightbox.js'); ?>"></script>
<script type="text/javascript">
    function loadPage(area, url){
        $(area).load(url);
    }
</script>
<style>
    .success_signios{
        color: green;
        text-align: center;
        font-size: 20px;
    }
    .unsuccess_signios{
        color: red;
        text-align: center;
        font-size: 20px;
    }
	.main-bar{
	display:none;
	}
</style>
<!--<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js" type="text/javascript" type="text/javascript"></script>
<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/prettyPhotos/prettyPhoto.css'); ?>" media="screen" title="prettyPhoto main stylesheet" charset="utf-8" />
<script type="text/javascript" src="<?php echo base_url('assets/css/prettyPhotos/jquery.prettyPhoto.js'); ?>"></script>
<script type="text/javascript" charset="utf-8">
			 $(document).ready(function(){
                $("a[rel^='prettyPhoto']").prettyPhoto({
                	allow_resize: false
                    });                
            });
$("a[rel^='prettyPhoto3']").prettyPhoto({animationSpeed:'fast',slideshow:10000});
$("a[rel^='prettyPhoto2']").prettyPhoto({animationSpeed:'fast',slideshow:10000});
</script>-->
<div class="loading_warning"></div>
<div id="content-t" style="min-height:500px; padding-top:10px">
    <form id="appForm" action="" method="post" name="appForm" enctype="multipart/form-data">
        <?php include_once 'include/toolbar.php'; ?>
        <div class="filter">
        	<input type="text" name="keyword" id="keyword" value="<?php echo $_POST['keyword'];?>" class="textinput" placeholder="Nhập mobo_service_id" title="Nhập mobo_service_id" maxlength="20" style="width:350px;"/>
            <input type="text" id="date_tracsac" name="date_tracsac" value="<?php echo $_POST['date_tracsac'];?>" class="datepicker" placeholder="Ngày giao dịch" >
			<input type="submit" name="btn_search" id="btn_search" value="Tìm" class="btnB btn-primary"/>  
        </div>
         
        <div class="wrapper_scroolbar" style="height:600px;">
            <div class="scroolbar" style="width:1500px;">
         <div style="float:left;margin-bottom:10px;" id="divpage">
         	<?php echo $pages?>
         </div>
        <table width="100%" border="0" class="table table-striped table-bordered table-condensed table-hover" id="tblsort">
            <thead>
                <tr>
                    <!--<th align="center" width="50px"><input type="checkbox" name="checkbox" onclick="checkedAll();"/></th>-->
               
                    <!-- <th align="center" width="120px">Game</th> -->
                    <th align="center" width="250px">Gói quà</th>
					<th align="center" width="250px">Số lượng quà</th>
					<th align="center" width="200px">Đơn vị</th>
					<th align="center" width="200px">Tiền tiêu phí</th>
                                        <th align="center" width="150px">Cup</th>
					<th align="center" width="150px">Ngày</th>
                    <th align="center" width="150px">Mobo_id</th>
                    <th align="center" width="150px">Mobo_service_id</th>
                    <th align="center" width="150px">Server_id</th>
                    <th align="center" width="150px">Character_id</th>
                    <th align="center" width="150px">Extmsi</th>
                    <th align="center" width="150px">Extcharacter_name</th>
                    <th align="center" width="150px">Subtract</th>
					<th align="center" width="150px">Log</th>
                    <th align="center" width="150px">Result</th>
                    
                </tr>
            </thead>
            <tbody>
                <?php
					$i=0;
                    if(empty($listItems) !== TRUE){
                        foreach($listItems as $i=>$v){
                ?>
                <tr id="rows_<?php echo $i?>" class="rows_class">
                    <!--<td><input type="checkbox" value="<?php echo $v['id'];?>" id="cid[<?php echo $v['id'];?>]" name="cid[]"></td>-->
                  
                    <!-- <td style="text-align:left" title="<?php echo $slbGame[$v['game_id']]['app_fullname'];?>"><?php echo $slbGame[$v['game_id']]['app_fullname'];?></td> -->
                    <td><strong style="color:#036" >
                    <a href="<?php echo base_url()?>?control=listpack&func=edit&id=<?php echo $v['pack_id'];?>"    target="_blank"><?php echo $getitem->getItem($v['pack_id'])['titles_pack'];?></a>
                    </strong></td>
					<td>
						<?php
							if(!empty($v['log_send_items'])){
								$item = json_decode($v['log_send_items'],true);
								echo count($item[0]['item']);
							}else{
								echo "0";
							}
						?>
					</td>
					<td>
						<?php
							switch($v['unit']){
								case "1":
									echo "Vàng";
									break;
								case "2":
									echo "Bạc";
									break;
                                                                case "3":
                                                                    echo "Vàng";
                                                                    break;
							}
						?>
					</td>
					<td><?php echo $v['money']>0?number_format($v['money'],0,',','.'):'0';?></td>
					<td><?php echo $v['cup'];?></td>
                                        <td><?php echo $v['create_date'];?></td>
                    <td><?php echo $v['mobo_id'];?></td>
                    <td><?php echo $v['mobo_service_id'];?></td>
                    <td><?php echo $v['server_id'];?></td>
                    <td><?php echo $v['character_id'];?></td>
                    <td><?php echo $v['extmsi'];?></td>
                    <td><?php echo $v['extcharacter_name'];?></td>
                    <td><?php echo $v['substract'];?></td>
					<td><?php echo $v['log_send_items'];?></td>
                    <td><?php echo $v['result'];?></td>
                    
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
        	<?php echo $pages?>
          </div> <!--scroolbar-->
        </div><!-- wrapper_scroolbar -->
       
    </form>
    
</div>
<script language="javascript">
$(document).ready(function() {
			
	$('input[name=date_tracsac]').datetimepicker({
		dateFormat: 'yy-mm-dd',
		timeFormat: ''//
	});

});
var config = {
      '.chosen-select'           : {},
      '.chosen-select-deselect'  : {allow_single_deselect:true},
      '.chosen-select-no-single' : {disable_search_threshold:10},
      '.chosen-select-no-results': {no_results_text:'Oops, nothing found!'},
      '.chosen-select-width'     : {width:"95%"}
    }
    for (var selector in config) {
      $(selector).chosen(config[selector]);
    }
function show_content_log(id){
	var _t = $('#dv_content_' + id).css('display');
	if(_t=='none'){
		$('#dv_content_' + id).css('display','block');
	}else{
		$('#dv_content_' + id).css('display','none');
	}
}
</script>