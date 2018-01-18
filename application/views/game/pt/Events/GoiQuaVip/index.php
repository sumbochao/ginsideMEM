<link rel="stylesheet" href="<?php echo base_url('assets/datetime/css/style.css'); ?>"/>
<link rel="stylesheet" href="<?php echo base_url('assets/datetime/css/bootstrap.css'); ?>"/>
<div id="content-t" style="min-height:500px; padding-top:10px">
    <style>
        #loading {width: 100%;height: 100%;top: 0px;left: 0px;position: fixed;display: block; z-index: 99;}
        #loading-image {position: absolute;top: 40%;left: 45%;z-index: 100} 
        label {width: auto !important;color: #f36926;}
    </style>
    <script type="text/javascript">
        var table,url;
        $(document).ready(function () {
            url = '<?php echo $url; ?>';
            getData();

            $('#create_reward').on('click', function () {
                window.location.href = '/?control=event_goi_qua_vip&func=showAddConfig#addconfig';
            });
        });

        function getData() {
            $.ajax({
                url: url + "config",
                dataType: 'jsonp',
                method: "POST",
                bRetrieve: true,
                bDestroy: true,
                error: function (jqXHR, textStatus, errorThrown) {
                    console.log('error');
                },
                success: function (data, textStatus, jqXHR) {
                     table = $('#data_table').DataTable({
						 "columnDefs": [
							{ "width": "10%", "targets": 3 }
						  ],
                        "aaData": data
                        ,
                        aoColumns: [
                            {
                                sTitle: "STT",
                                mData: "id"
                            },
                            {
                                 sTitle: "Tên",
                                 mData: "name"
                            },
                            {
                                sTitle: "Server",
                                mData: "server_list",
								mRender: function (server_list) {
                                    return "<div style='overflow: hidden;width: 200px;text-overflow: ellipsis;'>"+server_list+"</div>";
                                }
                            },
                            {
                                sTitle: "IP",
                                mData: "ip_list",
								mRender: function (ip_list) {
                                    return "<div style='overflow: hidden;width: 200px;;text-overflow: ellipsis;'>"+ip_list+"</div>";
                                }
                            },
                            {
                                sTitle: "Gói quà",
                                mData: "package_name"
                            },
                            {
                                sTitle: "Trạng Thái",
                                mData: "status",
                                mRender: function (data) {
                                    if(data == '1')
                                        return "<span style='color: blue;'>Enable</span>";
                                    else
                                        return "<span style='color: red;'>Disable</span>";
                                }
                            },
                            {
                                sTitle: "Bắt đầu",
                                mData: "date_start"
                            },
                            {
                                sTitle: "Kết Thúc",
                                mData: "date_end"
                            },
                            {
                                sTitle: "",
                                mData: "id",
                                mRender: function (id, arg1, arg2) {
                                    return "<a class='btn btn-success btn-xs' href=' /?control=event_goi_qua_vip&func=showAddConfig&id=" + id + "&name="+arg2.name+"&ip_list="+arg2.ip_list + "&server_list="+arg2.server_list + "&status="+arg2.status + "&date_start="+arg2.date_start + "&date_end="+arg2.date_end + "&package_id="+arg2.package_id + "#home '>Chỉnh Sửa</a>";
                                }

                            },
                            {
                                sTitle: "",
                                mData: "id",
                                mRender: function (data, arg1, arg2) {
                                    return "<a onclick='deleteConfig(this,"+data+");' class='btn btn-success btn-xs' href='#home'>Xóa</a>";
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

        //delete award
        function delete_gift(me,id){
            $.ajax({
                url: url + "delete_gift",
                dataType: 'jsonp',
                data: {id:id},
                success: function (response) {
                    table.row($(me).closest('tr')).remove().draw( false );
                }
            });

        }

        //delete config
        function deleteConfig(me,id){
            $.ajax({
                url: url + "deleteConfig",
                dataType: 'jsonp',
                data: {id:id},
                success: function (response) {
                    table.row($(me).closest('tr')).remove().draw( false );
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

            <!--END CONTROL ADD CHEST-->
            <div class="widget" id="viewport">
                <div class="well form-horizontal">
                <div class="table-overflow">     
                     <div style="margin-top: 10px; margin-bottom: 10px;">
                        <button id="create_reward"  class="btn btn-primary"><span>THÊM MỚI</span></button>
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