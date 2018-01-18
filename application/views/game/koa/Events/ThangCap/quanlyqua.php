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
                window.location.href = '/?control=thangcap_koa&func=themqua&tournament_id=' + $("#tournament").val() + "&module=all#quanlyqua" ;
            });
            
            //Load Tournament List
            $.ajax({
                method: "GET",
                url: "http://game.mobo.vn/lucgioi/cms/toolthangcap/tournament_list",
                contentType: 'application/json; charset=utf-8',
                success: function (data) {                  
                    var obj = data["rows"];
                    var tourlist = "";
                    $.each(obj, function (key, value) {                       
                        tourlist += '<option value="' + value["id"] + '" >' + value["tournament_name"] + '</option>';
                    });

                    $("#tournament").html(tourlist);

                    //Load Gift List
                    getData($("#tournament").val());
                },
                error: function (data) {
                    var obj = $.parseJSON(data);
                }
            });
            
             $("#tournament").change(function () {             
                window.location.href = "/?control=thangcap_koa&func=quanlyqua&tournament_id=" + $(this).val() + "&module=all#quanlyqua";
            });
        });
        
        function getData(tournament_id) {
            $.ajax({
                url: "http://game.mobo.vn/lucgioi/cms/toolthangcap/gift_list?tournament_id=" + tournament_id,
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
                               {
                                   sTitle: "Level yêu cầu",
                                   mData: "gift_required_level"
                               }, 
                               {
                                   sTitle: "Server List",
                                   mData: "gift_server_list"
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
                                        return "<a href='/?control=thangcap_koa&func=chinhsuaqua&id=" + data + "&tournament_id="+ $("#tournament").val() +"&module=all#quanlyqua'>Chỉnh Sửa</a>";
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
            <?php include APPPATH . 'views/game/koa/Events/ThangCap/tab.php'; ?>
            <div class="widget-name">
                <div class="clearboth"></div>
            </div>

            <!--END CONTROL ADD CHEST-->
            <div class="widget" id="viewport">
                <div class="well form-horizontal">
                <div style="border-top:1px solid #d5d5d5;padding: 4px 8px">                     
                            Giải đấu: <select id="tournament" name="tournament" class="span4 validate[required]" /></select> <button id="add_gift"  class="base_button base_green base-small-border-radius"><span>Thêm Quà Mới</span></button>
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