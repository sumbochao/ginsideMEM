<style>
    .ui_tpicker_time_label{
        display: none;
    }
</style>
<script src="<?php echo base_url('assets/datetime/js/jquery-1.11.1.min.js') ?>"></script>
<link rel="stylesheet" href="<?php echo base_url('assets/datetime/css/style.css'); ?>"/>
<link rel="stylesheet" href="<?php echo base_url('assets/datetime/css/bootstrap.css'); ?>"/>
<script src="<?php echo base_url('assets/datetime/js/submit.js'); ?>"></script>

<link rel="stylesheet" href="<?php echo base_url('assets/css/lightbox.css'); ?>"/>
<script src="<?php echo base_url('assets/js/lightbox.js'); ?>"></script>

<script src="<?php echo base_url('assets/datetime/js/jquery-ui.min.js') ?>"></script>
<script src="<?php echo base_url('assets/datetime/js/jquery-ui-timepicker-addon.js') ?>"></script>
<link rel="stylesheet" href="<?php echo base_url('assets/datetime/css/jquery-ui.css') ?>"/>
<link rel="stylesheet" href="<?php echo base_url('assets/datetime/css/jquery-ui-timepicker-addon.css') ?>"/>

<div class="loading_warning"></div>
<div id="content-t" style="min-height:500px; padding-top:10px">
    <form id="appForm" action="" method="post" name="appForm">
        <div class="filter">
            <select name="slbDbGiftcode">
                <option value="service_mgh_mobo_vn" <?php echo ($arrFilter['slbDbGiftcode']=='service_mgh_mobo_vn')?'selected="selected"':'';?>>Service mgh_mobo_vn</option>
            </select>
            <input type="text" name="dategif" placeholder="Ngày" value="<?php echo (!empty($arrFilter['dategif']))?$arrFilter['dategif']:date('d-m-Y');?>"/>
            
			<?php
                if((@in_array($_GET['control'].'-filter_giftcode', $_SESSION['permission']) && $_SESSION['account']['id_group']==2)|| $_SESSION['account']['id_group']==1){
            ?>
            <input type="button" onclick="onSubmitForm('appForm','<?php echo base_url().'?control=report&func=giftcode&type=filter';?>')" value="Tìm" class="btnB btn-primary"/>
            <?php
                }else{
            ?>
            <input type="button" onclick='alert("Bạn không có quyền truy cập chức năng này !")' value="Tìm" class="btnB btn-primary"/>
            <?php
                }
            ?>
			
        </div>
        <div class="wrapper_scroolbar">
            <div class="scroolbar" style="width:1068px;">
            <table width="100%" border="0" class="table table-striped table-bordered table-condensed table-hover">
                <thead>
                    <tr>
                        <th align="center">Character ID</th>
                        <th align="center">Character Name</th>
                        <th align="center">Server ID</th>     
                        <th align="center">Type</th>
                        <th align="center">Date</th>
                        <th align="center">Quantity</th>
                    </tr>
                </thead>
                <tbody>
                    <?php //echo "<pre>";print_r($listItems);
                        if(empty($listItems) !== TRUE){
                            foreach($listItems as $v){
                    ?>
                    <tr>
                        <td align="center"><?php echo $v['character_id'];?></td>
                        <td align="center"><?php echo $v['character_name'];?></td>
                        <td align="center"><?php echo $v['server_id'];?></td>
                        <td align="center"><?php echo $v['type'];?></td>
                        <td align="center"><?php echo $v['date'];?></td>
                        <td align="center"><?php echo $v['soluong'];?></td>
                    </tr>
                    <?php
                            }
                        }else{
                    ?>
                    <tr>
                        <td colspan="6" class="emptydata">Dữ liệu không tìm thấy</td>
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
<div class="modalP fade load_popup"></div>
<script type="text/javascript">
    $('input[name=dategif]').datetimepicker({
        dateFormat: 'dd-mm-yy',
        timeFormat: ''
    });
</script>
	