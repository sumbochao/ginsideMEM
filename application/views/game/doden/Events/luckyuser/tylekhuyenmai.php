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
            getData();
        });
        function getData() {
            $.ajax({
                url: "https://sev.bai88.net/event/tool_luckyuser/get_discounted_rate",
                dataType: 'jsonp',
                method: "POST",
                bRetrieve: true,
                bDestroy: true,
                error: function (jqXHR, textStatus, errorThrown) {
                },
                success: function (data, textStatus, jqXHR) {
                    console.log(data);
                    $('#data_table').dataTable({
                        "language": {
                            "url": "//ginside.mobo.vn/libraries/datatable/Vietnamese.json"
                        },
                        "aaData": data
                        ,
                        aoColumns: [
                                {
                                    sTitle: "STT",
                                    mData: "id"
                                },
                                {
                                    sTitle: "Tỷ Lệ Khuyến Mãi",
                                    mData: "discounted_rate"
                                },
                                
                                {
                                    sTitle: "Tần Suất ",
                                    mData: "percentage"
                                },
                                {
                                    sTitle: "Tùy Chọn",
                                    mData: "id",
                                    mRender: function (data) {
                                        return "<a class='btn btn-success btn-xs' href='/?control=doden_luckyuser&module=all&func=chinhsuatyle&id=" + data + "#giaidau'>Chỉnh Sửa</a>";
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
            <?php include APPPATH . 'views/game/doden/Events/luckyuser/tab.php'; ?>
            <div class="widget-name">
                <div class="clearboth"></div>
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