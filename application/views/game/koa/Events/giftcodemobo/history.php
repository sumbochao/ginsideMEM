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
			$('.datetimer').datetimepicker({
                dateFormat: 'yy-mm-dd',
                timeFormat: 'hh:mm:ss'//
            });
            getData();
        });
        function getData() {
            $.ajax({
                url: "http://game.mobo.vn/lucgioi/cms/giftcodemobo/history",
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
                                sTitle: "MSI",
                                mData: "mobo_service_id",

                            },
                            {
                                sTitle: "SERVER_ID",
                                mData: "server_id",

                            },
                            {
                                sTitle: "GIFTCODE",
                                mData: "giftcode",
                            },
                            {
                                sTitle: "INSERT_DATE",
                                mData: "create_date",
                            },
                            {
                                sTitle: "EVENT_NAME",
                                mData: "event_name",
                            },
                            {
                                sTitle: "TYPEGC",
                                mData: "typegc",
                            },
							{
                                sTitle: "JSONLOG",
                                mData: "jsonlog",
                            },
                            {
                                sTitle: "STATUS",
                                mData: "result",
                                mRender: function (data) {
                                    return (data === "1") ? "Enable" : "Disable";
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
            <?php include   'tab.php'; ?>
            <div class="widget-name">
                <div class="clearboth"></div>
            </div>
			<form style="margin: 20px;" class="form-inline" method="post" action="/?control=giftcodemobo_bog&func=export#lichsu">
                <div class="form-group">
                    <input type="text" class="form-control datetimer" name="date_start" placeholder="Ngày bắt đầu" id="dp1447321748048">
                </div>
                <div class="form-group">
                    <input type="text" class="form-control datetimer" name="date_end" placeholder="Ngày kết thúc" id="dp1447321748049">
                </div>
                <div class="form-group">
					<button type="submit" class="btn btn-primary">Xuất Excel</button>
				</div>

            </form>
				
            <!--END CONTROL ADD CHEST-->
            <div class="widget" id="viewport">
                <div class="well form-horizontal">
                <div class="table-overflow">                              
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