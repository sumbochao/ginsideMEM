<link rel="stylesheet" href="<?php echo base_url('assets/datetime/css/style.css'); ?>"/>
<link rel="stylesheet" href="<?php echo base_url('assets/datetime/css/bootstrap.css'); ?>"/>
<?php
    if($_SERVER['SERVER_ADDR']=='127.0.0.1'){
        $url_service = 'http://localhost.game.mobo.vn/volam';
    }else{
        $url_service = 'http://game.mobo.vn/volam';
    }
?>
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
        #create{
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
                window.location.href = '/?control=gold_hours_lvl&func=excel&start='+start+'&end='+end+'&module=all';
            });
        });
        function getData() {
            $.ajax({
                url: "<?php echo $url_service; ?>/cms/goldhours/history",
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
                               sTitle: "From",
                               mData: "from",
                            },
                            {
                               sTitle: "To",
                               mData: "to",
                            },
                            {
                               sTitle: "Date",
                               mData: "date",
                            },
                            {
                               sTitle: "Result",
                               mData: "result",
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
            <?php include APPPATH . 'views/game/lvl/Events/goldhours/tab.php'; ?>
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
    $('input[name=start]').datetimepicker({
        dateFormat: 'dd-mm-yy',
        timeFormat: 'hh:mm:ss'//
    });
    $('input[name=end]').datetimepicker({
        dateFormat: 'dd-mm-yy',
        timeFormat: 'hh:mm:ss'//HH:mm:ss
    });
</script>
