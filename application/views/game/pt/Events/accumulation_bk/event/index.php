<link rel="stylesheet" href="<?php echo base_url('assets/datetime/css/style.css'); ?>"/>
<link rel="stylesheet" href="<?php echo base_url('assets/datetime/css/bootstrap.css'); ?>"/>
<div id="content-t" style="min-height:500px; padding-top:10px">
    <style>
        #loading {width: 100%;height: 100%;top: 0px;left: 0px;position: fixed;display: block; z-index: 99;}
        #loading-image {position: absolute;top: 40%;left: 45%;z-index: 100} 
        label {width: auto !important;color: #f36926;}
    </style>
    <?php
        if($_SERVER['SERVER_ADDR']=='127.0.0.1'){
            $url_service = 'http://localhost.service.phongthan.mobo.vn';
        }else{
            $url_service = 'http://service.phongthan.mobo.vn';
        }
    ?>
    <script type="text/javascript">
        $(document).ready(function () {
            getData();

            $('#create_tournament').on('click', function () {
                window.location.href = '/?control=phongthan_event&func=add_event#event';
            });
        });

        function getData() {
            $.ajax({
                url: "<?php echo $url_service; ?>/cms/accumulation/index_event",
                dataType: 'jsonp',
                method: "POST",
                bRetrieve: true,
                bDestroy: true,
                error: function (jqXHR, textStatus, errorThrown) {
                },
                success: function (data, textStatus, jqXHR) {
                    $('#data_table').dataTable({
                        
                        "aaData": data.rows
                        ,
                        aoColumns: [
                                 {
                                     sTitle: "Tên sự kiện",
                                     mData: "name"
                                 },
                                 {
                                    sTitle: "Nội dung",
                                    mData: "content_id",

                                },
                               {
                                   sTitle: "Bắt Đầu",
                                   mData: "start"
                               },
                                {
                                    sTitle: "Kết Thúc",
                                    mData: "end",

                                },
                                {
                                    sTitle: "Trạng Thái",
                                    mData: "status",
                                    mRender: function (data) {
                                        return (data == 1) ? "<span style='color:green'>Enable</span>" : "<span style='color:red'>Disable</span>";
                                    }
                                },
                                {
                                    sTitle: "Tùy Chọn",
                                    mData: "id",
                                    mRender: function (data) {
                                        return "<a class='btn btn-success btn-xs' href='/?control=phongthan_event&func=add_event&id=" + data + "#event'>Chỉnh Sửa</a>";
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
            <?php include APPPATH . 'views/game/pt/Events/accumulation/tab.php'; ?>
            <div class="widget-name">
                <div class="clearboth"></div>
            </div>

            <!--END CONTROL ADD CHEST-->
            <div class="widget" id="viewport">
                <div class="well form-horizontal">
                <div class="table-overflow">     
                     <div style="margin-top: 10px; margin-bottom: 10px;">
                        <button id="create_tournament"  class="btn btn-primary"><span>THÊM MỚI SỰ KIỆN</span></button>
                    </div>                               
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