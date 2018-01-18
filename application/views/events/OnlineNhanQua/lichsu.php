<link rel="stylesheet" href="<?php echo base_url('assets/datetime/css/style.css'); ?>"/>
<link rel="stylesheet" href="<?php echo base_url('assets/datetime/css/bootstrap.css'); ?>"/>
<div id="content-t" style="min-height:500px; padding-top:10px">
    <style>
        #loading {width: 100%;height: 100%;top: 0px;left: 0px;position: fixed;display: block; z-index: 99;}
        #loading-image {position: absolute;top: 40%;left: 45%;z-index: 100} 
        label {width: auto !important;color: #f36926;}
    </style>
    <script type="text/javascript">
        var url = '<?php echo $url; ?>';
        $(document).ready(function () {
            $('.datetimer').datetimepicker({
                dateFormat: 'yy-mm-dd',
                timeFormat: 'hh:mm:ss'//
            });
			$('.btnexcel').on('click', function () {
                var start = $("input[name=date_start]").val();
                var end = $("input[name=date_end]").val();
                window.location.href = '/?control=event_online_nhan_qua&func=excel&start='+start+'&end='+end;
            });
            getData();
        });

        function getData() {
            $.ajax({
                url: url + "history",
                dataType: 'jsonp',
                method: "POST",
                data: {
					game:<?php echo "'{$game}'"?>,
					start : $("#start").val(),
					end : $("#end").val()
					},
                bRetrieve: true,
                bDestroy: true,
                error: function (jqXHR, textStatus, errorThrown) {
					console.log("error");
					console.log(jqXHR);
                },
                success: function (data, textStatus, jqXHR) {
                    $('#data_table').dataTable({
                        "aaData": data.rows
                        ,
                        aoColumns: [
                            {
                                sTitle: "Mã giao dịch",
                                mData: "id"
                            },
                            {
                                sTitle: "CharacterID",
                                mData: "character_id"
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
                                sTitle: "status",
                                mData: "status"
                            },
                            {
                                sTitle: "API Result",
                                mData: "api_result"
                            },
							{
                                sTitle: "Key",
                                mData: "award_key"
                            },
                            {
                                sTitle: "Received_time",
                                mData: "received_time"
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
            <?php include 'tab.php'; ?>
            <div class="widget-name">
                <div class="clearboth"></div>
            </div>


            <div>
                <div style="margin: 20px;" class="form-inline">
                    <div class="form-group">
                        <input type="text" class="form-control datetimer" name="date_start" id="start" placeholder="Ngày bắt đầu" value="<?php echo date('Y-m-d G:i:s',time()-(86400*7));?>">
                    </div>
                    <div class="form-group">
                        <input type="text" class="form-control datetimer" name="date_end" id="end" placeholder="Ngày kết thúc" value="<?php echo date('Y-m-d G:i:s');?>">
                    </div>
                    <div style="position: absolute;left: 428px;top: 109px;"><button type="button" class="btnexcel btn btn-primary">Xuất Excel</button></div>
                    <input type="hidden" name="game" value="<?php echo $game;?>">
                </div>
            </div>
            <!--END CONTROL ADD CHEST-->
            <div class="widget" id="viewport">
                <div class="well form-horizontal">
                <div class="table-overflow">
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