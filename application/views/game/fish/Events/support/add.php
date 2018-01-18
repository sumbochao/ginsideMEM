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

</style>
<script type="text/javascript">
    $(document).ready(function() {
        $('#onCheck').on('click',function(){
            checkPercentTotal();
        });
        $('#onSubmit').on('click',function(){
            if( $('#frmSendChest').validationEngine('validate') === false)
                return false;

            $.ajax({
                type: "POST",
                dataType: 'jsonp',
                url: "<?php echo $url; ?>/update/",
                data: $("#frmSendChest").serializeArray(),
                beforeSend: function(  ) {
                    // load your loading fiel here
                    $('#messagelog').attr("style","color:green");
                    $('#messagelog').html('Đang xử lý...');
                    //disable button
                    $('#searchuid').attr("disabled","disabled");
                }
            }).done(function(result) {
                console.log(result);
                //hide your loading file here
                if (result.status == false)
                    $('#messagelog').attr("style","color:red");

                $('#messagelog').html(result.message);
                //enable button
                $('#searchuid').removeAttr('disabled');

            });
        });

    });

</script>

<!-- Content -->
<div id="content">
    <!-- Content wrapper -->
    <div class="wrapper">
        <?php include APPPATH . 'views/game/fish/Events/support/tab.php'; ?>
        <div class="widget-name">

            <!-- <div class="tabs">
               <a href="/cms/ep/promotion_lato/thongke"><i class=" ico-th-large"></i>TH?NG K�</a>
               <a href="/cms/ep/promotion_lato/tralogdoiqua"><i class=" ico-th-large"></i>TRA LOG �?I QU�</a>
               <a href="javascript:void(0);" class="clearcached"><i class=" ico-th-large"></i>CLEAR MENCACHED</a>
            </div>-->
            <div class="clearboth"></div>
        </div>

        <!--END CONTROL ADD CHEST-->
        
        <div class="widget" id="viewport">
            <div class="well form-horizontal">
                <form id="frmSendChest" name="frmSendChest" action="" method="POST" onsubmit="return false;" autocomplete="off">
                    <div class="widget row-fluid">
                        <div class="well form-horizontal">


                           <div class="control-group">
                                <label class="control-label">Name:</label>
                                <div class="controls">
                                    <input name="email" id="email" type="text" value="<?php echo $infodetail['email'];?>" class="span3 validate[required]" readonly />
                                </div>
                            </div>
							<div class="control-group">
                                <label class="control-label">QuestionType:</label>
                                <div class="controls">
                                    <input name="desc" id="desc" type="text" value="<?php echo $infodetail['desc'];?>" class="span3 validate[required]" readonly/>
                                </div>
                            </div>
							<div class="control-group">
                                <label class="control-label">MoboID:</label>
                                <div class="controls">
                                    <input name="mobo_id" id="mobo_id" type="text" value="<?php echo $infodetail['mobo_id'];?>" class="span3 validate[required]" readonly/>
                                </div>
                            </div>
							<div class="control-group">
                                <label class="control-label">Message:</label>
                                <div class="controls">
                                    <textarea name="message" id="message" type="text" cols='10' class="form-control span6 validate[required]" style="text-align:left" readonly >
										<?php echo trim($infodetail['message']);?>
									</textarea>
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label">Reply:</label>
                                <div class="controls">
                                    <textarea name="responsive_mess" id="responsive_mess" type="text" class="form-control span6 validate[required]" style="text-align:left">
									</textarea>
                                </div>
                            </div>
                            <div class="control-group">
                                <div style="padding-left: 20%; text-align:left;">
									<input type="hidden" name='idx' value="<?php echo $_GET['ids'];?>">
                                    <button id="onSubmit" class=" add_field_button base_button base_green base-small-border-radius btn btn-primary btn-sm  base_button base_green base-small-border-radius"><span><?php echo ($_GET['ids']>0)?'Cập nhật':'Thêm mới';?></span></button>
                                    <button id="comeback" class="add_field_button base_button base_green base-small-border-radius btn btn-primary btn-sm base_button base_green base-small-border-radius"><span>Quay lại</span></button>
                                    <div style="display: inline-block">
                                        <span id="messagelog" style="color: green"></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>


            </div>
        </div>
    </div>
    <!-- /content wrapper -->
</div>
<!-- /content -->
</div>
