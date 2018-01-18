<link rel="stylesheet" href="<?php echo base_url('assets/datetime/css/style.css');?>"/>
<link rel="stylesheet" href="<?php echo base_url('assets/datetime/css/bootstrap.css'); ?>"/>
<script src="<?php echo base_url('assets/js/chosen.jquery.js'); ?>" type="text/javascript"></script>                 
<link rel="stylesheet" href="<?php echo base_url('assets/css/chosen.css');?>">
<div id="content-t" class="content_form" style="min-height:500px; padding-top:10px">
    <form id="appForm" action="" method="post" name="appForm">
        <?php include_once 'include/toolbar.php'; ?>
        <div id="adminfieldset">
            <div class="adminheader">Nhập thông tin</div>
            <div class="group_left">
                <div class="rows">	
                    <label for="menu_group_id">Tên chức năng</label>
                    <input type="text" name="name" class="textinput" value="<?php echo $items['name'];?>"/>
                    <?php echo $errors['name'];?>
                </div>
                <div class="rows">	
                    <label for="menu_group_id">Cấp danh mục</label>
                    <?php 
                        $var = array('id'=>0,'name'=>'Chọn chức năng','level'=>1);
                        array_unshift($slbParents, $var);
                        echo cmsSelect('parents',$items['parents'],array('style'=>'width:250px','class'=>'chosen-select','tabindex'=>'2','data-placeholder'=>'Chọn danh mục','onchange'=>'visibleParents(this.value)'),$slbParents);
                    ?>
                    <script type="text/javascript">
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
                  </script>
                </div>
                <div class="rows type_option">	
                    <label for="menu_group_id">Loại</label>
                    <select name="id_type" class="id_type" onchange="gameOption(this.value)">
                        <option value="0" <?php echo ($items['id_type']==0)?'selected="selected"':''; ?>>Chức năng chính</option>
                        <option value="1" <?php echo ($items['id_type']==1)?'selected="selected"':''; ?>>Dữ liệu game</option>
                        <option value="2" <?php echo ($items['id_type']==2)?'selected="selected"':''; ?>>Mật định</option>
                        <option value="3" <?php echo ($items['id_type']==3)?'selected="selected"':''; ?>>Phân quyền Param</option>
                    </select>
                </div>
                <?php
                    if($_GET['func']=='edit'){
                ?>
                <div class="rows">	
                    <label for="menu_group_id">Sắp xếp</label>
                    <input type="text" name="order" class="textinput" value="<?php echo $items['order'];?>"/>
                </div>
                <?php } ?>
            </div>
            <div class="group_right">
                <div class="rows">	
                    <label for="menu_group_id">Controller</label>
                    <input type="text" name="controller" class="textinput" value="<?php echo $items['controller'];?>"/>
                    <?php echo $errors['controller'];?>
                </div>
                <div class="rows">	
                    <label for="menu_group_id">Action</label>
                    <input type="text" name="action" class="textinput" value="<?php echo $items['action'];?>"/>
                    <?php echo $errors['action'];?>
                </div>
                <div class="rows hideGame">	
                    <label for="menu_group_id">Data Game</label>
                    <input type="text" name="game" class="textinput" value="<?php echo $items['game'];?>"/>
                    <?php echo $errors['game'];?>
                </div>
                <div class="rows hideReport">	
                    <label for="menu_group_id">Game</label>
                    <input type="text" name="report_game" class="textinput" value="<?php echo $items['report_game'];?>"/>
                    <?php echo $errors['report_game'];?>
                </div>
				<div class="rows">	
                    <label for="menu_group_id">View</label>
                    <input type="text" name="layout" class="textinput" value="<?php echo $items['layout'];?>"/>
                </div>
				<div class="rows">	
                    <label for="menu_group_id">Module</label>
                    <input type="text" name="module" class="textinput" value="<?php echo $items['module'];?>"/>
                </div>
				<div class="rows">	
                    <label for="menu_group_id">List Game (Option Game)</label>
                    <input type="radio" name="per_game" value="0" <?php echo ($items['per_game']==0)?'checked="checked"':'';?>/> Tắt 
                    <input type="radio" name="per_game" value="1" <?php echo ($items['per_game']==1)?'checked="checked"':'';?>/> Bật
                </div>
            </div>
            <div class="clr"></div>
        </div>
    </form>
</div>
<script>
    <?php 
        if($items['parents']==0){
    ?>
        //$(".hideParents").hide();
        $(".type_option").hide();
        $(".hideGame").hide();
    <?php }elseif($items['parents']>0 && $items['id_type']!=1){?>
        //$(".hideParents").show();
        $(".type_option").show();
        $(".hideGame").hide();
    <?php }elseif($items['parents']>0 && $items['id_type']==1){?>
        //$(".hideParents").hide();
        $(".type_option").show();
        $(".hideGame").show();
    <?php } ?>
    function visibleParents(parent){
        var id_type = $(".id_type").val();
        if(parent>0 && id_type !=1){
            //$(".hideParents").show();
            $(".type_option").show();
            $(".hideFilter").hide();
        }else if(parent>0 && id_type ==1){
            //$(".hideParents").hide();
            $(".type_option").show();
            $(".hideGame").show();
        }else if(parent==0){
            //$(".hideParents").hide();
            $(".type_option").hide();
            $(".hideGame").hide();
        }
    }
    <?php
        if($items['id_type']==1){
    ?>
      $(".hideGame").show();
	  $(".hideReport").hide();
    <?php
        }elseif($items['id_type']==3){
    ?>
      $(".hideReport").show();
    <?php }else{ ?>
      $(".hideGame").hide();
      $(".hideReport").hide();
    <?php } ?>
    function gameOption(id){
        if(id==1){
            $(".hideGame").show();
            //$(".hideParents").hide();
            $(".hideReport").hide();
        }else{
            if(id==3){
                $(".hideReport").show();
                //$(".hideParents").show();
            }else{
                $(".hideGame").hide();
                $(".hideReport").hide();
                //$(".hideParents").show();
            }
        }
    }
</script>