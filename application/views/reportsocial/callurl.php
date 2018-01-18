<style>
    .txtUrl{
        width: 85%;
        height: 100px;
    }
    .rowsbtn{
        margin-top: 20px;
    }
    .table-condensed{
        margin-top: 20px;
    }
</style>
<script src="<?php echo base_url('assets/shbrush/js/shCore.js'); ?>" type="text/javascript"></script>   
<link rel="stylesheet" href="<?php echo base_url('assets/datetime/css/style.css'); ?>"/>
<link rel="stylesheet" href="<?php echo base_url('assets/datetime/css/bootstrap.css'); ?>"/>
<div id="content-t" style="min-height:500px; padding-top:10px; padding-bottom: 10px;">
    <form action="" method="post" class="form-horizontal" name="frmadd">
        <div class="form-group">
            <label class="col-sm-2 control-label" for="txtbox1">Url</label>
            <div class="col-sm-10">
                <textarea class="txtUrl" name="txtUrl"><?php echo $_POST['txtUrl'];?></textarea>
            </div>
        </div>
        <div class="clr"></div>
		<div class="rows rowsbtn" align="center">
            <?php
                if((@in_array($_GET['control'].'-filter_callurl', $_SESSION['permission']) && $_SESSION['account']['id_group']==2)|| $_SESSION['account']['id_group']==1){
            ?>
            <input type='submit' onclick='if(!window.confirm("Bạn có muốn thực hiện gọi url không ?")) return false;' id='save' value='Thực hiện' class='btnB btn-primary' />
            <?php
                }else{
            ?>
            <input type='button' onclick='alert("Bạn không có quyền truy cập chức năng này !")' id='save' value='Thực hiện' class='btnB btn-primary' />
            <?php } ?>
        </div>
        
    </form>
    <div class="wrapper_scroolbar">
            <div class="scroolbar">
    <table class="table table-striped table-bordered table-condensed table-hover" width="100%" border="0">
        <thead>
            <th align="center" width="100px">Url</th>
            <th align="center" width="100px">Kết quả</th>
        </thead>
        <tbody>
            <?php
                if(count($listData)>0){
                    foreach($listData as $v){
            ?>
            <tr>
                <td><?php echo trim($v['url']);?></td>
                <td style="width: 400px !important;"><?php echo trim($v['result']);?></td>
            </tr>
            <?php
                    }
                }
            ?>
        </tbody>
    </table>
            </div></div>
</div>