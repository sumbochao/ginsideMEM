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
            width: 1067px;
        }
        #create{
            position: relative;
            top:-5px;
        }
    </style>
    <script type="text/javascript">
        $(document).ready(function () {
            getData();
        });
        function getData() {
            $.ajax({
                url: "<?php echo $url_service; ?>/cms/module/index",
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
                                sTitle: '<input type="checkbox" name="checkbox" onclick="checkedAll();"/>',
                                mData: "id",
                                mRender: function (data) {
                                    return '<input type="checkbox" value="'+data+'" id="cid" name="cid[]">';
                               }
                            },
                            {
                                sTitle: "ID",
                                mData: "id"
                            },
                            {
                                sTitle: "Tên",
                                mData: "name",
                                mRender: function (data,type,full) {
                                    var name = '';
                                    if(full.level==1){
                                        name = '<div style="text-align:left"> <strong>+ ' + full.name + '</strong></div>';
                                    }else{
                                        var x = 25 * (full.level-1);
                                        var css = 'padding-left: ' + x + 'px;';
                                        name = '<div style="' + css + '; text-align:left">- ' + full.name + '</div>';
                                    }
                                    return name;
                               }
                            },
                            {
                              sTitle: "Controller",
                              mData: "controller",
                            },
                            {
                               sTitle: "Action",
                               mData: "action",

                            },
                            {
                               sTitle: "Game",
                               mData: "report_game",
                            },
                            {
                               sTitle: "Loại",
                               mData: "id_type",
                               mRender: function (data) {
                                    var type = '';
                                    switch(data){
                                        case '0':
                                            type = 'Chức năng chính';
                                            break;
                                        case '1':
                                            type = 'Dữ liệu game';
                                            break;
                                        case '2':
                                            type = 'Mật định';
                                            break;
                                        case '3':
                                            type = 'Phân quyền Param';
                                            break;
                                    }
                                    return type;
                                }
                            },
                            {
                               sTitle: "Trạng Thái",
                               mData: "status",
                               mRender: function (data) {
                                   return (data == 1) ? "<span style='color:green'>Enable</span>" : "<span style='color:red'>Disable</span>";
                               }
                            },
                            {
                               sTitle: "Tùy Chọn",
                               mData: "id",
                               mRender: function (data) {
                                   return "<a class='btn btn-success btn-xs' href='/?control=module&func=edit&id=" + data + "'>Sửa</a>\n\
                                           <a class='btn btn-danger btn-xs' onclick=\"if(!window.confirm('Bạn có muốn xóa không ?')) return false;\" href='/?control=module&func=delete&id=" + data + "'>Xóa</a>";
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
                        iDisplayLength: 25,
                        sPaginationType: "full_numbers"
                    });
                }
            });
        }
    </script>
    <?php include_once 'include/toolbar.php'; ?>
    <!-- Content -->
    <div id="content">
        <!-- Content wrapper -->
        <div class="wrapper">                     
            <div class="widget-name">
                <div class="clearboth"></div>
            </div>
            <!--END CONTROL ADD CHEST-->
            <div class="widget" id="viewport">
                <div class="form-horizontal">
                    <form id="appForm" action="" method="post" name="appForm">
                        <div class="table-overflow"> 
                            <div class="wrapper_scroolbar">
                                <div class="scroolbar">
                                    <table class="table table-striped table-bordered" id="data_table"></table>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <!-- /content wrapper -->
    </div>
    <!-- /content -->
</div>