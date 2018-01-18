<link rel="stylesheet" href="<?php echo base_url('assets/datetime/css/style.css'); ?>"/>
<link rel="stylesheet" href="<?php echo base_url('assets/datetime/css/bootstrap.css'); ?>"/>
<div id="content-t" style="min-height: 500px; padding-top: 10px">
    <style>
        #loading {
            width: 100%;
            height: 100%;
            top: 0px;
            left: 0px;
            position: fixed;
            display: block;
            z-index: 99;
        }

        #loading-image {
            position: absolute;
            top: 40%;
            left: 45%;
            z-index: 100;
        }

        label {
            width: auto !important;
            color: #f36926;
        }
    </style>
    <script type="text/javascript">
        $(document).ready(function() { 
            $('#add_room').on('click', function () {
                window.location.href = '/?control=dophuong_gm&func=themphong#quanlyphong';
            });
        });

        getData();
        function getData() {
            $.ajax({
                url: "http://game.mobo.vn/giangma/cms/tooldophuong/room_list",
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
                                     sTitle: "Tên Phòng",
                                     mData: "room_name"
                                 },
                               {
                                   sTitle: "Bắt Đầu",
                                   mData: "room_date_start"
                               },
                                {
                                    sTitle: "Kết Thúc",
                                    mData: "room_date_end",

                                },
                                {
                                    sTitle: "Lượt Quay Tối Đa",
                                    mData: "room_max_play",
                                     mRender: function (data) {
                                        return (data == 0) ? "<span style='color:green'>Không giới hạn</span>" : "<span style='color:red'>" + data + "</span>";
                                    }

                                },
                                {
                                    sTitle: "Trạng Thái",
                                    mData: "room_status",
                                    mRender: function (data) {
                                        return (data == 1) ? "<span style='color:green'>Enable</span>" : "<span style='color:red'>Disable</span>";
                                    }
                                },
                                {
                                    sTitle: "Tùy Chọn",
                                    mData: "id",
                                    mRender: function (data) {
                                        return "<a class='btn btn-success btn-xs' href='/?control=dophuong_gm&id=" + data + "&func=chinhsuaphong#quanlyphong'>Chỉnh Sửa</a>";
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
            <?php include APPPATH . 'views/game/gm/Events/DoPhuong/tab.php'; ?>
            <div class="widget-name">
                <div class="clearboth"></div>
            </div>

            <!--END CONTROL ADD CHEST-->
            <div class="widget" id="viewport">
                <div class="well form-horizontal">
                    <div class="table-overflow">
                        <div style="padding: 4px 8px">
                            <button id="add_room" class="btn btn-primary"><span>Thêm Phòng</span></button>
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
