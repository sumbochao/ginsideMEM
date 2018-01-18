<link rel="stylesheet" href="<?php echo base_url('assets/datetime/css/style.css');?>"/>
<link rel="stylesheet" href="<?php echo base_url('assets/datetime/css/bootstrap.css'); ?>"/>
<script src="<?php echo base_url('assets/js/chosen.jquery.js'); ?>" type="text/javascript"></script>                 
<link rel="stylesheet" href="<?php echo base_url('assets/css/chosen.css');?>">
<link rel="stylesheet" href="<?php echo base_url('assets/css/lightbox.css'); ?>"/>
<script src="<?php echo base_url('assets/js/lightbox.js'); ?>"></script>
<script type="text/javascript">
    function loadPage(area, url){
        $(area).load(url);
    }
	
</script>
<style>
.wrapper_scroolbar table tbody tr td{
	text-align:left !important;
	vertical-align:top;
}
</style>
<div class="loading_warning"></div>
 <div class="wrapper_scroolbar" style="font-size:12px;">
            <div class="scroolbar" style="width:1000px;">
<div id="content-t" class="content_form" style="min-height:0; padding-top:10px">
    <?php //include_once 'include/toolbar.php'; ?>
</div> <!--content_form-->
<?php
	if(count($listtemplate)>0){
		foreach($listtemplate as $t){
?>
 <div id="adminfieldset">
    <div class="adminheader">Check list: <strong><a href="javascript:void(0);" style="text-decoration:none;color:#390"><?php echo $t['template_name']; ?></a></strong></div>
    <form id="appFormRemove" action="<?php echo base_url();?>?control=<?php echo $_GET['control'];?>&func=removeuser&id_group=<?php echo intval($_GET['id_group']);?>" method="post" name="appFormRemove" enctype="multipart/form-data">
        <div class="rows">	
         <?php
						$this->db_slave = $this->load->database(array('db' => 'inside_info', 'type' => 'slave'), TRUE);
						 $sql="select * from  tbl_game_template_checklist where id_template=".$t['id']." and status=0";
						 $data=$this->db_slave->query($sql);
						 $r=$data->result_array();
						  if(count($r) > 0 && !empty($r)){
                        	foreach($r as $item){
								
                ?>
                <input type="checkbox" name="chk_game[<?php echo $item['id_game'];?>]" id="chk_game_<?php echo $item['id_game'];?>" value="<?php echo $item['id_game'];?>" style="margin-left:10px;" checked="checked" disabled="disabled" />
				<a href="<?php echo base_url();?>?control=gamechecklisttemp&func=index&id_game=<?php echo $item['id_game']; ?>&id_template=<?php echo $t['id']; ?>&module=all" target="_blank" style="color:#E81287;text-decoration:none;">Checklist - <?php echo $loadgame[$item['id_game']]['app_fullname']; ?></a>
                <?php
							
                        	}
							
						  }//end if
						  //mysql_free_result($data);
							
                ?>
        </div>
        <div class="rows">
        <label style="width:100%;margin-left:15px;">Click vào tên game để đánh check list.</label>
        </div>
    </form>
    <div class="clr"></div>
</div> <!--adminfieldset-->
<?php
		}
	}else{ echo "Không có dữ liệu."; }
?>
            
 </div> <!--scroolbar-->
</div> <!--wrapper_scroolbar-->
