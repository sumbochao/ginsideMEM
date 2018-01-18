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
//            $('#create_reward').on('click', function () {
//                window.location.href = '/?control=choinapmhknhanknb_gok&module=all&func=themqua&tournament_id=' + $("#tournament").val() + '&pakage_id=' + $("#vip_gift_pakage").val() + '#quanlyqua';
//            });

            $("#tournament").change(function () {
                window.location.href = "/?control=choinapmhknhanknb_gok&module=all&func=quanlyqua&tournament_id=" + $("#tournament").val() + "#quanlyqua";
            });

            //Load Tournament List
            $.ajax({
                method: "GET",
                dataType: 'jsonp',
                url: "https://sev-cok.addgold.net/ToolchoinapMHKnhanKNB/tournament_list",
                contentType: 'application/json; charset=utf-8',
                success: function (data) {
                    var obj = data;
                    var tourlist = "";
                    $.each(obj, function (key, value) {
                        tourlist += '<option value="' + value["id"] + '" >' + value["name"] + '</option>';
                    });

                    $("#tournament").html(tourlist);

                    var tournament_id = getParameterByName("tournament_id");
                    if (tournament_id !== null && tournament_id !== "") {
                        $("#tournament").val(tournament_id);
                    }

                    getData($("#tournament").val());

                },
                error: function (data) {
                    var obj = $.parseJSON(data);
                }
            });
        });


        function getData(tournament_id) {
            $.ajax({
                url: "https://sev-cok.addgold.net/ToolchoinapMHKnhanKNB/get_doivatpham_gift?tournament_id=" + tournament_id,
                dataType: 'jsonp',
                method: "POST",
                bRetrieve: true,
                bDestroy: true,
                error: function (jqXHR, textStatus, errorThrown) {
                },
                success: function (data, textStatus, jqXHR) {
                    $('#data_table').dataTable({
                        "aaData": data
                        ,
                        aoColumns: [
                            {
                                sTitle: "Event Id",
                                mData: "event_id"
                            },
                            {
                                sTitle: "Start",
                                mData: "start"
                            },
                            {
                                sTitle: "End",
                                mData: "end"
                            },
                            {
                                sTitle: "Date Start KOK",
                                mData: "set_create_KOK"
                            },
                            {
                                sTitle: "Last Date get card MHK ",
                                mData: "end_date_get_card_MHK"
                            },
                            {
                                sTitle: "Status",
                                mData: "status"
                            },
                            {
                                sTitle: "Tùy Chọn",
                                mData: "id",
                                mRender: function (data) {
                                    return "<a class='btn btn-success btn-xs' href='/?control=choinapmhknhanknb_gok&module=all&func=chinhsuaqua&tournament_id=" + $("#tournament").val() + "&id=" + data + "#quanlyqua'>Chỉnh Sửa</a>";
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
            <?php include APPPATH . 'views/game/lg/GOK/Events/choinapMHKnhanKNB/tab.php'; ?>
            <div class="widget-name">
                <div class="clearboth"></div>
            </div>

            <!--END CONTROL ADD CHEST-->
            <div class="widget" id="viewport">
                <div class="well form-horizontal">
                    <div class="table-overflow">     
                        <div style="margin-top: 10px; margin-bottom: 10px;">                           
                            Sự kiện: <select id="tournament" name="tournament" class="span4 validate[required]" /></select>
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