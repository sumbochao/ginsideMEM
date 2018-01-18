<link rel="stylesheet" href="<?php echo base_url('assets/datetime/css/style.css'); ?>"/>
<link rel="stylesheet" href="<?php echo base_url('assets/datetime/css/bootstrap.css'); ?>"/>
<script type="text/javascript" src="<?php echo base_url('/libraries/cms/jquery.form.js')?>"></script>
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
		.col-md-6,.col-md-4,.col-xs-12,.col-md-3,.col-xs-3{padding:0}
		.clearfix:after{clear:both;width:100%;display:block;}
		.control-group input[type="text"]{width: 152px;}
		.enablefile{display:none;}
		.disablefile{display:none;}
    </style>
    <script type="text/javascript">
        
        $(document).ready(function () {
           $('#onSubmit').on('click', function () {
                if ($('#frmSendChest').validationEngine('validate') === false){
                    return false;
                }

                $.ajax({
                    method: "POST",
                    dataType: 'jsonp',
                    url: "http://game.mobo.vn/bog/cms/gmtool/senditems",
                    data: $("#frmSendChest").serializeArray(),
                    beforeSend: function () {
                        // load your loading fiel here
                        $('#message').attr("style", "color:green");
                        $('#message').html('Đang xử lý ...');
                    }
                }).done(function (result) {
                    $('#message').html(result.message);
                });
            });

        });
		
		

        
    </script>
    <!-- Content -->
    <div id="content">
        <!-- Content wrapper -->
        <div class="wrapper">
            <?php include APPPATH . 'views/gmtool/gopet/updatebossinfo/tab.php'; ?>
            <div class="widget-name">

                <div class="clearboth"></div>
            </div>
            <!--END CONTROL ADD CHEST-->
            <div class="widget infotest" id="viewport">
                <div class="well form-horizontal">
                    <form id="frmSendChest" action="" method="POST" enctype="multipart/form-data" onsubmit="return false;" autocomplete="off">
                        
						<div class="control-group col-xs-12 clearfix">
							<div class="control-group col-md-3">
								<label class="control-label">BOSSID:</label>
								<div class="controls">
									<input type="text" id="bossid" name="bossid" value="" class="span3 validate[required,custom[onlyNumberSp]]" />
								</div>
							</div>
							
						</div>	
						<div class="control-group col-xs-12 clearfix">
							<div class="control-group col-md-4">
								<label class="control-label">DES:</label>
								<div class="controls">
									<input type="text" id="des" name="des" value="" class="span4 validate[required]" />
								</div>
							</div>
						</div>	
						<div class="control-group col-xs-12 clearfix">
							<div class="control-group col-xs-3">
								<label class="control-label">HP:</label>
								<div class="controls">
									<input type="text" id="hp" name="hp" value="" class="span3 validate[required]" />
								</div>
							</div>
							<div class="control-group col-xs-3">
								<label class="control-label">ATK:</label>
								<div class="controls">
									<input type="text" id="atk" name="atk" value="" class="span3 validate[required]" />
								</div>
							</div>
						</div>	
						
						<div class="control-group col-xs-12 clearfix">
							<div class="control-group col-xs-3">
								<label class="control-label">DEF:</label>
								<div class="controls">
									<input type="text" id="def" name="def" value="" class="span3 validate[required]" />
								</div>
							</div>
							<div class="control-group col-xs-3">
								<label class="control-label">CRIT:</label>
								<div class="controls">
									<input type="text" id="crit" name="crit" value="" class="span3 validate[required]" />
								</div>
							</div>
						</div>
						
						
						

                        <div class="control-group col-xs-12 clearfix">
                            <div style="">
                                <?php if($detail){ ?>
								<input type="hidden" id="id" name="id" value="<?php echo $detail['idx'];?>" class="span3 validate[custom[onlyNumberSp]]" />
								<?php } ?>
								<input type="hidden" id="email" name="email" value="<?php echo $_SESSION['account']['username'];?>" class="span3" />
                                <button id="onSubmit" class="btn btn-primary"><span>Thực hiện</span></button>
                                <div style="display: inline-block">
                                    <span id="message" style="color: green"></span>
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
