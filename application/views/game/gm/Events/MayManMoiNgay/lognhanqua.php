<link rel="stylesheet" href="<?php echo base_url('assets/datetime/css/style.css'); ?>"/>
<link rel="stylesheet" href="<?php echo base_url('assets/datetime/css/bootstrap.css'); ?>"/>
<div id="content-t" style="min-height:500px; padding-top:10px">
    <style>
        #loading {width: 100%;height: 100%;top: 0px;left: 0px;position: fixed;display: block; z-index: 99;}
        #loading-image {position: absolute;top: 40%;left: 45%;z-index: 100} 
        label {width: auto !important;color: #f36926;}
    </style>
    <script type="text/javascript">
        $(document).ready(function () {
            $('.datetimer').datetimepicker({
                dateFormat: 'yy-mm-dd',
                timeFormat: 'hh:mm:ss'//
            });
            getData();
        });

        function getData() {
            $('#data_table').dataTable({
                "aaData": <?php echo $logs;?>
                ,
                aoColumns: [
                    {
                        sTitle: "Mã giao dịch",
                        mData: "id"
                    },
                    {
                        sTitle: "MoboID",
                        mData: "mobo_id"
                    },
                    {
                        sTitle: "MSI",
                        mData: "mobo_service_id"
                    },
                    {
                        sTitle: "Character name",
                        mData: "character_name"
                    },
                    {
                        sTitle: "Server ID",
                        mData: "server_id"
                    },

                    {
                        sTitle: "Item",
                        mData: "items"
                    },
                    {
                        sTitle: "Ngày đổi",
                        mData: "created_time"
                    }

                ],
                bProcessing: true,

                bPaginate: true,

                bJQueryUI: false,

                bAutoWidth: false,

                bSort: false,
                bRetrieve: true,
                bDestroy: true,
                "scrollX": true,
                sPaginationType: "full_numbers"
            });
        }


    </script>
    
    <!-- Content -->
    <div id="content">
        <!-- Content wrapper -->
        <div class="wrapper">                     
            <?php include 'tab.php'; ?>
            <div class="widget-name">
                <div class="clearboth"></div>
            </div>


            <div>
                <form style="margin: 20px;" class="form-inline" method="post" action="/?control=shopuydanh&func=exportLogDoiQua&module=all#logdoiqua">
                    <div class="form-group">
                        <input type="text" class="form-control datetimer" name="date_start" placeholder="Ngày bắt đầu">
                    </div>
                    <div class="form-group">
                        <input type="text" class="form-control datetimer" name="date_end" placeholder="Ngày kết thúc">
                    </div>
                    <div style="position: absolute;left: 428px;top: 109px;"><button type="submit" class="btn btn-primary">Xuất Excel</button></div>
                </form>
            </div>

            <!--END CONTROL ADD CHEST-->
            <div class="widget" id="viewport">
                <div class="well form-horizontal">
                <div class="table-overflow">
                    <table class="table table-striped table-bordered" id="data_table">
                    </table>
                </div>
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
<script type="text/javascript">
    (new TableDnD).init("tblsort");
</script>