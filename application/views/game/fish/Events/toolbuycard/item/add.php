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
        .w20 .control-group{width: 20%;}

    </style>
    <script type="text/javascript">

                    /*
                     $("#tournament_date_start").jqxDateTimeInput({ width: '150px', height: '28px', formatString: 'yyyy-MM-dd HH:mm:ss' });
                    var tournament_date_start = null;
                    if (data[0]["tournament_date_start"] != "" && data[0]["tournament_date_start"] != null) {
                        tournament_date_start = new Date(data[0]["tournament_date_start"]);
                    }
                    $("#tournament_date_start").jqxDateTimeInput('setDate', tournament_date_start);*/


        $(document).ready(function() {

            $('.timepicker2').datetimepicker({
                showSecond: true,
                timeFormat: 'hh:mm:ss',
                dateFormat: 'yy-mm-dd',
                stepHour: 1,
                stepMinute: 1,
                stepSecond: 1
            });

            $('#addgroup').click(function() {
                getHtml = createHtml();
                $('.totalchest').append(getHtml);
                i++;
            });

            $('#comeback').on('click',function(){
                window.location.href ='?control=quaonline&func=index&view=item';
            });
            $('#onCheck').on('click',function(){
                checkPercentTotal();
            });
            $('#onSubmit').on('click',function(){
                if( $('#frmSendChest').validationEngine('validate') === false)
                    return false;
                $.ajax({
                    type: "POST",
                    dataType: 'jsonp',
                    url: "<?php echo $url; ?>/event/buycard/updateItem/",
                    data: $("#frmSendChest").serializeArray(),
                    beforeSend: function(  ) {
                        // load your loading fiel here
                        $('#message').attr("style","color:green");
                        $('#message').html('Đang xử lý ...');
                        //disable button
                        $('#searchuid').attr("disabled","disabled");
                    }
                }).done(function(result) {
                    console.log(result);
                    //hide your loading file here
                    if (result.status == false)
                        $('#message').attr("style","color:red");

                    $('#message').html(result.message);
                    //enable button
                    $('#searchuid').removeAttr('disabled');

                });
            });

        });

        function checkPercentTotal(){
            var checkPercent = parseFloat(0);
            $.each($('.totalchest>div'),function(key,val){
                value = $(val).find('.rate').val();
                valueCheck = $(val).find('.valueCheck').val();
                if(valueCheck == 1)
                    checkPercent+= parseFloat(value);

            });
            if(checkPercent != parseFloat(100)){
                failedpercent = {'color':'red','font-weight':'bold','border':'1px solid red'};
            }else{
                failedpercent = {'color':'green','font-weight':'bold','border':'1px solid green'};
            }
            $('.totalchest>div .rate').css(failedpercent);
            $('#totalcheck').val(checkPercent).css(failedpercent);
            return checkPercent;
        }
        function disableStatus(data){
            inputvalue = $(data).parent().find('input');
            classdiv = $(data).val();
            if(classdiv == 1){
                $(data).removeClass('base_green');
                $(data).addClass('base_red');
                $(data).text('Off');
                $(data).val('0');
                inputvalue.val('0');
            }else{
                $(data).val('1');
                $(data).text('On');
                $(data).addClass('base_green');
                $(data).removeClass('base_red');
                inputvalue.val('1');
            }
        }

        $(document).ready(function() {
            var max_fields      = 10; //maximum input boxes allowed
            var wrapper         = $(".input_fields_wrap"); //Fields wrapper
            var add_button      = $(".add_field_button"); //Add button ID
            var x = 1; //initlal text box count
            $(wrapper).on("click",".remove_field", function(e){ //user click on remove text
                e.preventDefault(); $(this).parent().parent().parent().remove(); x--;
            })
        });
    </script>

    <!-- Content -->
    <div id="content">
        <!-- Content wrapper -->
        <div class="wrapper">
            <?php include APPPATH . 'views/game/fish/Events/toolbuycard/tab.php'; ?>
            <div class="widget-name">

                <!-- <div class="tabs">
                   <a href="/cms/ep/promotion_lato/thongke"><i class=" ico-th-large"></i>THỐNG KÊ</a> 
                   <a href="/cms/ep/promotion_lato/tralogdoiqua"><i class=" ico-th-large"></i>TRA LOG ĐỔI QUÀ</a>
				   <a href="javascript:void(0);" class="clearcached"><i class=" ico-th-large"></i>CLEAR MENCACHED</a>
                </div>-->
                <div class="clearboth"></div>
            </div>

            <!--END CONTROL ADD CHEST-->
            <?php
            $statusOn = 'checked';
            if($_GET['ids']>0){
                $menhgia =  $items['data']['menhgia'];
                $so =  $items['data']['so'];
				$order =  $items['data']['order'];
                $statusOn =  $items['data']['status']==1 ? 'checked':'';
                $statusOff =  $items['data']['status']==0 ? 'checked':'';
            }
            ?>
            <div class="widget" id="viewport">
                <div class="well form-horizontal">
                    <form id="frmSendChest" name="frmSendChest" action="" method="POST" onsubmit="return false;" autocomplete="off">

                        <div class="input_fields_wrap">
                            <div class="control-group">
                                <label class="control-label">Mệnh giá:</label>
                                <div class="controls">
                                    <input name="menhgia" id="menhgia" type="text" value="<?php echo $menhgia;?>" class="span3  validate[required,custom[onlyNumberSp]]" />
                                </div>
                            </div>
							<div class="control-group">
                                <label class="control-label">Sò:</label>
                                <div class="controls">
                                    <input name="so" id="so" type="text" value="<?php echo $so;?>" class="span3  validate[required,custom[onlyNumberSp]]" />
                                </div>
                            </div>
							<div class="control-group">
                                <label class="control-label">Order:</label>
                                <div class="controls">
                                    <input name="order" id="order" type="text" value="<?php echo $order;?>" class="span3  validate[required,custom[onlyNumberSp]]" />
                                </div>
                            </div>
                            <br/>
                           
                        </div>
                        <div class="control-group">
                            <label class="control-label">Status:</label>
                            <div class="controls">
                                <span class="lb_radio">Enable:</span><input type="radio" name="status" id="cat_enable" value="1" <?php echo $statusOn;?>>
                                &nbsp;&nbsp;
                                <span class="lb_radio">Disable:</span><input type="radio" name="status" id="cat_disable" value="0" <?php echo $statusOff; ?>>
                            </div>
                        </div>

                        <div class="control-group">
                            <span class="error"></span>
                        </div>

                        <div class="control-group">
                                <input type="hidden" name='actor_action' value="<?php echo $_SESSION['account']['username'];?>">
                                <input type="hidden" name='idx' id="ids" value="<?php echo $_GET['ids'];?>">
								<input type="hidden" name='type' id="item" value="item">
                                <button id="onSubmit" class="btn btn-primary"><span>Thực hiện</span></button>
                                <div style="display: inline-block">
                                    <span id="message" style="color: green"></span>
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
