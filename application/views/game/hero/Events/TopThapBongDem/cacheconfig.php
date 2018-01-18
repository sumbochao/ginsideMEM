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
            $('#create_cache').on('click', function () {
                window.location.href = '/?control=topthapbongdem_hero&func=addcache&module=all#addcache';
            });
        });    
            
        $(document).ready(function () {
            getData();
        });

        function getData() {
            $("#loading_img").show();
            $.ajax({
                url: "http://game.mobo.vn/hero/cms/tooltopthapbongdem/SP_EventConfig_GetList",
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
                                sTitle: "Server ID",
                                mData: "server_id"
                            },
                            {
                                sTitle: "Start Time",
                                mData: "starttime",
                            },
                            {
                                sTitle: "Stop Time",
                                mData: "stoptime",
                            },
                            {
                                sTitle: "Event ID",
                                mData: "eventid",
                            },
                            {
                                sTitle: "Week",
                                mData: "week",
                            },
                            {
                                sTitle: "Descriptions",
                                mData: "descriptions",
                            },
                            {
                                sTitle: "Create Date",
                                mData: "createdate",
                            },
                            {
                                sTitle: "Status",
                                mData: "status",
                                mRender: function (data) {
                                    return (data == 1) ? "<span style='color:green'>Enable</span>" : "<span style='color:red'>Disable</span>";
                                }
                            },
                                {
                                    sTitle: "Option",
                                    mData: "server_id",
                                    mRender: function (data, type, row) {
                                        return "<a class='btn btn-success btn-xs' href='/?control=topthapbongdem_hero&func=cacheedit&server_id=" + row.server_id + "&eventid=" + row.eventid + "&week=" + row.week + "&module=all#cacheconfig'>Edit</a>";
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
                    $("#loading_img").hide();
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
            <?php include APPPATH . 'views/game/hero/Events/TopThapBongDem/tab.php'; ?>
            <div class="widget-name">
                <div class="clearboth"></div>
            </div>

            <!--END CONTROL ADD CHEST-->
            <div class="widget" id="viewport">
                <div class="well form-horizontal">
                    <button type="button" id="create_cache" class="btn btn-primary btn-sm" style="margin-bottom: 10px"><span>ADD NEW</span></button>
                    <div class="table-overflow">                                             
                        <div class="table-overflow">                                                       
                            <table class="table table-striped table-bordered" id="data_table">      
                            </table>
                        </div>
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
