<link rel="stylesheet" href="<?php echo base_url('assets/datetime/css/style.css'); ?>"/>
<link rel="stylesheet" href="<?php echo base_url('assets/datetime/css/bootstrap.css'); ?>"/>
<script src="<?php echo base_url('assets/datetime/js/currency.js') ?>" type="text/javascript"></script>
<div id="content-t" style="min-height:500px; padding-top:10px">
    <style>
        #loading {width: 100%;height: 100%;top: 0px;left: 0px;position: fixed;display: block; z-index: 99;}
        #loading-image {position: absolute;top: 40%;left: 45%;z-index: 100} 
        label {width: auto !important;color: #f36926;}
        button#create,span#create{
            margin-bottom: 10px;
        }
    </style>
	<?php
        $start = date('d-m-Y G:i:s',  strtotime('-15 day'));
        $end = date('d-m-Y G:i:s');
        if(isset($_POST['start'])){
            $start = $_POST['start'];
            $end = $_POST['end'];
        }
    ?>
    <script type="text/javascript">
        $(document).ready(function () {
            getData();
            $('#create').on('click', function () {
                var server_id = $("select[name=server_id]").val();
				var start = $("input[name=start]").val();
                var end = $("input[name=end]").val();
                window.location.href = '/?control=uocnguyen_koa&func=excel_user&server_id='+server_id+'&start='+start+'&end='+end;
            });
        });
        function getData() {
            $.ajax({
                url: "<?php echo $url_service; ?>/cms/uocnguyen/index_<?php echo $_GET['view'];?>?server_id=<?php echo $_POST['server_id'];?>&start=<?php echo strtotime($start);?>&end=<?php echo strtotime($end);?>",
                dataType: 'jsonp',
                method: "POST",
                bRetrieve: true,
                bDestroy: true,
                error: function (jqXHR, textStatus, errorThrown) {
                },
                success: function (data, textStatus, jqXHR) {
                    $('#data_table').dataTable({
                        "aaData": data.rows,
                        aoColumns: [
                            {
                               sTitle: "ID",
                               mData: "user_id",
                            },
                            {
                               sTitle: "Server ID",
                               mData: "server_id",
                            },
                            /*{
                               sTitle: "Username",
                               mData: "username",
                            },*/
                            {
                               sTitle: "Mobo Service ID",
                               mData: "mobo_service_id",
                            },
                            /*{
                                sTitle: "Số tiền",
                                mData: "money",
                                mRender: function (data) {
                                    var money  ='';
                                    if(data>0){
                                        money = FormatNumber(data);
                                    }   
                                    return money;
                                }
                            },*/
                            {
                                sTitle: "Turn Free Total",
                                mData: "turn_free_total"
                            },
                            {
                                sTitle: "Turn Free Used",
                                mData: "turn_free_used"
                            },
                            {
                                sTitle: "Turn Buy Total",
                                mData: "turn_buy_total"
                            },
                            {
                                sTitle: "Turn Buy Used",
                                mData: "turn_buy_used"
                            },
							{
                                sTitle: "Ngày tạo",
                                mData: "created_date"
                            }
                        ],
                        bProcessing: true,
                        bPaginate: true,
                        bJQueryUI: false,
                        bAutoWidth: false,
                        bSort: false,
                        bRetrieve: true,
                        bDestroy: true,
                        sPaginationType: "full_numbers"
                    });
                }
            });
        }
    </script>
    <!-- Content -->
    <div id="content">
        <!-- Content wrapper -->
        <div class="wrapper">                     
            <?php include APPPATH . 'views/game/koa/Events/uocnguyen/tab.php'; ?>
            <div class="widget-name">
                <div class="clearboth"></div>
            </div>
            <!--END CONTROL ADD CHEST-->
            <div class="widget" id="viewport">
                <div class="well form-horizontal">
                    <form id="appForm" action="" method="post" name="appForm">
                        <div class="table-overflow">
                            Thống kê chi tiết thông tin người chơi
                            <div style="margin-top: 10px; margin-bottom: 10px;">
								<input type="text" class="datetimer" name="start" value="<?php echo $start;?>"/>
								<input type="text" class="datetimer" name="end" value="<?php echo $end;?>"/>
                                <span class="title">Server:</span> <select name="server_id">
                                    <option value="0">Chọn server</option>
                                    <?php
                                        if(count($slbServer)>0){
                                            foreach($slbServer as $v){
                                    ?>
                                    <option value="<?php echo $v['server_id'];?>" <?php echo $_POST['server_id']==$v['server_id']?'selected="selected"':'';?>><?php echo $v['server_name'];?></option>
                                    <?php
                                            }
                                        }
                                    ?>
                                </select>
                                <?php
                                    $lnkFilter = "onSubmitForm('appForm','".base_url()."?control=".$_GET['control']."&func=".$_GET['func']."&view=".$_GET['view']."#".$_GET['view']."')";
                                ?>
                                <input type="button" onclick="<?php echo $lnkFilter; ?>" value="Tìm" class="btn btn-primary"/> 
                                <span id="create"  class="btn btn-primary"><span>Xuất Excel</span></span>
                            </div>
                            <table class="table table-striped table-bordered" id="data_table">      
                            </table>
                        </div>
                    </form>
                 <div class="table-overflow">
                    <table class="table table-striped table-bordered" id="data_table_send">      
                    </table>
                </div>
                    </div>
            </div>
        </div>
        <!-- /content wrapper -->
    </div>
    <!-- /content -->
</div>
<script>
    $('.datetimer').datetimepicker({
        dateFormat: 'dd-mm-yy',
        timeFormat: 'hh:mm:ss'//
    });
</script>