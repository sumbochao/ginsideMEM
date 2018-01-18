
<!-- Content container -->
<div id="container">
    <script type="text/javascript">
        $(document).ready(function() {
            
        });
        getData();
        function getData() {
            $.ajax({
                url: "http://service.mgh.mobo.vn/cms/toolconsomayman2/getResultLottery",
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
                                    sTitle: "Mã GD",
                                    mData: "id"
                                },
                                {
                                    sTitle: "Tất cả",
                                    mData: "tatca"

                                },
                                {
                                    sTitle: "Ngày sổ",
                                    mData: "date"
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

           
            <style type="text/css" media="screen">
                .tabs a{float: left;color: #000;font-size: 14px;width: 15%;}
                .clearboth{clear:both;width: 100%;height:0;display: block;content:"";}
                .green,.red{font-weight: bold;}
                .green{color:green;}
                .red{color:red;}
            </style>

            <?php include APPPATH . '/views/events/soxo/nav.php'; ?>

            <!--END CONTROL ADD CHEST-->

            <div class="widget" id="viewport">                
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
        <!-- /content wrapper -->
    </div>
    <!-- /content -->
</div>
    
    




