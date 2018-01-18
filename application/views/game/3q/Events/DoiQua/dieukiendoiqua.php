<link rel="stylesheet" href="<?php echo base_url('assets/datetime/css/style.css'); ?>"/>
<link rel="stylesheet" href="<?php echo base_url('assets/datetime/css/bootstrap.css'); ?>"/>
<div id="content-t" style="min-height:500px; padding-top:10px">
    <style>
        #loading {width: 100%;height: 100%;top: 0px;left: 0px;position: fixed;display: block; z-index: 99;}
        #loading-image {position: absolute;top: 40%;left: 45%;z-index: 100} 
        label {width: auto !important;color: #f36926;}
    </style>
    <script type="text/javascript">
         var gift_id = getParameterByName("id");
        $(document).ready(function () {            
            $('#add_condition').on('click', function () {
                window.location.href = '/?control=doiqua_3q&func=themdieukien&id=' + gift_id + '&module=all#quanlyqua';
            });
            $('#comeback').on('click', function () {               
                window.history.go(-1); return false;
            });           
            load_gift_detail(gift_id);
            getData(gift_id);
        });
        
        function load_gift_detail(gift_id){
            $.ajax({
                method: "GET",
                url: "http://game.mobo.vn/3q/cms/tooldoiqua/load_gift_details?id=" + gift_id,
                contentType: 'application/json; charset=utf-8',
                success: function (data) {                    
                    $("#gift_name").html(data[0]["gift_name"]);
                    $("#gift_quantity").html(data[0]["gift_quantity"]);                    
                },
                error: function (data) {
                    var obj = $.parseJSON(data);
                }
            });
        }

        function getData(gift_id) {
            $.ajax({
                    url: "http://game.mobo.vn/3q/cms/tooldoiqua/gift_list_condition?id=" + gift_id,
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
                                sTitle: "Số lượng",
                                mData: "gift_quantity"
                            },                           
//                            {
//                                sTitle: "Server List",
//                                mData: "server_list"
//                            },
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
                                    return "<a href='/?control=doiqua_3q&func=chinhsuadieukien&id=" + data  + "&gift_id=" + gift_id + "&module=all#quanlyqua'>Chỉnh Sửa</a>";
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
            <?php include APPPATH . 'views/game/3q/Events/DoiQua/tab.php'; ?>
            <div class="widget-name">
                <div class="clearboth"></div>
            </div>

            <!--END CONTROL ADD CHEST-->
            <div class="widget" id="viewport">
                <div class="well form-horizontal">  
                    <div style="border-bottom:1px solid #d5d5d5;padding: 4px 8px">Điều kiện đổi: <span style="color: #2758a8; font-weight: bold;" id="gift_name"></span> x<span id="gift_quantity"></span>  
                        <button id="comeback" class="btn btn-primary"><span>Quay lại</span></button> 
                    <button id="add_condition" class="btn btn-primary"><span>Thêm Điều Kiện</span></button></div>    
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