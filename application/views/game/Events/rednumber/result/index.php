<link rel="stylesheet" href="<?php echo base_url('assets/datetime/css/style.css'); ?>"/>
<link rel="stylesheet" href="<?php echo base_url('assets/datetime/css/bootstrap.css'); ?>"/>
<div id="content-t" style="min-height:500px; padding-top:10px">
    <style>
        #loading {width: 100%;height: 100%;top: 0px;left: 0px;position: fixed;display: block; z-index: 99;}
        #loading-image {position: absolute;top: 40%;left: 45%;z-index: 100} 
        label {width: auto !important;color: #f36926;}
        #data_table input{
            margin-bottom: 0px;
            text-align: center;
        }
    </style>
    <script type="text/javascript">
        $(document).ready(function () {
            getData();
            $('#create').on('click', function () {
                window.location.href = '/?control=rednumber&func=add&view=<?php echo $_GET['view'];?>&module=all&tid=<?php echo $_GET['tid'];?>&iframe=1';
            });
            $('#onSubmit').on('click', function () {
                $.ajax({
                    type: "POST",
                    dataType: 'jsonp',
                    url: "<?php echo $url_service;?>/cms/rednumber/edit_result",
                    data: $("#frmSendChest").serializeArray(),
                    beforeSend: function () {
                        $(".loading").fadeIn("fast");
                    }
                }).done(function (result) {
                    location.reload(); 
                });
            });
        });
        function getData() {
            $.ajax({
                url: "<?php echo $url_service; ?>/cms/rednumber/index_<?php echo $_GET['view'];?>?tid=<?php echo $_GET['tid'];?>&game=<?php echo $_SESSION['account']['id_group']==2?$game_id:'';?>",
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
                               sTitle: "ID",
                               mData: "id",
                            },
                            {
                               sTitle: "Tên giải thưởng",
                               mData: "name_prize",
                            },
                            {
                               sTitle: "Kết quả",
                               mData: "value",
                               mRender: function (data,avg1,avg) {
                                   var xhtml='';
                                   xhtml = '<input type="text" name="kt_value['+avg.id+']" value="'+avg.value+'"/>';
                                   return xhtml;
                               }
                            },
                            {
                               sTitle: "Tùy Chọn",
                               mData: "id",
                               mRender: function (data) {
                                   return "<a class='btn btn-danger btn-xs' onclick=\"if(!window.confirm('Bạn có muốn xóa không ?')) return false;\" href='/?control=rednumber&func=delete&view=<?php echo $_GET['view'];?>&module=all&id=" + data + "&tid=<?php echo $_GET['tid'];?>&iframe=1&game=<?php echo $_SESSION['account']['id_group']==2?$game_id:'';?>'>Xóa</a>";
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
            <div class="widget-name">
                <div class="clearboth"></div>
            </div>
            <!--END CONTROL ADD CHEST-->
            <div class="widget" id="viewport">
                <div class="well form-horizontal">
                    <div class="table-overflow"> 
                        <form id="frmSendChest" name="frmSendChest" action="" method="POST" onsubmit="return false;" autocomplete="off">
                            <div style="margin-top: 10px; margin-bottom: 10px;">
                                <button id="onSubmit" class="btn btn-primary"><span>CẬP NHẬT</span></button>
                                <button id="create"  class="btn btn-primary"><span>THÊM MỚI</span></button>
                            </div>
                            <table class="table table-striped table-bordered" id="data_table"></table>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!-- /content wrapper -->
    </div>
    <!-- /content -->
</div>