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
                window.location.href = '/?control=push_notification&func=add&view=pushios&module=all';
            });
        });

        function getData() {
            $.ajax({
                url: "/?control=push_notification&func=get_push_notication&module=all",
                dataType: 'json',
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
                                sTitle: "Game Id",
                                mData: "game"
                            },
                            {
                                sTitle: "Date Add",
                                mData: "insertDate",
                            },
                            {
                                sTitle: "Finish",
                                mData: "is_finish",
                                mRender: function (data) {
                                    return (data == 0) ? "<span style='color:red'>Not Finish</span>" : "<span style='color:green'>Finish</span>";
                                }
                            },
                            {
                                sTitle: "Message",
                                mData: "message",
                            },
                            {
                                sTitle: "Package Name",
                                mData: "packageName",
                            },
                            {
                                sTitle: "Platform",
                                mData: "platform",
                            },
                            {
                                sTitle: "Time",
                                mData: "time",
                            },
                            {
                                sTitle: "Tùy Chọn",
                                mData: "id",
                                mRender: function (data,type,full) {
                                    return "<a href='/?control=push_notification&func=edit&view=pushios&id=" + full.id + "&game="+ full.game +"&module=all#quanlyqua'>Update</a>";
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
            <?php include APPPATH . 'views/pushnotification/tab.php'; ?>
            <div class="widget-name">
                <div class="clearboth"></div>
            </div>
            <!--END CONTROL ADD CHEST-->
            <div class="widget" id="viewport">
                <div class="well form-horizontal">
                    <div class="table-overflow">     
                        <div style="margin-top: 10px; margin-bottom: 10px;">
                            <button id="create"  class="btn btn-primary"><span>THÊM PUSH</span></button>
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