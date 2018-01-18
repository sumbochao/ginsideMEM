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
            $('#create_reward').on('click', function () {
                window.location.href = '/?control=lol_event_goi_qua_vip&&module=all&func=themqua&tournament_id=' + $("#tournament").val() + '&pakage_id=' + $("#vip_gift_pakage").val() + '#quanlyqua';
            });
            
            $("#tournament").change(function () {             
                window.location.href = "/?control=lol_event_goi_qua_vip&module=all&func=quanlyqua&tournament_id=" + $("#tournament").val() + "#quanlyqua";                
            });
            
            $("#vip_gift_pakage").change(function () {             
                window.location.href = "/?control=lol_event_goi_qua_vip&module=all&func=quanlyqua&tournament_id=" + $("#tournament").val() + "&id=" + $("#vip_gift_pakage").val() + "#quanlyqua";              
            });
            
            //Load Tournament List
            $.ajax({
                method: "GET",
                url: "http://game.mobo.vn/lol/cms/toolvip/tournament_list",
                contentType: 'application/json; charset=utf-8',
                success: function (data) {                  
                    var obj = data["rows"];
                    var tourlist = "";
                    $.each(obj, function (key, value) {                       
                        tourlist += '<option value="' + value["id"] + '" >' + value["tournament_name"] + '</option>';
                    });

                    $("#tournament").html(tourlist);

                    var tournament_id = getParameterByName("tournament_id");
                    if (tournament_id !== null && tournament_id !== "") {                        
                        $("#tournament").val(tournament_id);
                    }
                    
                    get_vip_gift_pakage($("#tournament").val());
                    
                },
                error: function (data) {
                    var obj = $.parseJSON(data);
                }
            });
        });
        
        //Load VIP Gift Pakage
        function get_vip_gift_pakage(tournament_id) {
            $.ajax({
                method: "GET",
                url: "http://game.mobo.vn/lol/cms/toolvip/get_vip_gift_pakage?tournament_id=" + tournament_id,
                contentType: 'application/json; charset=utf-8',
                success: function (data) {                  
                    var obj = data["rows"];
                    var tourlist = "";
                    $.each(obj, function (key, value) {                       
                        tourlist += '<option value="' + value["id"] + '" >' + value["pakage_name"] + '</option>';
                    });

                    $("#vip_gift_pakage").html(tourlist);

                    var id = getParameterByName("id");
                    if (id !== null && id !== "") {                      
                        $("#vip_gift_pakage").val(id);
                    }
                    
                    getData($("#vip_gift_pakage").val());
                    
                },
                error: function (data) {
                    var obj = $.parseJSON(data);
                }
            });
        }
        

        function getData(pakage_id) {
            $.ajax({
                url: "http://game.mobo.vn/lol/cms/toolvip/get_vip_gift?pakage_id=" + pakage_id,
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
                                sTitle: "ID",
                                mData: "id"
                            },
                            {
                                sTitle: "Tên Quà",
                                mData: "name"
                            },                           
                            {
                                sTitle: "Activity",
                                mData: "activity"
                            }, 
                            {
                                sTitle: "Position",
                                mData: "position"
                            },
                            {
                                    sTitle: "Hình Ảnh",
                                    mData: "gift_img",
                                    mRender: function (data) {
                                        return "<img src='" + data + "' width='100px' />";
                                    }

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
                                    return "<a class='btn btn-success btn-xs' href='/?control=lol_event_goi_qua_vip&module=all&func=chinhsuaqua&tournament_id=" + $("#tournament").val() + "&pakage_id=" + $("#vip_gift_pakage").val() + "&id=" + data + "#quanlyqua'>Chỉnh Sửa</a>";
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
            return results === null ? "" : decodeURIComponent(results[1].replace(/\+/g, " "));
        }
    </script>

    <!-- Content -->
    <div id="content">
        <!-- Content wrapper -->
        <div class="wrapper">                     
<?php include APPPATH . 'views/game/lol/Events/vip/tab.php'; ?>
            <div class="widget-name">
                <div class="clearboth"></div>
            </div>

            <!--END CONTROL ADD CHEST-->
            <div class="widget" id="viewport">
                <div class="well form-horizontal">
                    <div class="table-overflow">     
                        <div style="margin-top: 10px; margin-bottom: 10px;">                           
                            Giải đấu: <select id="tournament" name="tournament" class="span4 validate[required]" /></select>  Gói quà: <select id="vip_gift_pakage" name="vip_gift_pakage" class="span4 validate[required]" /></select>                                                          
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