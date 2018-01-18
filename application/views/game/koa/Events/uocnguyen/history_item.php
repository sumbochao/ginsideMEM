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
            width: 1200px;
        }
        #create,#search{
            position: relative;
            top:-5px;
        }
    </style>
    <script type="text/javascript">
        $(document).ready(function () {
            getData();
            $('#create').on('click', function () {
                var start = $("input[name=start]").val();
                var end = $("input[name=end]").val();
                var server_id = $("select[name=server_id]").val();
                window.location.href = '/?control=uocnguyen_koa&func=excel_history_item&module=all&server_id='+server_id+'&start='+start+'&end='+end;
            });
            $("#search").on('click', function () {
                var start = $("input[name=start]").val();
                var end = $("input[name=end]").val();
                var server_id = $("select[name=server_id]").val();
                window.location.href = '/?control=uocnguyen_koa&func=history_item&module=all&server_id='+server_id+'&start='+start+'&end='+end;
            });
        });
        function getData() {
            $.ajax({
                url: "<?php echo $url_service; ?>/cms/uocnguyen/history_item?server_id=<?php echo $_POST['server_id'];?>&start=<?php echo strtotime($_POST['start']);?>&end=<?php echo strtotime($_POST['end']);?>",
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
                                sTitle: "Username",
                                mData: "mobo_id"
                            },
                            {
                              sTitle: "Mobo Service ID",
                              mData: "mobo_service_id",
                            },
                            {
                               sTitle: "Server ID",
                               mData: "server_id",
                            },
                            {
                               sTitle: "Event",
                               mData: "event_name",
                            },
                            {
                               sTitle: "Thần",
                               mData: "than_name",

                            },
                            {
                               sTitle: "Item",
                               mData: "item_id",
                            },
                            {
                               sTitle: "Type",
                               mData: "type",
                            },
                            {
                               sTitle: "Date",
                               mData: "created_date",
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
                    <div class="table-overflow">     
                         <div style="margin-top: 10px; margin-bottom: 10px;">
                             <form action="" method="post">
                            <select name="server_id">
                                <option value="">Chọn server</option>
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
                            <input type="text" class="datetimer" name="start" value="<?php echo (!empty($_POST['start']))?$_POST['start']:date('d-m-Y H:i:s',  strtotime('-14 day'));?>"/>
                            <input type="text" class="datetimer" name="end" value="<?php echo (!empty($_POST['end']))?$_POST['end']:date('d-m-Y H:i:s',time());?>"/>
                            <input type="submit" name="search" id="search" class="btn btn-primary"value="Tìm">
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
