<link rel="stylesheet" href="<?php echo base_url('assets/datetime/css/style.css'); ?>"/>
<link rel="stylesheet" href="<?php echo base_url('assets/datetime/css/bootstrap.css'); ?>"/>
<div id="content-t" style="min-height: 500px; padding-top: 10px">
<style>
    #loading {
        width: 100%;
        height: 100%;
        top: 0px;
        left: 0px;
        position: fixed;
        display: block;
        z-index: 99;
    }
    #loading-image {
        position: absolute;
        top: 40%;
        left: 45%;
        z-index: 100;
    }

    label {
        width: auto !important;
        color: #f36926;
    }
    .form-group {
        float: left;
        width: 22%;
    }
    .form-group input {
        width: 70%;
    }
    .form-horizontal .form-group{
        margin-left: 0px;
        margin-right: 0px;
    }
    .form-horizontal .listItem .control-label{
        padding-right: 5px;
        width: 27% !important;
        color: green;
    }
    .form-horizontal .listItem .sublistItem .control-label{
        color: #f36926;
    }
    .form-horizontal .sublistItem{
        margin-left: 15px;
    }
    .remove_field,.remove_field_receive{
        cursor: pointer;
        color: green;
    }
    .input_fields .control-group{
        padding-top: 23px; padding-bottom: 0px;margin-left: 0px; padding-left: 0px;border: 1px solid #ccc; margin-top: 10px; margin-bottom: 10px;
    }
    .input_fields_wrap .control-group .form-group{
        padding-bottom: 0px; margin-bottom: 0px;
    }

    .input_fields_wrap .control-group .sublistItem .remove_sub{
        top:4px;
    }
    .loadContent{
        text-align: center;
        color: red;
    }
    .input_fields_wrap .control-group .sublistItem .remove_sub .remove_field{
        color: #f36926 !important;
    }
    .form-horizontal .control-label{
        text-align: center;
    }
    .form-group.remove{
        width: 10%;
        position: relative;
        top:6px;
    }
    .subItems{
        margin-left: 20px;
    }
    .titlesub{
        position: relative;
        top:-4px;
    }
	.messg{
		color:green;
		padding-bottom:5px;
	}
</style>
<script type="text/javascript">
    $(document).ready(function () {
        $('#comeback').on('click', function () {
            window.history.go(-1); return false;
        });
	});
</script>
    <!-- Content -->
    <div id="content">
        <!-- Content wrapper -->
        <div class="wrapper">
            <?php include APPPATH . 'views/game/moba/Events/top_event/tab.php'; ?>
            <div class="widget-name">
                <div class="clearboth"></div>
            </div>
            <!--END CONTROL ADD CHEST-->
            <div class="widget" id="viewport">
                <form id="frmSendChest" name="frmSendChest" action="" method="POST" autocomplete="off">
                    <div class="well form-horizontal">
						<?php
							if(isset($_POST['submit'])){
						?>
						<div class="messg"><?php echo $messg;?></div>
						<?php } ?>
                        <?php
                            $statusOn = 'checked';
                            $start = gmdate('d-m-Y G:i:s',time()+7*3600);
                            $end = gmdate('d-m-Y G:i:s',time()+7*3600);
                            if($_GET['serverid']>0){
                                $statusOn =  $items['status']==1 ? 'checked="checked"':'';
                                $statusOff =  $items['status']==0 ? 'checked="checked"':'';
                                if(!empty($items['startdate'])){
                                    $startdate = date_format(date_create($items['startdate']),"d-m-Y G:i:s");
                                }
                                if(!empty($items['enddate'])){
                                    $enddate = date_format(date_create($items['enddate']),"d-m-Y G:i:s");
                                }
                            }
                        ?>
						<?php
							if($_GET['func']=='add'){
						?>
						<div class="control-group">
                            <label class="control-label">Server:</label>
                            <div class="controls">
                                <input type="text" name="serverid" value="<?php echo $items['serverid'];?>"/>
                            </div>
                        </div>
						<?php
							}
						?>
                        <div class="control-group">
                            <label class="control-label">Bắt đầu sự kiện:</label>
                            <div class="controls">
                                <input type="text" class="datetime" name="startdate" value="<?php echo $startdate;?>"/>
                            </div>
                        </div>

                        <div class="control-group">
                            <label class="control-label">Kết thúc sự kiện:</label>
                            <div class="controls">
                                <input type="text" class="datetime" name="enddate" value="<?php echo $enddate;?>"/>
                            </div>
                        </div>

                        <div class="control-group">
                            <label class="control-label">Trạng thái:</label>
                            <div class="controls">
                                Enable:<input type="radio" name="status" id="status" value="1" <?php echo $statusOn;?>/>
                                &nbsp;&nbsp;
                                Disable:<input type="radio" name="status" id="status" value="0" <?php echo $statusOff;?>/>
                            </div>
                        </div>
                        <div class="control-group">
                            <div style="padding-left: 20%; text-align: left;">
                                <input type="submit" name="submit" class="btn btn-primary" value="Thực hiện"/>
                                <a class="btn btn-primary" href="<?php echo base_url().'?control='.$_GET['control'].'&func=index&view='.$_GET['view'];?>"><span>Quay lại</span></a>
                                <div style="display: inline-block">
                                    <span id="message" style="color: green"></span>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <!-- /content wrapper -->
    </div>
    <!-- /content -->
</div>
<script>
    $('.datetime').datetimepicker({
        dateFormat: 'dd-mm-yy',
        timeFormat: 'hh:mm:ss'//
    });
</script>