<link rel="stylesheet" href="<?php echo base_url('assets/datetime/css/style.css'); ?>"/>
<link rel="stylesheet" href="<?php echo base_url('assets/datetime/css/bootstrap.css'); ?>"/>
<div id="content-t" style="min-height:500px; padding-top:10px">
    <style>
        #loading {width: 100%;height: 100%;top: 0px;left: 0px;position: fixed;display: block; z-index: 99;}
        #loading-image {position: absolute;top: 40%;left: 45%;z-index: 100} 
        label {width: auto !important;color: #f36926;}
        .table-overflow select{
            margin-bottom: 0px;
        }
    </style>
    <script type="text/javascript">
        $(document).ready(function () {
            getData();

            $('#create').on('click', function () {
                window.location.href = '/?control=baodanh_dht&func=add&view=user&module=all';
            });
            $('#reset').on('click', function () {
                var event_id = $("select[name=event_id]").val();
                window.location.href = '/?control=baodanh_dht&func=reset_user&view=user&module=all&event_id='+event_id;
            });
        });

        function getData() {
            $.ajax({
                url: "<?php echo $url_service; ?>/cms/baodanh/index_user",
                dataType: 'jsonp',
                method: "POST",
                bRetrieve: true,
                bDestroy: true,
                error: function (jqXHR, textStatus, errorThrown) {
                },
                success: function (data, textStatus, jqXHR) {
                    $('#data_table').dataTable({
                        "aaData": data.rows
                        ,
                        aoColumns: [
                            {
                                 sTitle: "ID",
                                 mData: "id"
                             },
                             {
                                 sTitle: "Mobo ID",
                                 mData: "moboid"
                             },
                             {
                                sTitle: "Character ID",
                                mData: "character_id",
                            },
                           {
                               sTitle: "Mobo Service ID",
                               mData: "mobo_service_id"
                           },
                            {
                                sTitle: "Character Name",
                                mData: "character_name",
                            },
                            {
                                sTitle: "Server ID",
                                mData: "server_id",
                            },
                            {
                                sTitle: "ĐK",
                                mData: "condition",
                            },
                            {
                                sTitle: "Ngày",
                                mData: "date",
                            },
                            {
                                sTitle: "Tiền",
                                mData: "money",
                            },
                            {
                                sTitle: "Tình trạng",
                                mData: "type",
                                mRender: function (data) {
                                    return (data == 0) ? "<span style='color:green'>Enable</span>" : "<span style='color:red'>Disable</span>";
                                }
                            },
                            {
                                sTitle: "Tùy Chọn",
                                mData: "id",
                                mRender: function (data) {
                                    return "<a class='btn btn-success btn-xs' href='/?control=baodanh_dht&func=edit&view=<?php echo $_GET['view'];?>&module=all&id=" + data + "'>Sửa</a>\n\
                                            <a class='btn btn-danger btn-xs' onclick=\"if(!window.confirm('Bạn có muốn xóa không ?')) return false;\" href='/?control=baodanh_dht&func=delete&view=<?php echo $_GET['view'];?>&module=all&id=" + data + "'>Xóa</a>";
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
            <?php include APPPATH . 'views/game/dht/Events/baodanh/tab.php'; ?>
            <div class="widget-name">
                <div class="clearboth"></div>
            </div>
            <!--END CONTROL ADD CHEST-->
            <div class="widget" id="viewport">
                <div class="well form-horizontal">
                    <div class="table-overflow">     
                         <div style="margin-top: 10px; margin-bottom: 10px;">
                             <select name="event_id">
                                 <option value="0">Tất cả</option>
                                 <?php
                                    if(count($slbEvent)>0){
                                        foreach($slbEvent as $v){
                                 ?>
                                 <option value="<?php echo $v['id'];?>"><?php echo $v['name'];?></option>
                                 <?php
                                        }
                                    }
                                 ?>
                             </select>
                             <button id="reset"  class="btn btn-primary"><span>Reset</span></button>
                            <button id="create"  class="btn btn-primary"><span>THÊM MỚI</span></button>
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