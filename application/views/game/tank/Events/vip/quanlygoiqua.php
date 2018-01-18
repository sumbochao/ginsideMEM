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
                window.location.href = '/?control=tank_event_goi_qua_vip&&module=all&func=themgoiqua&tournament_id=' + $("#tournament").val() + '#quanlygoiqua';
            });
            
             $("#tournament").change(function () {             
                window.location.href = "/?control=tank_event_goi_qua_vip&module=all&func=quanlygoiqua&tournament_id=" + $(this).val() + "#quanlygoiqua";
            });
            
              //Load Tournament List
            $.ajax({
                method: "GET",
                url: "http://game.mobo.vn/tank/cms/toolvip/tournament_list",
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
                        getData(tournament_id);
                        $("#tournament").val(tournament_id);
                    }
                    else {
                        getData($("#tournament").val());
                    }
                },
                error: function (data) {
                    var obj = $.parseJSON(data);
                }
            });
        });

        function getData(tournament_id) {
            $.ajax({
                url: "http://game.mobo.vn/tank/cms/toolvip/get_vip_gift_pakage?tournament_id=" + tournament_id,
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
                                sTitle: "Tên Gói Quà",
                                mData: "pakage_name"
                            },                           
                            {
                                sTitle: "Giá",
                                mData: "pakage_price"
                            }, 
                            {
                                sTitle: "Yêu Cầu VIP",
                                mData: "vip_required",
                                 mRender: function (data) {
                                    return "<span style='color:blue'>VIP " + data + "</span>";
                                }
                            },
                            {
                                sTitle: "Thời Gian Thêm",
                                mData: "insert_date"
                            },
                            {
                                sTitle: "Trạng Thái",
                                mData: "pakage_status",
                                mRender: function (data) {
                                    return (data == 1) ? "<span style='color:green'>Enable</span>" : "<span style='color:red'>Disable</span>";
                                }
                            },
                            {
                                sTitle: "Tùy Chọn",
                                mData: "id",
                                mRender: function (data) {
                                    return "<a class='btn btn-success btn-xs' href='/?control=tank_event_goi_qua_vip&module=all&func=chinhsuagoiqua&tournament_id=" + $("#tournament").val() + "&id=" + data + "#quanlygoiqua'>Chỉnh Sửa</a>"
                                    + " <a class='btn btn-success btn-xs' href='/?control=tank_event_goi_qua_vip&module=all&func=quanlyqua&tournament_id=" + $("#tournament").val() + "&id=" + data + "#quanlyqua'>Quản Lý Quà</a>";
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
<?php include APPPATH . 'views/game/tank/Events/vip/tab.php'; ?>
            <div class="widget-name">
                <div class="clearboth"></div>
            </div>

            <!--END CONTROL ADD CHEST-->
            <div class="widget" id="viewport">
                <div class="well form-horizontal">
                    <div class="table-overflow">     
                        <div style="margin-top: 10px; margin-bottom: 10px;">                           
                            Giải đấu: <select id="tournament" name="tournament" class="span4 validate[required]" /></select>                                                           
                         <button id="create_reward"  class="btn btn-primary"><span>THÊM GÓI QUÀ MỚI</span></button>
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