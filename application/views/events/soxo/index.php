
<!-- Content container -->
<div id="container">
    <style>
        .frmedit .form-group {float: left;width: 25%;}
        .frmedit .form-group label {width: 35%;}
        .frmedit .form-group input {width: 50%;}
        .contronls-lab label{color: red;font-weight: bold;}
        .totalchest>div{margin-bottom: 10px}
        .error{color: red;font-weight: bold;}
        .clear{clear: both}
        .percent{color: blue;font-weight: bold}
    </style>
    <script type="text/javascript" src="/libraries/jqwidgets32/jqx-all.js"></script>
    <link href='/libraries/jqwidgets32/styles/jqx.base.css' rel='stylesheet' type='text/css'>
    <link href='/libraries/jqwidgets32/styles/jqx.classic.css' rel='stylesheet' type='text/css'>
    <style>
        #loading {width: 100%;height: 100%;top: 0px;left: 0px;position: fixed;display: block; z-index: 99;}
        #loading-image {position: absolute;top: 40%;left: 45%;z-index: 100}
    </style>
    <script type="text/javascript">

        $(document).ready(function () {
            //Set DateTime Format
            $("#date_start").jqxDateTimeInput({width: '150px', height: '28px', formatString: 'yyyy-MM-dd HH:mm:ss' });
            $("#date_end").jqxDateTimeInput({width: '150px', height: '28px', formatString: 'yyyy-MM-dd HH:mm:ss' });
			
			var date_start = '<?php echo $date_start; ?>';
            $('#date_start').jqxDateTimeInput('setDate', date_start);
            var date_end = '<?php echo $date_end; ?>';
            $('#date_end').jqxDateTimeInput('setDate', date_end);
			
            //get event config
			/*
            $.ajax({
                method: "POST",
                dataType: 'jsonp',
                url: "http://m-app.mobo.vn/events/consomayman/getconfig"
            }).done(function (result) {
                $("input[name=startdate]").val(result.startdate);
                $("input[name=enddate]").val(result.enddate);
                result.status == '1' ?  $('#rdo_enable').attr('checked',true): $('#rdo_disable').attr('checked',true);
            });
			*/


            $('#onSubmit').on('click', function () {
                if ($('#frmSendChest').validationEngine('validate') === false){
                    return false;
                }

                $.ajax({
                    method: "POST",
                    dataType: 'jsonp',
                    url: "http://m-app.mobo.vn/events/consomayman/update_config",
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

           
            <style type="text/css" media="screen">
                .tabs a{float: left;color: #000;font-size: 14px;width: 14%;}
                .clearboth{clear:both;width: 100%;height:0;display: block;content:"";}
                .green,.red{font-weight: bold;}
                .green{color:green;}
                .red{color:red;}
            </style>
            <?php include APPPATH . '/views/events/soxo/nav.php'; ?>
            <!--END CONTROL ADD CHEST-->
			<div class="widget" id="viewport">
				
				<form id="frmSendChest" name="frmSendChest" action="" method="POST" onsubmit="return false;" autocomplete="off">
			
			
                
                    <div class="well form-horizontal">
					
						<div class="control-group">
                            <label class="control-label">EventID:</label>
                            <div class="controls">
                                <select name="eventid" id="eventid">
								<?php 
									foreach($listevent as $key=>$value){
								?>
									<option value="<?php echo $value['id'];?>"><?php echo $value['name'];?></option>
								<?php		
									}
								?>
								</select>
                            </div>
                        </div>
						
						<div class="control-group">
                                <label class="control-label">Bắt đầu:</label>
                                <div class="controls">
									<div id="date_start" name="startdate"></div>
                                </div>
                         </div>
						 
						 <div class="control-group">
                                <label class="control-label">Kết thúc:</label>
                                <div class="controls">
									<div id="date_end" name="enddate"></div>
                                </div>
                         </div>
							

                        
						
						<div class="control-group">
                            <label class="control-label">Phát thưởng:</label>
                            <div class="controls">
                                <select name="resultstatus" id="resultstatus">
									<option value="0">Từ input</option>
									<option value="1">Từ MoboRandom</option>
								</select>
                            </div>
                        </div>
						
						<div class="control-group">
                            <label class="control-label">Trạng thái:</label>
                            <div class="controls">
                                Enable:<input id="rdo_enable"  type="radio" name="status" value="1" checked>
                                Disable:<input id="rdo_disable" type="radio" name="status"  value="0">
                            </div>
                        </div>

                        <div class="control-group">
                            <div style="padding-left: 20%; text-align:left;">
                                <button id="onSubmit" class="base_button base_green base-small-border-radius"><span>Thực hiện</span></button>
                                <div style="display: inline-block">
                                    <span id="message" style="color: green"></span>
                                </div>
                            </div>
                        </div>
					
					</div>	
            </form>
			
            </div>
	  <!-- /content wrapper -->
    </div>
    <!-- /content -->
</div>








