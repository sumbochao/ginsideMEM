<link rel="stylesheet" href="<?php echo base_url('assets/datetime/css/style.css'); ?>"/>
<link rel="stylesheet" href="<?php echo base_url('assets/datetime/css/bootstrap.css'); ?>"/>
<?php
    if($_SERVER['SERVER_ADDR']=='127.0.0.1'){
        $url_service = 'http://localhost.game.mobo.vn/hiepkhach/index.php';
        $img_url = 'http://localhost.game.mobo.vn/hiepkhach';
    }else{
        $url_service = 'http://game.mobo.vn/hiepkhach';
        $img_url = $url_service;
    }
?>
<div id="content-t" style="min-height:500px; padding-top:10px">
    <style>
        #loading {width: 100%;height: 100%;top: 0px;left: 0px;position: fixed;display: block; z-index: 99;}
        #loading-image {position: absolute;top: 40%;left: 45%;z-index: 100} 
        label {width: auto !important;color: #f36926;}
    </style>
    <script type="text/javascript">
        $(document).ready(function () {
            getData();
            $('#create').on('click', function () {
                window.location.href = '/?control=crosssale&func=add&view=listgame#listgame';
            });
        });

        function getData() {
            $.ajax({
                url: "<?php echo $url_service; ?>/cms/crosssale/index_listgame",
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
                                     sTitle: "Game ID",
                                     mData: "gameID"
                                 },
                               {
                                   sTitle: "Tên",
                                   mData: "name"
                               },
                                {
                                    sTitle: "Alias",
                                    mData: "alias",

                                },
                                {
                                    sTitle: "Picture",
                                    mData: "url",
                                    mRender: function (data) {
                                        if(data !=''){
                                            return "<img src='<?php echo $img_url; ?>" + data + "' width='100px' />";
                                        }else{
                                            return "";
                                        }
                                    }
                                },
                                {
                                    sTitle: "Trạng Thái",
                                    mData: "status",
                                    mRender: function (data) {
                                        return (data == 1) ? "<span style='color:green'>Enable</span>" : "<span style='color:red'>Disable</span>";
                                    }
                                },
                                {
                                    sTitle: "Ngày tạo",
                                    mData: "createDate",
                                },
                                {
                                    sTitle: "Tùy Chọn",
                                    mData: "idx",
                                    mRender: function (data) {
                                        return "<a class='btn btn-success btn-xs' href='/?control=crosssale&func=edit&id=" + data + "&view=listgame#listgame'>Chỉnh Sửa</a>\n\
                                                <a class='btn btn-danger btn-xs' onclick=\"if(!window.confirm('Bạn có muốn xóa không ?')) return false;\" href='/?control=crosssale&func=delete&id=" + data + "&view=listgame#listgame'>Xóa</a>";
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
            <?php include APPPATH . 'views/game/lk/Events/crosssale/tab.php'; ?>
            <div class="widget-name">
                <div class="clearboth"></div>
            </div>
            <!--END CONTROL ADD CHEST-->
            <div class="widget" id="viewport">
                <div class="well form-horizontal">
                <div class="table-overflow">     
                     <div style="margin-top: 10px; margin-bottom: 10px;">
                        <button id="create"  class="btn btn-primary"><span>THÊM MỚI</span></button>
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