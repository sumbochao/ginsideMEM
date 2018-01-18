<link rel="stylesheet" href="<?php echo base_url('assets/datetime/css/style.css'); ?>"/>
<link rel="stylesheet" href="<?php echo base_url('assets/datetime/css/bootstrap.css'); ?>"/>
<div id="content-t" style="min-height: 500px; padding-top: 10px">
    <style>
        #loading {
            width: 100%;
            height: 100%;
            top: 0px;
            left: 0px;
            position: fixed;
            display: block;
            z-index: 99;
        }

        #loading-image {
            position: absolute;
            top: 40%;
            left: 45%;
            z-index: 100;
        }

        label {
            width: auto !important;
            color: #f36926;
        }
    </style>
    <script type="text/javascript">
        $(function () {
            $('#add_tournament').on('click', function () {
                window.location.href = '/?control=event_covu&func=themtrandau#trandau';
            });

            $("#tournament_id").change(function () {
                //getData($(this).val());
                window.location.href = "/?control=event_covu&func=trandau&tournament_id=" + $(this).val() + "#trandau";
            });
        });

        $(document).ready(function () {
            //Load tournament list
            $(".loading").fadeIn("fast");
            $.ajax({
                method: "GET",
                url: "http://game.mobo.vn/hiepkhach/cms/toolcacuoc/tournament_list",
                contentType: 'application/json; charset=utf-8',
                success: function (data) {
                    var obj = data["rows"];
                    var tourlist = "";
                    $.each(obj, function (key, value) {
                        tourlist += '<option value="' + value["id"] + '" >' + value["tournament_name"] + '</option>';
                    });

                    $("#tournament_id").html(tourlist);

                    var tournament_id = getParameterByName("tournament_id");
                    if (tournament_id != null && tournament_id != "") {
                        getData(tournament_id);
                        $("#tournament_id").val(tournament_id);
                    }
                    else {
                        getData($("#tournament_id").val());
                    }
                },
                error: function (data) {
                    var obj = $.parseJSON(data);
                }
            });
        });

        function getData(tournament_id) {
            $.ajax({
                url: "http://game.mobo.vn/hiepkhach/cms/toolcacuoc/match_list?tournament_id=" + tournament_id,
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
                                     sTitle: "Tên Đội A",
                                     mData: "match_team_name_a"
                                 },
                               {
                                   sTitle: "Ảnh Đội A",
                                   mData: "match_team_img_a",
                                   mRender: function (data) {
                                       return "<img src='" + data + "' width='100px' />";
                                   }

                               },
                                {
                                    sTitle: "A Chấp",
                                    mData: "match_team_chap_a",

                                },
                                {
                                    sTitle: "A Tỷ Lệ Thắng",
                                    mData: "match_team_win_rate_a",

                                },

                                 {
                                     sTitle: "Tên Đội B",
                                     mData: "match_team_name_b"
                                 },
                               {
                                   sTitle: "Ảnh Đội B",
                                   mData: "match_team_img_b",
                                   mRender: function (data) {
                                       return "<img src='" + data + "' width='100px' />";
                                   }

                               },
                                {
                                    sTitle: "B Chấp",
                                    mData: "match_team_chap_b",

                                },
                                {
                                    sTitle: "B Tỷ Lệ Thắng",
                                    mData: "match_team_win_rate_b",

                                },

                                //{
                                //    sTitle: "Bắt Đầu",
                                //    mData: "match_start_date",

                                //},

                                //{
                                //    sTitle: "Kết Thúc",
                                //    mData: "match_end_date",

                                //},

                                //{
                                //    sTitle: "Kết thúc cược",
                                //    mData: "match_end_pet_date",

                                //},

                                {
                                    sTitle: "Cược tối đa",
                                    mData: "match_pet_max",

                                },

                                {
                                    sTitle: "Trạng Thái",
                                    mData: "match_status",
                                    mRender: function (data) {
                                        return (data == 1) ? "<span style='color:green'>Enable</span>" : "<span style='color:red'>Disable</span>";
                                    }
                                },
                                {
                                    sTitle: "Tùy Chọn",
                                    mData: "id",
                                    mRender: function (data) {
                                        return "<a class='btn btn-success btn-xs' href='/?control=event_covu&func=chinhsuatrandau&id=" + data + "#trandau'>Chỉnh Sửa</a> <a class='btn btn-success btn-xs' href='/?control=event_covu&func=ketquatrandau&id=" + data + "#trandau'>Cập nhật kết quả</a>";
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

            $(".loading").fadeOut("fast");
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
            <?php include APPPATH . 'views/game/lk/Events/CaCuoc/tab.php'; ?>
            <div class="widget-name">
                <div class="clearboth"></div>
            </div>

            <!--END CONTROL ADD CHEST-->
            <div class="widget" id="viewport">
                <div class="well form-horizontal">
                    <div class="table-overflow">                        
                        <div>
                            Giải đấu:
                            <select id="tournament_id" name="tournament_id" class="span4 validate[required]" />
                            </select>
                        </div>
                        <div style="border-top: 1px solid #d5d5d5; padding: 4px 8px">
                            <button id="add_tournament" class="btn btn-primary"><span>THÊM TRẬN ĐẤU</span></button>
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
