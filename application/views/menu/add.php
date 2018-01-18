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
                    <label for="menu_group_id">Tên</label>
                    <input type="text" name="name" class="textinput" value="<?php echo $items['name'];?>"/>
                    <?php echo $errors['name'];?>
                </div>
                <div class="rows">	
                    <label for="menu_group_id">Url</label>
                    <input type="text" name="url" class="textinput" value="<?php echo $items['url'];?>"/>
                    <?php echo $errors['url'];?>
                </div>
                <div class="rows">	
                    <label for="menu_group_id">Cấp danh mục</label>
                    <?php 
                        $var = array('id'=>0,'name'=>'Chọn danh mục','level'=>1);
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
                <div class="rows">	
                    <label for="menu_group_id">Duyệt</label>
                    <input type="radio" name="status" value="0" <?php echo ($items['status']==0)?'checked="checked"':'';?>/> Tắt 
                    <input type="radio" name="status" value="1" <?php echo ($items['status']==1)?'checked="checked"':'';?>/> Bật
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
            <div class="clr"></div>
        </div>
    </form>
</div>