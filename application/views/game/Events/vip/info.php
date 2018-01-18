<link rel="stylesheet" href="<?php echo base_url('assets/datetime/css/style.css'); ?>"/>
<link rel="stylesheet" href="<?php echo base_url('assets/datetime/css/bootstrap.css'); ?>"/>
<div id="content-t" style="min-height:500px; padding-top:10px">
    <style>
        #loading {width: 100%;height: 100%;top: 0px;left: 0px;position: fixed;display: block; z-index: 99;}
        #loading-image {position: absolute;top: 40%;left: 45%;z-index: 100} 
        label {width: auto !important;color: #f36926;}
        .dataTables_wrapper.no-footer .dataTables_scrollBody{
            border-bottom: 0px;
            padding-top: 5px;
        }
        .scroolbar{
            width: 1200px;
        }
        #create{
            position: relative;
            top:-5px;
        }
        .viewdetail{
            cursor: pointer;
            color: green;
        }
    </style>
    <style>
        .listserver .rows{
            float: left;
            width: 245px;
            margin-right:10px;
            margin-bottom: 10px;
        }
        .table-bordered {
            border: 1px solid #ddd;
        }
        .table-bordered > thead > tr > th, .table-bordered > tbody > tr > th, .table-bordered > tfoot > tr > th, .table-bordered > thead > tr > td, .table-bordered > tbody > tr > td, .table-bordered > tfoot > tr > td {
            border: 1px solid #ddd;
        }
        .table-condensed > thead > tr > th, .table-condensed > tbody > tr > th, .table-condensed > tfoot > tr > th, .table-condensed > thead > tr > td, .table-condensed > tbody > tr > td, .table-condensed > tfoot > tr > td {
            padding: 5px;
        }
        .listserver table tbody tr:nth-child(even),.modal-body table tbody tr:nth-child(even){
            background: #eee;
        }
        .listserver table tbody tr:nth-child(odd),.modal-body table tbody tr:nth-child(odd){
            background: #fff;
        }
        table {
            border-collapse: collapse;
            border-spacing: 0;
        }
        .table-hover tbody tr:hover td, .table-hover tbody tr:hover th {
            background-color: #dff0d8;
        }
        .red{
            color: red;
        }
    </style>
    <script type="text/javascript">
        $(document).ready(function () {
            getData();
			$('#create').on('click', function () {
				var start = $("input[name=start]").val();
                var end = $("input[name=end]").val();
                window.location.href = '/?control=vip&func=excelinfo&game=<?php echo $_GET['game'];?>&module=<?php echo $_GET['module'];?>&start='+start+'&end='+end;
            });
        });
        function getData() {
            $.ajax({
                url: "<?php echo $url_service; ?>/cms/vip/info?game=<?php echo $_GET['game'];?>",
                dataType: 'jsonp',
                method: "POST",
                bRetrieve: true,
                bDestroy: true,
                error: function (jqXHR, textStatus, errorThrown) {
                },
                success: function (data, textStatus, jqXHR) {
                    $('#data_table').dataTable({
                        "aaData": data.rows,
                        aoColumns: [
                            {
                                sTitle: "ID",
                                mData: "id"
                            },
                            {
                                sTitle: "Mobo ID",
                                mData: "mobo_id"
                            },
                            {
                               sTitle: "ID nhân vật",
                               mData: "character_id",

                            },
                            {
                               sTitle: "Tên nhân vật",
                               mData: "character_name",

                            },
                            {
                               sTitle: "Server",
                               mData: "server_id",

                            },
                            {
                               sTitle: "Tên",
                               mData: "name",
                            },
                            {
                               sTitle: "Địa chỉ",
                               mData: "address",
                            },
                            {
                               sTitle: "Điện thoại",
                               mData: "phone",
                            },
							{
                               sTitle: "Năm sinh",
                               mData: "birthday",
                            },
							{
                               sTitle: "Facebook",
                               mData: "facebook_uri",
                            },
                            {
                               sTitle: "Ngày tạo",
                               mData: "create_date",
                            },
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
        function viewdetail(id){
            $.ajax({
                type: "POST",
                dataType: 'jsonp',
                url: "<?php echo $url_service;?>/cms/vip/detailinfo",
                data:{id:id},
                beforeSend: function () {
                    $(".loading").fadeIn("fast");
                }
            }).done(function (result) {
                var datahtml;
                datahtml  ='<div class="listserver" id="appForm">';
                datahtml +='    <table width="100%" border="0" class="table table-striped table-bordered table-condensed table-hover">';
                datahtml +='        <tbody>';
                datahtml +='            <tr>';
                datahtml +='                <td align="center">ID</td>';
                datahtml +='                <td align="center">'+result.id+'</td>';
                datahtml +='            </tr>';
                datahtml +='            <tr>';
                datahtml +='                <td align="center">Sự kiện</td>';
                datahtml +='                <td align="center">'+result.event_name+'</td>';
                datahtml +='            </tr>';
                datahtml +='            <tr>';
                datahtml +='                <td align="center">Mobo ID</td>';
                datahtml +='                <td align="center">'+result.mobo_id+'</td>';
                datahtml +='            </tr>';
                datahtml +='            <tr>';
                datahtml +='                <td align="center">Character ID</td>';
                datahtml +='                <td align="center">'+result.character_id+'</td>';
                datahtml +='            </tr>';
                datahtml +='            <tr>';
                datahtml +='                <td align="center">Character name</td>';
                datahtml +='                <td align="center">'+result.character_name+'</td>';
                datahtml +='            </tr>';
                datahtml +='            <tr>';
                datahtml +='                <td align="center">Mobo Service ID</td>';
                datahtml +='                <td align="center">'+result.mobo_service_id+'</td>';
                datahtml +='            </tr>';
                datahtml +='            <tr>';
                datahtml +='                <td align="center">Server ID</td>';
                datahtml +='                <td align="center">'+result.server_id+'</td>';
                datahtml +='            </tr>';
                datahtml +='            <tr>';
                datahtml +='                <td align="center">Tên</td>';
                datahtml +='                <td align="center">'+result.name+'</td>';
                datahtml +='            </tr>';
                datahtml +='            <tr>';
                datahtml +='                <td align="center">Địa chỉ</td>';
                datahtml +='                <td align="center">'+result.address+'</td>';
                datahtml +='            </tr>';
                datahtml +='            <tr>';
                datahtml +='                <td align="center">Điện thoại</td>';
                datahtml +='                <td align="center">'+result.phone+'</td>';
                datahtml +='            </tr>';
                datahtml +='            <tr>';
                datahtml +='                <td align="center">Ngày sinh nhật</td>';
                datahtml +='                <td align="center">'+result.birthday+'</td>';
                datahtml +='            </tr>';
                datahtml +='            <tr>';
                datahtml +='                <td align="center">Ngày tạo</td>';
                datahtml +='                <td align="center">'+result.create_date+'</td>';
                datahtml +='            </tr>';
                datahtml +='        </tbody>';
                datahtml +='    </table>';
                datahtml +='</div>';
                $(".modal-body #messgage").html(datahtml);
                $("#mySmallModalLabel").text("Thông tin của bạn");
                $('.bs-example-modal-sm').modal('show');
                $(".loading").fadeOut("fast");
            });
        }
    </script>
    <!-- Content -->
    <div id="content">
        <!-- Content wrapper -->
        <div class="wrapper">                     
            <?php include APPPATH . 'views/game/Events/vip/tab.php'; ?>
            <div class="widget-name">
                <div class="clearboth"></div>
            </div>
            <!--END CONTROL ADD CHEST-->
            <div class="widget" id="viewport">
                <div class="well form-horizontal">
                    <div class="table-overflow">
						<div style="margin-top: 10px; margin-bottom: 10px;">
							<?php
                                $start = date('d-m-Y G:i:s',  strtotime('-15 day'));
                                $end = date('d-m-Y G:i:s');
                             ?>
                             <input type="text" class="datetimer" name="start" value="<?php echo $start;?>"/>
                             <input type="text" class="datetimer" name="end" value="<?php echo $end;?>"/>
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
<script>
    $('.datetimer').datetimepicker({
        dateFormat: 'dd-mm-yy',
        timeFormat: 'hh:mm:ss'//
    });
</script>