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
            window.location.href ='/cms/ep/accumulation_weekly/index?view=wheel';
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
                url: "<?php echo $url; ?>/cms/accumulation_weekly/<?php echo ($_GET['ids']>0)?'edit_wheel?ids='.$_GET['ids']:'add_wheel';?>",
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

</script>

<!-- Content -->
<div id="content">
    <!-- Content wrapper -->
    <div class="wrapper">
        <?php include APPPATH . 'views/game/lk/Events/tichluy/tab.php'; ?>
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
        $start = gmdate('d-m-Y G:i:s',time()+7*3600);
        $end = gmdate('d-m-Y G:i:s',time()+7*3600);
        if($_GET['ids']>0){
            $statusOn =  $infodetail[0]['status']==1 ? 'checked':'';
            $statusOff =  $infodetail[0]['status']==0 ? 'checked':'';
            $name  = $infodetail[0]['name']?$infodetail[0]['name']:'';
            if($infodetail[0]['start']){
                $startc = DateTime::createFromFormat('Y-m-d G:i:s',$infodetail[0]['start']);
                $start = $startc->format('d-m-Y G:i:s');
            }else{
                $start = gmdate('d-m-Y G:i:s',time()+7*3600);
            }
            if($infodetail[0]['end']){
                $endc = DateTime::createFromFormat('Y-m-d G:i:s',$infodetail[0]['end']);
                $end = $endc->format('d-m-Y G:i:s');
            }else{
                $end = gmdate('d-m-Y G:i:s',time()+7*3600);
            }
            $server_id  = $infodetail[0]['server_id']?$infodetail[0]['server_id']:'';
        }
        ?>
        <div class="widget" id="viewport">
            <div class="well form-horizontal">

                <form id="frmSendChest" name="frmSendChest" action="" method="POST" onsubmit="return false;" autocomplete="off">
                    <div class="widget row-fluid">
                        <div class="well form-horizontal">


                            <div class="control-group">
                                <label class="control-label">Server ID:</label>
                                <div class="controls">
                                    <input name="server_id" id="boxname" type="text" value="<?php echo $server_id;?>" class="span3 validate[required]" />
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label">Name:</label>
                                <div class="controls">
                                    <input name="name" id="boxname" type="text" value="<?php echo $name;?>" class="span3 validate[required]" />
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label">Start datetime:</label>
                                <div class="controls">
                                    <input name="start" type="datetime" value="<?php echo $start;?>" class="timepicker2 start span3 validate[required]" />
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label">End datetime:</label>
                                <div class="controls">
                                    <input name="end" type="datetime" value="<?php echo $end;?>" class="end timepicker2 span3 validate[required]" />
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label">Status:</label>
                                <div class="controls">
                                    Enable:<input type="radio" name="status" id="cat_enable" value="1" <?php echo $statusOn;?> />
                                    &nbsp;&nbsp;
                                    Disable:<input type="radio" name="status" id="cat_disable" value="0" <?php echo $statusOff;?> />
                                </div>
                            </div>

                            <div class="control-group">
                                <div style="padding-left: 20%; text-align:left;">
                                    <input type="hidden" name='email' value="<?php echo $_SESSION['auth']['user']->ause_username;?>">
                                    <button id="onSubmit" class=" add_field_button base_button base_green base-small-border-radius btn btn-primary btn-sm  base_button base_green base-small-border-radius"><span><?php echo ($_GET['ids']>0)?'Cập nhật':'Thêm mới';?></span></button>
                                    <button id="comeback" class="add_field_button base_button base_green base-small-border-radius btn btn-primary btn-sm base_button base_green base-small-border-radius"><span>Quay lại</span></button>
                                    <div style="display: inline-block">
                                        <span id="message" style="color: green"></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>

                <?php
                if($_GET['ids']>0){
                    include_once 'common/config.php';
                }
                ?>

            </div>
        </div>
    </div>
    <!-- /content wrapper -->
</div>
<!-- /content -->
</div>
