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
        
        $(document).ready(function () {
            //Set DateTime Format
            $("#startdate").jqxDateTimeInput({ width: '150px', height: '28px', formatString: 'yyyy-MM-dd HH:mm:ss' });
			$('#onSubmit').on('click', function () {
                if ($('#frmSendChest').validationEngine('validate') === false){
					return false;
                }

                $.ajax({
                    method: "POST",
                    dataType: 'jsonp',
                    url: "http://game.mobo.vn/phongthan/cms/consomayman/importLotteryResult",
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
            <?php include APPPATH . 'views/game/pt/Events/consomayman/tab.php'; ?>
            <div class="widget-name">

                <div class="clearboth"></div>
            </div>

            <!--END CONTROL ADD CHEST-->

            <div class="widget" id="viewport">
                <div class="well form-horizontal">
                    <form id="frmSendChest" action="" method="POST" enctype="multipart/form-data" onsubmit="return false;" autocomplete="off">
                        <div class="control-group">
                            <label class="control-label">Game:</label>
                            <div class="controls">
                                <select id="game" name="game" class="span4 validate[required]" />
									<?php
                                    if($listgame) {
                                        foreach ($listgame as $key => $val) {
                                            if ($val['idapp'] == $game) {
                                                echo '<option value="' . $val['idapp'] . '" selected>' . $val['game'] . '</option>';
                                            } else {
                                                echo '<option value="' . $val['idapp'] . '">' . $val['game'] . '</option>';
                                            }
                                        }
                                    }
									?>
								</select> 
                            </div>
                        </div>
                        <div class="control-group">
                            <label class="control-label">Ngày:</label>
                            <div class="controls">
                                <div id="startdate" name="start"></div>
                            </div>
                        </div>

                        <div class="control-group">
                                <label class="control-label">Đặc biệt:</label>
                                <div class="controls">
                                    <input type="text" class="form-control validate[required,minSize[2],maxSize[2],custom[integer],min[0]] text-input" name="dacbiet" placeholder="Nhập số đặc biệt">
                                </div>
                        </div>

                        <div class="control-group">
                                <label class="control-label">Tất cả:</label>
                                <div class="controls">
                                    <textarea style="min-width: 30%;" class="form-control validate[required] text-input" rows="3" name="tatca"></textarea>
                                    <div style="padding-left: 18%; padding-top: 2%;" class="red">Dãy số cách nhau bằng dấu ',' và không có khoảng trắng</div>
                                </div>

                        </div>


                        <div class="control-group">
                            <div style="padding-left: 20%; text-align: left;">
                                <input type="hidden" name='id' id="id">
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
