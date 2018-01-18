<link rel="stylesheet" href="<?php echo base_url('assets/datetime/css/style.css'); ?>"/>
<link rel="stylesheet" href="<?php echo base_url('assets/datetime/css/bootstrap.css'); ?>"/>
<script src="<?php echo base_url('assets/datetime/js/currency.js'); ?>"></script>
<div id="content-t" style="min-height:500px; padding-top:10px">
    <style>
        #loading {width: 100%;height: 100%;top: 0px;left: 0px;position: fixed;display: block; z-index: 99;}
        #loading-image {position: absolute;top: 40%;left: 45%;z-index: 100} 
        label {width: auto !important;color: #f36926;}
        .dataTables_wrapper.no-footer .dataTables_scrollBody{
            border-bottom: 0px;
            padding-top: 5px;
        }
        .scroolbar{
            width: 2000px;
        }
        .btn{
            position: relative;
            top:-5px;
        }
    </style>
    <?php
        $start = date('d-m-Y G:i:s',  strtotime('-15 day'));
        $end = date('d-m-Y G:i:s');
        if(isset($_POST['game_id'])){
            if($_SESSION['account']['id_group']==2){
                if($_POST['game_id']>=0){
                    $gameid = $_POST['game_id'];
                }else{
                    $gameid = $game_id;
                }
            }else{
                if($_POST['game_id']>=0){
                    $gameid = $_POST['game_id'];
                }
            }
            $datetime = "&start=".strtotime($_POST['start'])."&end=".strtotime($_POST['end']);
            $start = $_POST['start'];
            $end = $_POST['end'];
        }else{
            if($_SESSION['account']['id_group']==2){
                $gameid = $game_id;
            }
            $datetime = "&start=".strtotime($start)."&end=".strtotime($end);
        }
    ?>
    <script type="text/javascript">
        $(document).ready(function () {
            getData();
            $('#create').on('click', function () {
                var game_id = $("select[name=game_id]").val();
                var start = $("input[name=start]").val();
                var end = $("input[name=end]").val();
                window.location.href = '/?control=wallet&func=excel_wallet&module=all&game_id='+game_id+'&start='+start+'&end='+end;
            });
        });
        function getData() {
            $.ajax({
                url: "<?php echo $url_service; ?>/cms/wallet/history_wallet?game_id=<?php echo $gameid.$datetime;?>",
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
                                mData: "id"
                            },
                            {
                                sTitle: "Game ID",
                                mData: "game_id"
                            },
                            {
                                sTitle: "Mobo ID",
                                mData: "mobo_id"
                            },
                            {
                              sTitle: "Mobo Service ID",
                              mData: "msi",
                            },
                            {
                               sTitle: "Server ID",
                               mData: "server_id",
                            },
                            {
                               sTitle: "Amount",
                               mData: "amount",
                            },
                            {
                               sTitle: "Total Recharge Money",
                               mData: "total_recharge_money",
                               mRender: function (data) {
                                    var total_recharge_money=0;
                                    if(data>0){
                                        total_recharge_money = FormatNumber(data);
                                    }
                                    return total_recharge_money;
                               }
                            },
                            {
                                sTitle: "Total Recharge",
                                mData: "total_recharge",
                                mRender: function (data) {
                                    var total_recharge=0;
                                    if(data>0){
                                        total_recharge = FormatNumber(data);
                                    }
                                    return total_recharge;
                                }
                            },
                            {
                                sTitle: "Total Minus",
                                mData: "total_minus",
                                mRender: function (data) {
                                    var total_minus=0;
                                    if(data>0){
                                        total_minus = FormatNumber(data);
                                    }
                                    return total_minus;
                                }
                            },
                            {
                                sTitle: "Total Plus",
                                mData: "total_plus",
                                mRender: function (data) {
                                    var total_plus=0;
                                    if(data>0){
                                        total_plus = FormatNumber(data);
                                    }
                                    return total_plus;
                                }
                            },
                            {
                               sTitle: "Create Date",
                               mData: "create_date",
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
            <?php include APPPATH . 'views/game/Events/wallet/tab.php'; ?>
            <div class="widget-name">
                <div class="clearboth"></div>
            </div>
            <!--END CONTROL ADD CHEST-->
            <div class="widget" id="viewport">
                <div class="well form-horizontal">
                    <div class="table-overflow">     
                         <div style="margin-top: 10px; margin-bottom: 10px;">
                             <form action="" method="post">
                                <select name="game_id">
                                   <option value="-1">Chọn game</option>
                                   <?php 
                                       if(count($slbGame)>0){
                                           foreach($slbGame as $v){
                                               if((@in_array($v['app_name'], $_SESSION['permission']) && $_SESSION['account']['id_group']==2) || (@in_array($v['app_name'], $_SESSION['permission']) && $_SESSION['account']['id_group']==3) || $_SESSION['account']['id_group']==1){
                                   ?>
                                   <option value="<?php echo $v['service_id'];?>" <?php echo $_POST['game_id']==$v['service_id']?'selected="selected"':'';;?>><?php echo $v['app_fullname'].' ('.$v['service_id'].')';?></option>
                                   <?php
                                               }
                                           }
                                       }
                                   ?>
                               </select>
                                <input type="text" class="datetimer" name="start" value="<?php echo $start;?>"/>
                                <input type="text" class="datetimer" name="end" value="<?php echo $end;?>"/>
                                <button id="submit"  class="btn btn-primary"><span>Tìm kiếm</span></button>
                                <button id="create"  class="btn btn-primary" onclick='return false;'><span>Xuất Excel</span></button>
                            </form>
                        </div>
                        <div class="wrapper_scroolbar">
                            <div class="scroolbar">
                                <table class="table table-striped table-bordered" id="data_table"></table>
                            </div>
                        </div>
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
