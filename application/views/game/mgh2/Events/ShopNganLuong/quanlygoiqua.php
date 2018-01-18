<link rel="stylesheet" href="<?php echo base_url('assets/datetime/css/style.css'); ?>"/>
<link rel="stylesheet" href="<?php echo base_url('assets/datetime/css/bootstrap.css'); ?>"/>
<div id="content-t" style="min-height:500px; padding-top:10px">
    <style>
        #loading {width: 100%;height: 100%;top: 0px;left: 0px;position: fixed;display: block; z-index: 99;}
        #loading-image {position: absolute;top: 40%;left: 45%;z-index: 100} 
        label {width: auto !important;color: #f36926;}
    </style>
    <script type="text/javascript">
        $(document).ready(function() { 
            $('#add_gift').on('click', function () {
                window.location.href = '/?control=shopnganluong_mgh2&func=themgoiqua&type=' + $("#gifttype").val() + "&module=all#quanlygoiqua";
            });
            
            //Load Gift Type
            $.ajax({
                method: "GET",
                url: "http://game.mobo.vn/mgh2/cms/toolshopnganluong/gift_type_list_pakage",
                contentType: 'application/json; charset=utf-8',
                success: function (data) {
                    var obj = data["rows"];
                    var tourlist = '';
                    $.each(obj, function (key, value) {
                        tourlist += '<option value="' + value["id"] + '" >' + value["type_name"] + '</option>';
                    });

                    $("#gifttype").html(tourlist);

                    if (getParameterByName("type") != "") {
                        getData(getParameterByName("type"));
                        $("#gifttype").val(getParameterByName("type"));                     
                    }
                    else {
                        getData($("#gifttype").val());                       
                    }
                },
                error: function (data) {
                    var obj = $.parseJSON(data);
                }
            });
            
             $("#gifttype").change(function () {             
                window.location.href = "/?control=shopnganluong_mgh2&func=quanlygoiqua&type=" + $(this).val() + "&module=all#quanlygoiqua";
            });
        });
        
        function getData(type_id) {
            $.ajax({
                url: "http://game.mobo.vn/mgh2/cms/toolshopnganluong/gift_list_pakage?id=" + type_id,
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
                                     sTitle: "Tên Quà",
                                     mData: "gift_name"
                                 },
                                {
                                    sTitle: "Hình Ảnh",
                                    mData: "gift_img",
                                    mRender: function (data) {
                                        return "<img src='" + data + "' width='205px' />";
                                    }

                                },
                               {
                                   sTitle: "Điểm Đổi",
                                   mData: "gift_price"
                               },   
                               {
                                   sTitle: "Yêu Cầu VIP",
                                   mData: "gift_vip_point",
                                   mRender: function (data) {
                                       if(data == 0){
                                           return "VIP 01";
                                       }
                                       if(data == 270){
                                           return "VIP 02";
                                       }
                                       if(data == 540){
                                           return "VIP 03";
                                       }
                                       if(data == 2700){
                                           return "VIP 04";
                                       }
                                       if(data == 5500){
                                           return "VIP 05";
                                       }
                                       if(data == 10500){
                                           return "VIP 06";
                                       }
                                       if(data == 21000){
                                           return "VIP 07";
                                       }
                                       if(data == 41250){
                                           return "VIP 08";
                                       }
                                       if(data == 82500){
                                           return "VIP 09";
                                       }
                                       if(data == 165000){
                                           return "VIP 10";
                                       }
                                       if(data == 330000){
                                           return "VIP 11";
                                       }
                                       if(data == 660000){
                                           return "VIP 12";
                                       }
                                   }
                               },
                               {
                                   sTitle: "Yêu Cầu Mua Gói",
                                   mData: "gift_number_request"
                               },    
                               {
                                   sTitle: "Server",
                                   mData: "server_list",
                                   mRender: function (data) {
                                       return "<textarea readonly type='text' class='span3' style='margin: 0px; width: 200px; height: 60px;'>" + data + "</textarea>";
                                   }
                               },
                                {
                                    sTitle: "Bắt Đầu",
                                    mData: "gift_date_start"
                                },
                                {
                                    sTitle: "Kết Thúc",
                                    mData: "gift_date_end"
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
                                        return "<a href='/?control=shopnganluong_mgh2&func=chinhsuagoiqua&id=" + data + "&type="+ $("#gifttype").val() +"&module=all#quanlygoiqua'>Chỉnh Sửa</a>";
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
            <?php include APPPATH . 'views/game/mgh2/Events/ShopNganLuong/tab.php'; ?>
            <div class="widget-name">
                <div class="clearboth"></div>
            </div>

            <!--END CONTROL ADD CHEST-->
            <div class="widget" id="viewport">
                <div class="well form-horizontal">
                    <div style="border-top:1px solid #d5d5d5;padding: 4px 8px">
                        <select id="gifttype" name="gifttype" class="span4 validate[required]"></select> <button id="add_gift"  class="base_button base_green base-small-border-radius"><span>Thêm Gói Quà Mới</span></button>
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
        </div>
        <!-- /content wrapper -->
    </div>
    <!-- /content -->
</div>
<script type="text/javascript">
    (new TableDnD).init("tblsort");
</script>