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
                window.location.href = "/?control=tulinhdan_gm&func=lichsutop&tournament_id=" + $(this).val() + "&startdate=" + $("#startdate").val() + "&enddate=" + $("#enddate").val() + "#lichsutop";
            });
        });

        $(document).ready(function () { 
            $('#create_boxitem').on('click', function () {
                window.location.href = "/?control=tulinhdan_gm&func=lichsutop&tournament_id=" + $("#tournament_id").val() + "#lichsutop";
            });

            $('#export_excel').on('click', function () {
                window.location.href = "http://game.mobo.vn/giangma/cms/tooltulinhdan/get_exchange_history_top_excel?tournament_id=" + $("#tournament_id").val();
            });
            
            
            //Load tournament list
            $(".loading").fadeIn("fast");
            $.ajax({
                method: "GET",
                url: "http://game.mobo.vn/giangma/cms/tooltulinhdan/tournament_list",
                contentType: 'application/json; charset=utf-8',
                success: function (data) {
                    var obj = data["rows"];
                    var tourlist = "";
                    $.each(obj, function (key, value) {
                        tourlist += '<option value="' + value["id"] + '" >' + value["tournament_name"] + '</option>';
                    });

                    $("#tournament_id").html(tourlist);

                    var tournament_id = getParameterByName("tournament_id");
                    if (tournament_id !== null && tournament_id !== "") {
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
                url: "http://game.mobo.vn/giangma/cms/tooltulinhdan/get_exchange_history_top?tournament_id=" + tournament_id + "&startdate=" + $("#startdate").val() + "&enddate=" + $("#enddate").val() + "&pagesize=10000",
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
                                    sTitle: "Quà",
                                    mData: "reward_name",
                                },
                                {
                                    sTitle: "Thời Gian",
                                    mData: "exchange_date",
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
            return results === null ? "" : decodeURIComponent(results[1].replace(/\+/g, " "));
        }
    </script>

    <!-- Content -->
    <div id="content">
        <!-- Content wrapper -->
        <div class="wrapper">
            <?php include APPPATH . 'views/game/gm/Events/TuLinhDan/tab.php'; ?>
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
                        <table style="margin-bottom: 10px;" cellspacing="0" cellpadding="4">
                        <tr>                           
                            <td><button id="create_boxitem" class="btn btn-primary"><span>THỰC HIỆN</span></button></td>
                            <td><button id="export_excel" class="btn btn-success"><span>EXPORT EXCEL</span></button></td>
                        </tr>                       
                        </table>
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
