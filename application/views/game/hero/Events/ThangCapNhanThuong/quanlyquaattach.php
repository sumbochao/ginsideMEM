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
                window.location.href = '/?control=thangcapnhanthuong_hero&func=themquaattach&tournament_id=' + $("#tournament").val() + "&module=all#quanlyquaattach";
            });

            $("#tournament").change(function () {
                window.location.href = "/?control=thangcapnhanthuong_hero&module=all&func=quanlyquaattach&tournament_id=" + $(this).val() + "#quanlyquaattach";
            });

            //Load Tounament Type
            $.ajax({
                method: "GET",
                url: "http://game.mobo.vn/hero/cms/toolthangcapnhanthuong/tournament_list",
                contentType: 'application/json; charset=utf-8',
                success: function (data) {
                    var obj = data["rows"];
                    var tourlist = '';
                    $.each(obj, function (key, value) {
                        tourlist += '<option value="' + value["id"] + '" >' + value["tournament_name"] + '</option>';
                    });

                    $("#tournament").html(tourlist);

                    if (getParameterByName("tournament_id") != "") {
                        getData(getParameterByName("tournament_id"));
                        $("#tournament").val(getParameterByName("tournament_id"));
                    } else {
                        getData($("#tournament").val());
                    }
                },
                error: function (data) {
                    var obj = $.parseJSON(data);
                }
            });

        });

        function getData($tournament_id) {
            $.ajax({
                url: "http://game.mobo.vn/hero/cms/toolthangcapnhanthuong/gift_attach_list?tournament_id=" + $tournament_id,
                dataType: 'jsonp',
                method: "POST",
                bRetrieve: true,
                bDestroy: true,
                error: function (jqXHR, textStatus, errorThrown) {
                },
                success: function (data, textStatus, jqXHR) {
                    console.log(data);
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
                                mData: "item_name"
                            },
                            {
                                sTitle: "Số lượng",
                                mData: "count"
                            },
                            {
                                sTitle: "Cấp để nhận",
                                mData: "lvl_group_send"
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
                                    return "<a href='/?control=thangcapnhanthuong_hero&func=chinhsuaquaattach&id=" + data + "&tournament_id=" + $("#tournament").val() + "&module=all#quanlyquaattach'>Chỉnh Sửa</a>";
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
            <?php include APPPATH . 'views/game/hero/Events/ThangCapNhanThuong/tab.php'; ?>
            <div class="widget-name">
                <div class="clearboth"></div>
            </div>

            <!--END CONTROL ADD CHEST-->
            <div class="widget" id="viewport">
                <div class="well form-horizontal">
                    <div style="border-top:1px solid #d5d5d5;padding: 4px 8px">
                        <select id="tournament" name="tournament" class="span4 validate[required]"></select> <button id="add_gift"  class="base_button base_green base-small-border-radius"><span>Thêm Quà Mới</span></button>
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