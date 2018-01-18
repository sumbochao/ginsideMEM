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

            $('#create_reward').on('click', function () {
                window.location.href = '/?control=event_covu_pt&func=themqua#quanlyqua';
            });
        });

        function getData() {
            $.ajax({
                url: "http://game.mobo.vn/acdau/cms/toolhailoc/gift_list",
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
                                sTitle: "Item Id",
                                mData: "item_id"
                            },
                                 {
                                     sTitle: "Tên Quà",
                                     mData: "gift_name"
                                 },
                                {
                                    sTitle: "Hình Ảnh",
                                    mData: "gift_img",
                                    mRender: function (data) {
                                        return "<img src='" + data + "' width='100px' />";
                                    }

                                },
                               {
                                   sTitle: "Điểm Đổi",
                                   mData: "gift_price"
                               },
                               {
                                   sTitle: "Số lượng",
                                   mData: "gift_quantity"
                               },
                                {
                                    sTitle: "Thời Gian Thêm",
                                    mData: "gift_insert_date"
                                },
                                {
                                    sTitle: "Trạng Thái",
                                    mData: "gift_status",
                                    mRender: function (data) {
                                        return (data == 1) ? "<span style='color:green'>Enable</span>" : "<span style='color:red'>Disable</span>";
                                    }
                                },
                                {
                                    sTitle: "Tùy Chọn",
                                    mData: "id",
                                    mRender: function (data) {
                                        return "<a class='btn btn-success btn-xs' href='/?control=event_covu_pt&func=chinhsuaqua&id=" + data + "#quanlyqua'>Chỉnh Sửa</a>";
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
            <?php include APPPATH . 'views/game/ad/Events/HaiLoc/tab.php'; ?>
            <div class="widget-name">
                <div class="clearboth"></div>
            </div>

            <!--END CONTROL ADD CHEST-->
            <div class="widget" id="viewport">
                <div class="well form-horizontal">
                <div class="table-overflow">     
                     <div style="margin-top: 10px; margin-bottom: 10px;">
                        <button id="create_reward"  class="btn btn-primary"><span>THÊM QUÀ MỚI</span></button>
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
<script type="text/javascript">
    (new TableDnD).init("tblsort");
</script>