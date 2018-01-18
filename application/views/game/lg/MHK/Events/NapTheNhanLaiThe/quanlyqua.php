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
            $('#add_gift').on('click', function () {
                window.location.href = '/?control=napthe_nhanlaithe_mhk&func=themqua&tournament_id=' + $("#tournament").val() + "&module=all#quanlyqua";
            });

            //Load Tournament List
            $.ajax({
                method: "GET",
                dataType: 'jsonp',
                url: "https://mong.langgame.net/cms/toolnapthenhanlaithe/tournament_list",
                contentType: 'application/json; charset=utf-8',
                success: function (data) {
                    var obj = data["rows"];
                    var tourlist = "";
                    $.each(obj, function (key, value) {
                        tourlist += '<option value="' + value["id"] + '" >' + value["tournament_name"] + '</option>';
                    });

                    $("#tournament").html(tourlist);

                    var tournament_id = getParameterByName("tournament_id");
                    if (tournament_id != "") {
                        $("#tournament").val(tournament_id);
                    }
                    
                    getData($("#tournament").val());

                },
                error: function (data) {
                    var obj = $.parseJSON(data);
                }
            });

            $("#tournament").change(function () {
                window.location.href = "/?control=napthe_nhanlaithe_mhk&func=quanlyqua&tournament_id=" + $(this).val() + "&module=all#quanlyqua";
            });
        });

        function getData(tournament_id) {
            $.ajax({
                url: "https://mong.langgame.net/cms/toolnapthenhanlaithe/gift_list?tournament_id=" + tournament_id,
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
                                mData: "item_name"
                            },
                            {
                                sTitle: "Items",
                                mData: "json_item",
                                mRender: function (data, type, full) {
                                    obj2 = jQuery.parseJSON(data);
                                    var html = "";
                                    $.each(obj2, function (key2, value2) {
                                        html = html + "Item Id : " + value2["item_id"] + " - Số lượng : " + value2["count"] + "</br>";
                                    });
                                    return html;
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
                                sTitle: "Tùy Chọn",
                                mData: "id",
                                mRender: function (data) {
                                    return "<a href='/?control=napthe_nhanlaithe_mhk&func=chinhsuaqua&id=" + data + "&tournament_id=" + $("#tournament").val() + "&module=all#quanlyqua'>Chỉnh Sửa</a>";
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
            <?php include APPPATH . 'views/game/lg/MHK/Events/NapTheNhanLaiThe/tab.php'; ?>
            <div class="widget-name">
                <div class="clearboth"></div>
            </div>

            <!--END CONTROL ADD CHEST-->
            <div class="widget" id="viewport">
                <div class="well form-horizontal">
                    <div style="border-top:1px solid #d5d5d5;padding: 4px 8px">                     
                        Event: <select id="tournament" name="tournament" class="span4 validate[required]" /></select> 
                        <button id="add_gift"  class="base_button base_green base-small-border-radius"><span>Thêm Quà Mới</span></button>
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