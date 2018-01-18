<link rel="stylesheet" href="<?php echo base_url('assets/datetime/css/style.css'); ?>"/>
<link rel="stylesheet" href="<?php echo base_url('assets/datetime/css/bootstrap.css'); ?>"/>
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
            width: 1500px;
        }
        #create{
            position: relative;
            top:-5px;
        }
    </style>
    <?php
        if(isset($_POST['start'])){
            $startHistory = strtotime(date('Y-m-d H:i:s',$_POST['start']));
            $endHistory = strtotime(date('Y-m-d H:i:s',$_POST['end']));
            $start = $_POST['start'];
            $end   = $_POST['end'];
        }else{
            $startHistory = strtotime(date('Y-m-d H:i:s',strtotime('-15 day')));
            $endHistory = strtotime(date('Y-m-d H:i:s'));
            $start = date('d-m-Y H:i:s',  strtotime('-15 day'));
            $end = date('d-m-Y H:i:s'); 
        }
    ?>
    <script type="text/javascript">
        $(document).ready(function () {
            getData();
            $('#create').on('click', function () {
                var start = $("input[name=start]").val();
                var end = $("input[name=end]").val();
                window.location.href = '/?control=<?php echo $_GET['control'];?>&func=excel&module=all&start='+start+'&end='+end;
            });
        });

        function getData() {
            $.ajax({
                url: "<?php echo $url_service; ?>/ToolBaoDanhNhanQua/index_history?start=<?php echo $startHistory;?>&end=<?php echo $endHistory;?>",
                dataType: 'jsonp',
                method: "POST",
                bRetrieve: true,
                bDestroy: true,
                error: function (jqXHR, textStatus, errorThrown) {
                },
                success: function (data, textStatus, jqXHR) {
                    var datarow = [];
                    $.each(data, function (key, value) {
                        datarow.push(value);
                    });
                    $('#data_table').dataTable({
                        "aaData": datarow,
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
                                mData: "character_id",
                            },
                           {
                               sTitle: "Mobo Service ID",
                               mData: "mobo_service_id"
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
                                sTitle: "Sự kiện",
                                mData: "event_name",
                            },
                            {
                                sTitle: "Loại",
                                mData: "type",
                                mRender: function (data) {
                                    var type;
                                    switch(data){
                                        case "1":
                                            type= "Liên tục";
                                            break;
                                        case "2":
                                            type= "Theo ngày";
                                            break;
                                    }
                                    return type;
                                }
                            },
                            {
                                sTitle: "Mốc quà",
                                mData: "condition",
                            },
                            {
                                sTitle: "Ngày tạo",
                                mData: "create_date",
                            },
                            {
                                sTitle: "Tùy Chọn",
                                mData: "id",
                                mRender: function (data) {
                                    return "<a class='btn btn-danger btn-xs' onclick=\"if(!window.confirm('Bạn có muốn xóa không ?')) return false;\" href='/?control=<?php echo $_GET['control'];?>&func=delete&view=<?php echo $_GET['view'];?>&module=all&id=" + data + "'>Xóa</a>";
                                }
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
            <?php include APPPATH . 'views/game/lg/GOK/Events/baodanhnhanthuong/tab.php'; ?>
            <div class="widget-name">
                <div class="clearboth"></div>
            </div>

            <!--END CONTROL ADD CHEST-->
            <div class="widget" id="viewport">
                <div class="well form-horizontal">
                    <div class="table-overflow">     
                         <div style="margin-top: 10px; margin-bottom: 10px;">
                             <input type="text" class="datetime" name="start" value="<?php echo $start;?>"/>
                             <input type="text" class="datetime" name="end" value="<?php echo $end;?>"/>
                            <button id="create"  class="btn btn-primary"><span>Xuất Excel</span></button>
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
    $('.datetime').datetimepicker({
        dateFormat: 'dd-mm-yy',
        timeFormat: 'hh:mm:ss'
    });
</script>