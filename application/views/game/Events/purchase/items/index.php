<link rel="stylesheet" href="<?php echo base_url('assets/datetime/css/style.css'); ?>"/>
<link rel="stylesheet" href="<?php echo base_url('assets/datetime/css/bootstrap.css'); ?>"/>
<script src="<?php echo base_url('assets/datetime/js/currency.js'); ?>"></script>
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
                window.location.href = '/?control=purchase&func=add&view=<?php echo $_GET['view'];?>&module=all&game=<?php echo $_GET['game'];?>';
            });
        });
        function getData() {
            $.ajax({
                url: "<?php echo $url_service; ?>/cms/purchase/index_<?php echo $_GET['view'];?>?game=<?php echo $_GET['game'];?>",
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
                               sTitle: "Name",
                               mData: "name",
                            },
                            {
                               sTitle: "Buy Min",
                               mData: "buymin",
                            },
                            {
                               sTitle: "Price",
                               mData: "price",
                               mRender: function (data) {
                                    var price;
                                    if(data>0){
                                        price = FormatNumber(data);
                                    }else{
                                        price = 0;
                                    }
                                   return price;
                               }
                            },
                            {
                               sTitle: "Percent",
                               mData: "percent",
                            },
							{
                               sTitle: "Được bán",
                               mData: "issell",
                               mRender: function (data) {
                                    var issell ='';
                                    switch(data){
                                        case "-1":
                                            issell = 'Khởi tạo';
                                            break;
                                        case "0":
                                            issell = 'Không đồng ý bán';
                                            break;
                                        case "1":
                                            issell = 'Đồng ý bán';
                                            break;
                                    }
                                   return issell;
                               }
                            },
                            {
                               sTitle: "Start",
                               mData: "start",
                            },
                            {
                               sTitle: "End",
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
                                   return "<a class='btn btn-success btn-xs' href='/?control=purchase&func=edit&view=<?php echo $_GET['view'];?>&module=all&id=" + data + "&game=<?php echo $_GET['game'];?>'>Sửa</a>\n\
                                           <a class='btn btn-danger btn-xs' onclick=\"if(!window.confirm('Bạn có muốn xóa không ?')) return false;\" href='/?control=purchase&func=delete&view=<?php echo $_GET['view'];?>&module=all&id=" + data + "&game=<?php echo $_GET['game'];?>'>Xóa</a>";
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
            <?php include APPPATH . 'views/game/Events/purchase/tab.php'; ?>
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
                        <table class="table table-striped table-bordered" id="data_table"></table>
                    </div>
                </div>
            </div>
        </div>
        <!-- /content wrapper -->
    </div>
    <!-- /content -->
</div>