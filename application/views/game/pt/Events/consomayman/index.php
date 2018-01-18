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
            getData();

            $('#create_tournament').on('click', function () {
                window.location.href = '/?control=consomayman&func=themconfig';
            });
        });

        function getData() {
            $.ajax({
                url: "http://game.mobo.vn/phongthan/cms/consomayman/getconfig",
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
                                sTitle: "Game",
                                mData: "game",

                            },
                            {
                                sTitle: "Content ID",
                                mData: "content_id",

                            },
                            {
                                sTitle: "StartDate",
                                mData: "start",
                            },
                            {
                                sTitle: "EndDate",
                                mData: "end",
                            },
                            {
                                sTitle: "Trạng thái",
                                mData: "status",
                                mRender: function (data) {
                                    return (data === "1") ? "Enable" : "Disable";
                                }
                            },
                            {
                                sTitle: "ServerID",
                                mData: "server_id",
                            },
                            {
                                sTitle: "MinuteItem",
                                mData: "minuteitem",
                            },
                            {
                                sTitle: "JsonRule",
                                mData: "jsonrule",
                            },
							{
                                sTitle: "Action",
                                mData: "id",
                                mRender: function(data){
                                    return "<a href='?control=consomayman&func=themconfig&ids="+data+"'>Edit</a> <span style='padding-left:10px'><a href='?control=consomayman&func=delete&ids="+data+"'>Delete</a></span>";
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
    </script>
    
    <!-- Content -->
    <div id="content">
        <!-- Content wrapper -->
        <div class="wrapper">                     
            <?php include APPPATH . 'views/game/pt/Events/consomayman/tab.php'; ?>
            <div class="widget-name">
                <div class="clearboth"></div>
            </div>

            <!--END CONTROL ADD CHEST-->
            <div class="widget" id="viewport">
                <div class="well form-horizontal">
                <div class="table-overflow">     
                     <div style="margin-top: 10px; margin-bottom: 10px;">
                        <button id="create_tournament"  class="btn btn-primary"><span>THÊM CONFIG</span></button>
                    </div>                               
                    <table class="table table-striped table-bordered" id="data_table">      
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