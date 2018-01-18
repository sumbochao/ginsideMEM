
<!-- Content container -->
<div id="container">
    <script type="text/javascript">
        $(document).ready(function() {
            $('#create').on('click', function () {
                window.location.href = '/?control=mobo_event_conso&func=add';
            });
        });
        getData();
        function getData() {
            $.ajax({
                url: "http://m-app.mobo.vn/events/consomayman/getlistconfig",
                dataType: 'jsonp',
                method: "POST",
                bRetrieve: true,
                bDestroy: true,
                error: function (jqXHR, textStatus, errorThrown) {
                },
                success: function (data, textStatus, jqXHR) {
					$('#data_table').dataTable({
                        "aaData": data,
                        aoColumns: [
                                {
                                    sTitle: "ID",
                                    mData: "id"
                                },
                                {
                                    sTitle: "Game",
                                    mData: "game"

                                },
                                {
                                    sTitle: "EventID",
                                    mData: "eventid"

                                },
								{
                                    sTitle: "ResultStatus",
                                    mData: "resultstatus"
                                },
                                {
                                    sTitle: "StartDate",
                                    mData: "startdate"
                                },
                                {
                                    sTitle: "EndDate",
                                    mData: "enddate"
                                },
                                {
                                    sTitle: "Status",
                                    mData: "status",
									mRender: function (data) {
										if(data == '1')
											return "<span style='color: blue;'>Enable</span>";
										else
											return "<span style='color: red;'>Disable</span>";
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

           
            <style type="text/css" media="screen">
                .tabs a{float: left;color: #000;font-size: 14px;width: 15%;}
                .clearboth{clear:both;width: 100%;height:0;display: block;content:"";}
                .green,.red{font-weight: bold;}
                .green{color:green;}
                .red{color:red;}
            </style>

            <?php include APPPATH . '/views/events/soxo/nav.php'; ?>

            <!--END CONTROL ADD CHEST-->
			<div class="well form-horizontal">
                <div class="table-overflow">     
                     <div style="margin-top: 10px; margin-bottom: 10px;">
                        <button id="create"  class="btn btn-primary"><span>THÊM MỚI</span></button>
                    </div>                               
                    <table class="table table-striped table-bordered" id="data_table">      
                    </table>
                </div>
				<div class="widget" id="viewport">                
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
    
    




