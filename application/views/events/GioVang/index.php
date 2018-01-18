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
        });

        function getData() {
            $('#data_table').DataTable({
                "columns": [
                    { "width": "5%" },
                    { "width": "10%" },
                    { "width": "25%" },
                    { "width": "20%" },
                    { "width": "10%" },
                    { "width": "10%" },
                    { "width": "10%" },
                    { "width": "10%" },
                ],
                "aaData": <?php echo $configs;?>,
                aoColumns: [
                    {
                        sTitle: "STT",
                        mData: "id"
                    },
                    {
                        sTitle: "Name",
                        mData: "name"
                    },
                    {
                        sTitle: "Server",
                        mData: "server_list"
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
                            return "<a class='btn btn-success btn-xs' href=' /?control=event_gio_vang&func=display&view=addConfig&game=<?php echo $game;?>&id=" + id + "&name="+arg2.name + "&server_list="+arg2.server_list + "&status="+arg2.status + "&date_start="+arg2.date_start + "&date_end="+arg2.date_end + "#home '>Chỉnh Sửa</a>";
                        }

                    }/*,
                     {
                     sTitle: "",
                     mData: "id",
                     mRender: function (data, arg1, arg2) {
                     return "<a onclick='deleteConfig(this,"+data+");' class='btn btn-success btn-xs' href='#home'>Xóa</a>";
                     }

                     }*/

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

            /*$.ajax({
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
                         "columns": [
                             { "width": "5%" },
                             { "width": "10%" },
                             { "width": "25%" },
                             { "width": "20%" },
                             { "width": "10%" },
                             { "width": "10%" },
                             { "width": "10%" },
                             { "width": "10%" },
                         ],
                        "aaData": data
                        ,
                        aoColumns: [
                            {
                                sTitle: "STT",
                                mData: "id"
                            },
                            {
                                 sTitle: "Name",
                                 mData: "name"
                            },
                            {
                                sTitle: "Server",
                                mData: "server_list"
                            },
                            *//*{
                                sTitle: "IP",
                                mData: "ip_list"
                            },*//*
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
                                    return "<a class='btn btn-success btn-xs' href=' /?control=event_gio_vang&func=showAddConfig&game=<?php echo $game;?>&id=" + id + "&name="+arg2.name + "&server_list="+arg2.server_list + "&status="+arg2.status + "&date_start="+arg2.date_start + "&date_end="+arg2.date_end + "#home '>Chỉnh Sửa</a>";
                                }

                            }*//*,
                            {
                                sTitle: "",
                                mData: "id",
                                mRender: function (data, arg1, arg2) {
                                    return "<a onclick='deleteConfig(this,"+data+");' class='btn btn-success btn-xs' href='#home'>Xóa</a>";
                                }

                            }*//*

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
            });*/
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
                data: {id:id, game:$('#game').val()},
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
            <?php  include 'tab.php'; ?>
            <div class="widget-name">
                <div class="clearboth"></div>
            </div>

            <!--END CONTROL ADD CHEST-->
            <div class="widget" id="viewport">
                <div class="well form-horizontal">
                <div class="table-overflow">     
                     <div style="margin-top: 10px; margin-bottom: 10px;">
                        <a href="/?control=event_gio_vang&func=showAddConfig&game=<?php echo $game;?>#addconfig" class="btn btn-primary"><span>THÊM MỚI</span></a>
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

        <input type="hidden" id="game" name="game" value="<?php echo $game;?>">
    </div>
    <!-- /content -->
<script type="text/javascript">
    (new TableDnD).init("tblsort");
</script>