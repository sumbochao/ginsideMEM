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
			$('#create').on('click', function () {
                var start = $("input[name=start]").val();
                var end = $("input[name=end]").val();
                window.location.href = '/?control=event_welcome_newgame&func=excel';
            });
        });

        function getData() {
            $.ajax({
                url: "http://game.mobo.vn/bog/cms/tool_welcome_newgame/lichsu",
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
                                sTitle: "Mã giao dịch",
                                mData: "id"
                            },
                            {
                                sTitle: "Character name",
                                mData: "character_name"
                                },
                            {
                                sTitle: "Server ID",
                                mData: "server_id"
                            },
                            {
                                sTitle: "Level",
                                mData: "level"
                            },

                            {
                                sTitle: "Quà",
                                mData: "award_key",
                                mRender: function (data) {
                                    if(data == 'install_game')
                                        return 'Quà cài đặt game';
                                    else if(data == 'login_seven_days')
                                        return 'Quà login 7 ngày';
                                    else if(data == 'level_35')
                                        return 'Quà level 35';
                                    else if(data == 'level_45')
                                        return 'Quà level 45';

                                }
                            },
                            {
                                sTitle: "Ngày nhận",
                                mData: "received_date"
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
            <?php  include 'tab.php'; ?>
            <div class="widget-name">
                <div class="clearboth"></div>
            </div>

            <!--END CONTROL ADD CHEST-->
            <div class="widget" id="viewport">
                <div class="well form-horizontal">
                <div class="table-overflow">     
					<div style="margin-top: 10px; margin-bottom: 10px;">
						<button id="create"  class="btn btn-primary"><span>Xuất Excel</span></button>
					</div>
					<table class="table table-striped table-bordered" id="data_table"></table>
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