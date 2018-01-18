<link rel="stylesheet" href="<?php echo base_url('assets/datetime/css/style.css');?>"/>
<link rel="stylesheet" href="<?php echo base_url('assets/datetime/css/bootstrap.css'); ?>"/>
<script src="<?php echo base_url('assets/js/chosen.jquery.js'); ?>" type="text/javascript"></script>                 
<link rel="stylesheet" href="<?php echo base_url('assets/css/chosen.css');?>">
<!-- ck editor -->
<script src="<?php echo base_url('assets/ckeditor/ckeditor.js'); ?>" type="text/javascript"></script>
<script src="<?php echo base_url('assets/ckfinder/ckfinder.js'); ?>" type="text/javascript"></script>
<script type="text/javascript">
    function loadPage(area, url){
        $(area).load(url);
    }
</script>
<style>
.rows{
	width:1000px;
}
.group_left{
	width:100%;
}
.lbl{
	display:inline;
}
</style>
<div id="content-t" class="content_form" style="min-height:500px; padding-top:10px">
    <form id="appForm" action="" method="post" name="appForm" enctype="multipart/form-data">
        <?php include_once 'include/toolbar.php'; ?>
        <div id="adminfieldset">
            <div class="adminheader">Nhập thông tin</div>
            <div class="group_left">
            	<div class="option_error">
                       <strong style="color:#F00"><?php echo $errors;?></strong>
                </div>
            	<div class="rows">	
                    <label for="menu_group_id">Chọn hạng mục</label>
                    <select name="cbo_categories" id="cbo_categories">
                        <option value="0"> -- Hạng Mục -- </option>
                        <?php
						if (!$this->db_slave)
		$this->db_slave = $this->load->database(array('db' => 'inside_info', 'type' => 'slave'), TRUE);
                            if(count($categories)>0){
                                foreach($categories as $v){
									$this->db_slave->select(array('*'));
									$this->db_slave->from('tbl_categories');
									$this->db_slave->where('id_parrent', $v['id']);
									$this->db_slave->order_by('order','ASC');
									$this->db_slave->order_by('id','DESC');
									$cate_child = $this->db_slave->get();
									 if (is_object($cate_child)) {
											$child = $cate_child->result_array();
										}
                        ?>
                        <optgroup label="<?php echo $v['names'];?>">
                        <?php
									foreach($child as $items){
							?>
                           <option value="<?php echo $items['id'];?>" <?php echo $item['id_categories']==$items['id']?"selected":"";?>><?php echo $items['names'];?></option>
                            <?php } ?>
                        </optgroup>
                        
                        <?php
                                }
                            }
                        ?>
                    </select>
                </div>
               <!-- <div class="rows">	
                    <label for="menu_group_id">Platform</label>
                    <select name="cbo_platform" id="cbo_platform">
                        <option value="0">Chọn Platform</option>
                        <?php
                            if(count($loadplatform)>0){
                                foreach($loadplatform as $key=>$value){
                        ?>
                        <option value="<?php echo $value;?>"><?php echo $value;?></option>
                        <?php
                                }
                            }
                        ?>
                    </select>
                    
                </div>-->
                <div class="rows">	
                    <label for="menu_group_id">Tên yêu cầu</label>
                    <!--<input type="text" name="titles" id="titles" class="textinput" style="width:500px;" value="<?php echo $item['titles'] ?>"/>-->
                    <textarea name="titles" id="titles" cols="30" rows="5" style="width:500px;height:100px;resize:none;"><?php echo $item['titles'] ?></textarea>
                </div>
                 <div class="rows">	
                    <label for="menu_group_id">Loại yêu cầu</label>
                    <input type="checkbox" name="chk_ios" id="chk_ios" value="true" <?php echo $item['ios']=="true"?"checked":"";?> /><label class="lbl" for="chk_ios" style="color:#333;width:25px;margin:0;">IOS</label>
                    <input type="checkbox" name="chk_android" id="chk_android" value="true" <?php echo $item['android']=="true"?"checked":"";?> /><label class="lbl" for="chk_android" style="color:#333;width:25px;margin:0;">Android</label>
                    <input type="checkbox" name="chk_wp" id="chk_wp" value="true" <?php echo $item['wp']=="true"?"checked":"";?> /><label class="lbl" for="chk_wp" style="color:#333;width:25px;margin:0;">WinPhone</label>
                    <input type="checkbox" name="chk_event" id="chk_event" value="true" <?php echo $item['events']=="true"?"checked":"";?> /><label class="lbl" for="chk_event" style="color:#333;width:25px;margin:0;">Event</label>
                    <input type="checkbox" name="chk_pc" id="chk_pc" value="true" <?php echo $item['pc']=="true"?"checked":"";?> /><label class="lbl" for="chk_pc" style="color:#333;width:35px;margin:0;">PC Platform</label>
                    <input type="checkbox" name="chk_system" id="chk_system" value="true" <?php echo $item['systems']=="true"?"checked":"";?> /><label class="lbl" for="chk_system" style="color:#333;width:25px;margin:0;">System</label>
                    <input type="checkbox" name="chk_web" id="chk_web" value="true" <?php echo $item['web']=="true"?"checked":"";?> /><label class="lbl" for="chk_web" style="color:#333;width:25px;margin:0;">Config</label>
                    <input type="checkbox" name="chk_orther" id="chk_orther" value="true" <?php echo $item['orther']=="true"?"checked":"";?> /><label class="lbl" for="chk_orther" style="color:#333;width:25px;margin:0;">Other</label>
                </div>
                <div class="rows">	
                    <label for="menu_group_id">Kết quả mong muốn</label>
                    <textarea name="admin_request" id="admin_request" cols="30" rows="5" style="width:500px;height:100px;resize:none;"><?php echo $item['admin_request'] ?></textarea>
                </div>
				<div class="rows">	
                    <label for="menu_group_id">Sắp xếp</label>
                    <input type="text" name="sort" id="sort" class="textinput" style="width:500px;" value="<?php echo $item['sort']; ?>"/>
                </div>
                <div id="adminfieldset" style="padding-bottom:100px;padding-left:30px;">
            <div class="adminheader">Group thực hiện chính</div>
            <div class="group_left" style="width:100% !important;">
            	 <div class="rows">
            	<?php
				
                            if(count($groupActive)>0){
                                foreach($groupActive as $v){
									
                        ?>
                        <input type="checkbox" name="chk_group_actice[<?php echo $v['id_group'];?>]" id="chk_group_actice_<?php echo $v['id_group'];?>" value="<?php echo $v['id_group'];?>" checked="checked" onchange="calljavascript(2,<?php echo $v['id_group'];?>)" /><label class="lbl" for="chk_group_actice_<?php echo $v['id_group'];?>" style="color:#333;margin:0;"><?php echo $v['names'];?></label>
                    <?php
									
								} //end for
							}//end if
					?>
                    </div> <!--rows-->
                     <div class="rows">
            	<?php
				
                            if(count($groupNotActive)>0){
                                foreach($groupNotActive as $v){
									if($v['id'] != -1){
									
                        ?>
                        <input type="checkbox" name="chk_group[<?php echo $v['id'];?>]" id="chk_group_<?php echo $v['id'];?>" value="<?php echo $v['id'];?>" /><label class="lbl" for="chk_group_<?php echo $v['id'];?>" style="color:#333;margin:0;"><?php echo $v['names'];?></label>
					<?php
									}//end if
									
								} //end for
							}//end if
					?>
                    </div> <!--rows-->
                    
            </div> <!--group_left-->
            
       </div> <!--adminfieldset-->
       
       <div id="adminfieldset" style="padding-bottom:100px;padding-left:30px;">
            <div class="adminheader">Group hỗ trợ</div>
            <div class="group_left" style="width:100% !important;">
            	 <div class="rows">
            	<?php
				
                            if(count($groupActiveSupport)>0){
                                foreach($groupActiveSupport as $v){
									
                        ?>
                        <input type="checkbox" name="chk_group_actice_support[<?php echo $v['id_group'];?>]" id="chk_group_actice_support_<?php echo $v['id_group'];?>" value="<?php echo $v['id_group'];?>" checked="checked" onchange="calljavascript(2,<?php echo $v['id_group'];?>)" /><label class="lbl" for="chk_group_actice_support_<?php echo $v['id_group'];?>" style="color:#333;margin:0;"><?php echo $v['names'];?></label>
                    <?php
									
								} //end for
							}//end if
					?>
                    </div> <!--rows-->
                     <div class="rows">
            	<?php
				
                            if(count($groupNotActiveSupport)>0){
                                foreach($groupNotActiveSupport as $v){
									if($v['id'] != -1){
									
                        ?>
                        <input type="checkbox" name="chk_group_support[<?php echo $v['id'];?>]" id="chk_group_support_<?php echo $v['id'];?>" value="<?php echo $v['id'];?>" /><label class="lbl" for="chk_group_support_<?php echo $v['id'];?>" style="color:#333;margin:0;"><?php echo $v['names'];?></label>
                    <?php
									}//end if
								} //end for
							}//end if
					?>
                    </div> <!--rows-->
                    
            </div> <!--group_left-->
            
       </div> <!--adminfieldset-->
                <div class="rows">	
                    <label for="menu_group_id">Ghi chú</label>
                    <!--<textarea name="notes" id="notes" id="notes" cols="30" rows="5" style="width:500px;height:150px;resize:none;"><?php echo stripslashes($item['notes']) ?></textarea>-->
                     <?php echo $this->CKEditor->editor("notes",$item['notes']); ?>
          
                </div>
				
                
            </div>
          
            <div class="clr"></div>
        </div>
        
        
    </form>
</div>
<script src="<?php echo base_url('assets/js/gamechecklist/js_gamechecklist_request.js'); ?>" type="text/javascript"></script>
<script type="text/javascript" language="javascript">
function calljavascript(i,id){
		switch(i){
			 case 1: //save
			 		checkemptyrequest();
			 break;
			 case 2: // deleted group
			 		
			 break;
			 default:
			 break;
		} //end switch
		
}
</script>