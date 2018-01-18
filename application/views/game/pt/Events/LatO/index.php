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
            $('#create_boxitem').on('click', function () {
                window.location.href = '/?control=event_lato_pt&func=productbox';
            });
            $('.clearcached').on('click', function () {
                window.location.href = 'http://game.mobo.vn/phongthan/cms/promotion_lato/clearMemcacheBox';
            });
        });
        getData();
        function getData() {
            $(".loading").fadeIn("fast");
            $.ajax({
                url: "http://game.mobo.vn/phongthan/cms/promotion_lato/boxitembinding",
                dataType: 'jsonp',
                method: "POST",
                bRetrieve: true,
                bDestroy: true,
                error: function (jqXHR, textStatus, errorThrown) {
                },
                success: function (data, textStatus, jqXHR) {
                    $('#data_table').dataTable({
                        //"language": {
                           // "url": "//ginside.mobo.vn/libraries/datatable/Vietnamese.json"
                       // },
                        "aaData": data.rows
                        ,
                        aoColumns: [
                               {
                                   sTitle: "Tên Item",
                                   mData: "item_name"
                               },
								{
								    sTitle: "Item ID",
								    mData: "item_id"
								},
								{
								    sTitle: "Số Lượng",
								    mData: "item_count"
								},
                                {
                                    sTitle: "Hình Ảnh",
                                    mData: "item_url",
                                    mRender: function (data) {
                                        return "<img src='" + data + "' width='100px' height='100px' />";
                                    }

                                },
                                 {
                                     sTitle: "Tỉ lệ",
                                     mData: "start_mount",
                                 }
                                ,
                                 {
                                     sTitle: "Ngày Thêm",
                                     mData: "insertdate"
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
                                         return "<a class='btn btn-success btn-xs' href='/?control=event_lato_pt&func=productboxediting&ids=" + data + "#home'>Chỉnh Sửa</a>";
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

                    $(".loading").fadeOut("fast");
                }
            });
        }

    </script>
    
    <!-- Content -->
    <div id="content">
        <!-- Content wrapper -->
        <div class="wrapper">                     
            <?php include APPPATH . 'views/game/pt/Events/LatO/tab.php'; ?>
            <div class="widget-name">
                
               <!-- <div class="tabs">
                   <a href="/cms/ep/promotion_lato/thongke"><i class=" ico-th-large"></i>THỐNG KÊ</a> 
                   <a href="/cms/ep/promotion_lato/tralogdoiqua"><i class=" ico-th-large"></i>TRA LOG ĐỔI QUÀ</a>
				   <a href="javascript:void(0);" class="clearcached"><i class=" ico-th-large"></i>CLEAR MENCACHED</a>
                </div>-->
                <div class="clearboth"></div>
            </div>

            <!--END CONTROL ADD CHEST-->

            <div class="widget" id="viewport">
                <div class="well form-horizontal">
                <div class="table-overflow">
                <div style="margin-top: 10px; margin-bottom: 10px;">
                        <button id="create_boxitem"  class="btn btn-primary"><span>THÊM MỚI ITEM</span></button>
                    </div>                   
                    <table class="table table-striped table-bordered" id="data_table">      
                    </table>
                </div>
                 <div class="table-overflow">
<!--                <div style="border-top:1px solid #d5d5d5;padding: 4px 8px">
                        <a href="#" class="base_icons" onclick="_SO.onRefresh();"><img src="/libraries/images/16/view_refresh.png"></a>
                    </div>                    -->
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