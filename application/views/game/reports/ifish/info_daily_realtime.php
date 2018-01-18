<script>
    var url_action = '?control=reports&func=ajax_info_daily_realtime&module=all&game=ifish';
</script>
<link rel="stylesheet" href="<?php echo base_url('assets/datepicker/css/general.css'); ?>"/>
<link rel="stylesheet" href="<?php echo base_url('assets/datepicker/css/jquery-ui-1.8.18.custom.css'); ?>"/>
<script language="javascript" type="text/javascript" src="<?php echo base_url('assets/datepicker/js/jquery.jcache.js'); ?>"></script>
<script language="javascript" type="text/javascript" src="<?php echo base_url('assets/datepicker/js/fixture.js'); ?>"></script>
<script src="<?php echo base_url('assets/js/jquery.table2excel.js') ?>"></script>
<style>
    .content_table table tr th{font-weight: bold;}
</style>
<div class="loading_warning"></div>
<div id="content-t" style="min-height:500px; padding-top:10px">
    <?php include_once(APPLICATION_PATH.'/application/views/game/reports/tab.php');?>
    <div id="load_content">
        <div class="line_date">
            <a href="javascript:;" onclick="fixture.changeDate('<?php echo date('Y-m-d', $prevUnixTime); ?>')" class="txt_gray">Ngày trước </a>&nbsp; | &nbsp;
            <span class="txt_green"><b>
                    <?php
                    $day = date('N', $currUnixTime) + 1;
                    $date = date('d/m/Y', $currUnixTime);
                    if ($day == 8)
                        echo "Chủ nhật - $date";
                    else
                        echo "Thứ $day - $date";
                    ?>
                </b> 
            </span> &nbsp; | &nbsp;
            <a href="javascript:;" onclick="fixture.changeDate('<?php echo date('Y-m-d', $nextUnixTime); ?>')" class="txt_gray">Ngày sau</a> <span class="icon_portal_thethao icon_view_more">&nbsp;</span>
            <form action="" method="POST" id="appForm" style="display:inline-block;">
                <input type="button" value="Xuất Excel" class="btn btn-primary" onclick="onExport();"/>
            </form>
        </div>
        <div class="content_table">
            <table width="100%" border="0" id="table2excel" class="table table-striped table-bordered table-condensed table-hover">
                <thead>
                    <tr>
                        <th align="center" width="50px">STT</th>
                        <th align="center" width="50px">Ngày</th>
                        <th align="center" width="230px">Số lượng user nạp tiền trong ngày (PayUser)</th>
                        <th align="center" width="200px">Lượng ngọc phát sinh (ở ví tiền) trong ngày (GemlnDay)</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        if(count($listItems)>0){
                            $i=0;
                            foreach($listItems as $key=>$v){
                                $i++;
                    ?>
                    <tr>
                        <td><?php echo $i;?></td>
                        <td><?php  echo date_format(date_create($v['Date']),"d-m-Y");?></td>
                        <td><?php echo $v["PayUser"]>0?number_format($v['PayUser']):0; ?></td>
                        <td><?php echo $v["GemInDay"]>0?number_format($v['GemInDay']):0; ?></td>
                    </tr>
                    <?php
                            }
                        }else{
                    ?>
                    <tr>
                        <td colspan="5" style="color:red;text-align: center;">Dữ liệu không tìm thấy</td>
                    </tr>  
                    <?php
                        }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<div class="box_date">
    <div class="title_box_date">Xem theo ngày</div>
    <div class="box_col_date" style="display: none;">
        <div id="datepicker"></div>
    </div>
</div>
<script lang="javascript" type="text/javascript">
    fixture.init({
        date: '<?php echo date('Y-m-d', $currUnixTime); ?>',
        url: '<?php echo base_url(); ?>',
        id: 'col_left',
        selectGmtEleID: 'select-gmt',
        displayGmtEleID: 'display-gmt',
        loadGMTType: 0 
    });
</script>
<script lang="javascript" type="text/javascript">
    $( "#datepicker" ).datepicker({
        dayNames        : ['Chủ nhật', 'Thứ 2', 'Thứ 3', 'Thứ 4', 'Thứ 5', 'Thứ 6', 'Thứ 7'],
        dayNamesMin     : ['CN', 'T2', 'T3', 'T4', 'T5', 'T6', 'T7'],
        dayNamesShort   : ['CN', 'T2', 'T3', 'T4', 'T5', 'T6', 'T7'],
        monthNames      : ['Tháng 1', 'Tháng 2', 'Tháng 3', 'Tháng 4', 'Tháng 5', 'Tháng 6', 'Tháng 7', 'Tháng 8', 'Tháng 9', 'Tháng 10', 'Tháng 11', 'Tháng 12'],
        monthNamesShort : ['Tháng 1', 'Tháng 2', 'Tháng 3', 'Tháng 4', 'Tháng 5', 'Tháng 6', 'Tháng 7', 'Tháng 8', 'Tháng 9', 'Tháng 10', 'Tháng 11', 'Tháng 12'],
        dateFormat      : 'yy-mm-dd',
        defaultDate     : '<?php echo date('Y-m-d', $currUnixTime); ?>',
        changeMonth     : true,
        changeYear      : true,
        onSelect        : function(dateText) {
            fixture.changeDate(dateText);
        }
    });
    function onExport(){
        jQuery("#table2excel").table2excel({
            exclude: ".noExl",
            name: "Excel Document Name"
        });
    }
    function onSubmitExcel(formName,url){
        var theForm = document.getElementById(formName);
	theForm.action = url;	
	theForm.submit();
    }
</script>