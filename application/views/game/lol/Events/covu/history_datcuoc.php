<link rel="stylesheet" href="<?php echo base_url('assets/datetime/css/style.css'); ?>"/>
<link rel="stylesheet" href="<?php echo base_url('assets/datetime/css/bootstrap.css'); ?>"/>
<div id="content-t" style="min-height:500px; padding-top:10px">
    <style>
        #loading {width: 100%;height: 100%;top: 0px;left: 0px;position: fixed;display: block; z-index: 99;}
        #loading-image {position: absolute;top: 40%;left: 45%;z-index: 100} 
        label {width: auto !important;color: #f36926;}
        .scroolbar{
            width: 1800px;
        }
    </style>
    <script type="text/javascript">
        $(document).ready(function () {
            getData();
            $('#create').on('click', function () {
                var start = $("input[name=start]").val();
                var end = $("input[name=end]").val();
                window.location.href = '/?control=covu_lol&func=excel_datcuoc&module=<?php echo $_GET['module'];?>&start='+start+'&end='+end;
            });
        });
        function getData() {
            $.ajax({
                url: "<?php echo $url_service; ?>/cms/covu/<?php echo $_GET['func'];?>",
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
                                sTitle: "Mobo ID",
                                mData: "moboid"
                            },
                            {
                                sTitle: "Character ID",
                                mData: "character_id"
                            },
                            {
                              sTitle: "Mobo Service ID",
                              mData: "mobo_service_id",
                            },
                            {
                               sTitle: "Character Name",
                               mData: "character_name",

                            },
                            {
                               sTitle: "Server ID",
                               mData: "server_id",
                            },
                            {
                               sTitle: "Match",
                               mData: "capdau",
                               mRender: function (data) {
                                var obj = JSON.parse(data);   
                                  return obj.ten_teama+' - '+obj.ten_teamb;
                               }
                            },
                            {
                               sTitle: "Point",
                               mData: "point",
                            },
                            {
                               sTitle: "Team win",
                               mData: "team_win",
                               mRender: function (data,avg1,avg2) {
                                    var obj = JSON.parse(avg2.capdau);
                                    var result = '';
                                    if(avg2.team_win=='win_a'){
                                        result = obj.ten_teama;
                                    }else{
                                        result = obj.ten_teamb;
                                    }
                                  return result;
                               }
                            },
                            {
                               sTitle: "Date",
                               mData: "create_date",
                            },
                            {
                               sTitle: "Status",
                               mData: "status",
                               mRender: function (data) {
                                    var status = '';
                                    switch(data){
                                        case 'thang':
                                            status = 'Thắng';
                                            break;
                                        case 'hoa':
                                            status = 'Hòa';
                                            break;
                                        case 'thua':
                                            status = 'Thua';
                                            break;
                                        case 'cho':
                                            status = 'Đang chờ';
                                            break;
                                    }
                                    return status;
                               }
                            },
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
            <?php include APPPATH . 'views/game/lol/Events/covu/tab.php'; ?>
            <div class="widget-name">
                <div class="clearboth"></div>
            </div>
            <!--END CONTROL ADD CHEST-->
            <div class="widget" id="viewport">
                <div class="well form-horizontal">
                    <div class="table-overflow">
                        <div style="margin-top: 10px; margin-bottom: 10px;">
                            <?php
                                $start = date('d-m-Y G:i:s',  strtotime('-15 day'));
                                $end = date('d-m-Y G:i:s');
                            ?>
                            <input type="text" id="start" name="start" value="<?php echo $start;?>"/>
                            <input type="text" id="end" name="end" value="<?php echo $end;?>"/>
                            <span><button id="create"  class="btn btn-primary"><span>Xuất Excel</span></button></span>
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