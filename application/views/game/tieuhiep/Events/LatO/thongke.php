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
        });
        getData();

        function getData() {
            $.ajax({
                url: "http://game.mobo.vn/tieuhiep/cms/promotion_lato/thongkepri",
                dataType: 'jsonp',
                method: "POST",
                bRetrieve: true,
                bDestroy: true,
                error: function (jqXHR, textStatus, errorThrown) {
                },
                success: function (data, textStatus, jqXHR) {
                    $('#data_table').dataTable({
                        "language": {
                            "url": "//ginside.mobo.vn/libraries/datatable/Vietnamese.json"
                        },
                        "aaData": data.rows
                        ,
                        aoColumns: [
                               {
                                   sTitle: "MSI",
                                   mData: "username"
                               },
                                {
                                    sTitle: "UID",
                                    mData: "uid",

                                },
                                {
                                    sTitle: "Card Value",
                                    mData: "cardvalue",
                                }
                                , {
                                    sTitle: "Card Type",
                                    mData: "cardtype",
                                }
                                , {
                                    sTitle: "TransIDCard",
                                    mData: "tranidcard",
                                }
                                , {
                                    sTitle: "Messages",
                                    mData: "mess",
                                }
                                ,
                                 {
                                     sTitle: "InsertDate",
                                     mData: "insertdate"
                                 },
                                 {
                                     sTitle: "Status",
                                     mData: "status",
                                     mRender: function (data) {
                                         return (data == 1) ? "<span style='color:green'>success</span>" : "<span style='color:red'>Failed</span>";
                                     }

                                 },
                                 {
                                     sTitle: "Type Payment",
                                     mData: "from"

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
            <?php include APPPATH . 'views/game/tieuhiep/Events/LatO/tab.php'; ?>
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