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
            $("#tournament_id").change(function () {
                //getData($(this).val());
                window.location.href = "/?control=event_covu_pt&func=lichsu&tournament_id=" + $(this).val() + "#lichsu";
            });
        });

        $(document).ready(function () {
            //Load tournament list
            $(".loading").fadeIn("fast");
            $.ajax({
                method: "GET",
                url: "http://game.mobo.vn/phongthan/cms/toolcacuoc/tournament_list",
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
            $("#loading_img").show();
            $.ajax({
                url: "http://game.mobo.vn/phongthan/cms/toolcacuoc/get_pet_history_details_by_tournament?id=" + tournament_id,
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
                                     sTitle: "Mã GD",
                                     mData: "id"
                                 },
                                {
                                    sTitle: "Server Id",
                                    mData: "server_id",

                                },
                                {
                                    sTitle: "Character ID",
                                    mData: "char_id",

                                },
                                {
                                    sTitle: "Tên Nhân Vật",
                                    mData: "char_name",
                                },
                                {
                                    sTitle: "Team A",
                                    mData: "match_team_name_a",
                                },
                                {
                                    sTitle: "Team B",
                                    mData: "match_team_name_b",
                                },
                                {
                                    sTitle: "Cược đội thắng",
                                    mData: "pet_team_win",
                                    mRender: function (data) {
                                        return (data == "a_win") ? "Team A" : "Team B";
                                    }
                                },
                                 {
                                     sTitle: "Cược điểm",
                                     mData: "pet_point",
                                 },                                 
                                 {
                                     sTitle: "Kết quả",
                                     mData: "pet_status",
                                     mRender: function (data) {
                                         return (data == "wait") ? "<span style='color: #f79646'>Chờ kết quả...</span>" : (data == "win") ? "<span style='color: blue'>Thắng</span>" : "<span style='color: red'>Thua</span>";
                                     }
                                 },
                                 {
                                     sTitle: "Điểm thắng",
                                     mData: "pet_win_point",
                                 },
                                {
                                    sTitle: "Thời Gian",
                                    mData: "pet_date",
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
            <?php include APPPATH . 'views/game/pt/Events/CaCuoc/tab.php'; ?>
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
