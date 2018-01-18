<!-- Content container -->
<div id="container">
    <style>
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
            //Set DateTime Format+$("#date_start").jqxDateTimeInput({width: '150px', height: '28px', formatString: 'yyyy-MM-dd HH:mm:ss' });
			$("#date_start").jqxDateTimeInput({width: '150px', height: '28px', formatString: 'yyyy-MM-dd HH:mm:ss' });

            $('#onSubmit').on('click', function () {
                if ($('#frmResult').validationEngine('validate') === false){
                    return false;
                }

                $.ajax({
                    method: "POST",
                    dataType: 'jsonp',
                    url: "http://m-app.mobo.vn/events/consomayman/importLotteryResult",
                    data: $("#frmResult").serializeArray(),
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

            <form id="frmResult" name="frmResult" action="" method="POST" onsubmit="return false;" autocomplete="off">
                <div class="widget row-fluid">
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
							<label class="control-label">Ngày:</label>
                            <div class="controls">
                                <div id="date_start" name="date"></div>
                            </div>
                        </div>
						
						

                        <div class="control-group">
							<label class="control-label">Tất cả:</label>
                            <div class="controls">
                                
                                <textarea style="min-width: 30%;" class="form-control validate[required] text-input" rows="3" name="tatca"></textarea>
                                <div style="padding-left: 18%; padding-top: 2%;" class="red">Dãy số cách nhau bằng dấu ',' và không có khoảng trắng</div>
                            </div>

                        </div>
						
						<!--neu resultstatus is 1:( phat tu mobo) thi  show ruleEvent ra-->
						
						<div class="control-group">
                            <label class="control-label">Loại Phát thưởng:</label>
                            <div class="controls">
                                <select name="ruleevent" id="ruleevent">
									<option value="0">Ngẫu nhiên</option>
									<option value="1">Theo thứ tự</option>
								</select>
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









