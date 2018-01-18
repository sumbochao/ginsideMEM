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
            $('#export_excel').on('click', function () {
                window.location.href = "http://service.eden.mobo.vn/cms/toolloandauvodai/export_excel_logthamgia";
            });

            getData();
        });

        function getData() {
            $(".loading").fadeIn("fast");
            $.ajax({
                url: "http://service.eden.mobo.vn/cms/toolloandauvodai/get_join_history?pagesize=10000",
                dataType: 'jsonp',
                method: "POST",
                bRetrieve: true,
                bDestroy: true,
                error: function (jqXHR, textStatus, errorThrown) {
                },
                success: function (data, textStatus, jqXHR) {
                    //console.log(data);
                    $('#data_table').dataTable({
                        "language": {
                            "url": "//ginside.mobo.vn/libraries/datatable/Vietnamese.json"
                        },
                        "aaData": data
                        ,
                        aoColumns: [
                                {
                                   sTitle: "Character ID",
                                   mData: "RoleID"
                               },
                               {
                                   sTitle: "Nhân Vật",
                                   mData: "RoleName"
                               },
                                 {
                                     sTitle: "Server",
                                     mData: "ServerID"
                                 }
                                 ,
                                 {
                                     sTitle: "Thời Gian",
                                     mData: "StartDate"
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

                    $(".loading").fadeOut("fast");
                }
            });
        }

        function getParameterByName(name) {
            name = name.replace(/[\[]/, "\\[").replace(/[\]]/, "\\]");
            var regex = new RegExp("[\\?&]" + name + "=([^&#]*)"),
                results = regex.exec(location.search);
            return results == null ? "" : decodeURIComponent(results[1].replace(/\+/g, " "));
        }

    </script>
    
    <!-- Content -->
    <div id="content">
        <!-- Content wrapper -->
        <div class="wrapper">                     
            <?php include APPPATH . 'views/game/eden/Events/LoanDauVoDai/tab.php'; ?>
            <div class="widget-name">
                <div class="clearboth"></div>
            </div>

            <!--END CONTROL ADD CHEST-->
            <div class="widget" id="viewport">
                <div class="well form-horizontal">
                    <table style="margin-bottom: 10px;" cellspacing="0" cellpadding="4">
                        <tr>                            
                            <td><button id="export_excel" class="btn btn-success"><span>EXPORT EXCEL</span></button></td>
                        </tr>                       
                    </table>
                    
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