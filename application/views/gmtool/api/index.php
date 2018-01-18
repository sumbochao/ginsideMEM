<link rel="stylesheet" href="<?php echo base_url('assets/datetime/css/style.css'); ?>"/>
<link rel="stylesheet" href="<?php echo base_url('assets/datetime/css/bootstrap.css'); ?>"/>
<?php
$url_service = 'http://graph.mobo.vn/v2/';
?>
<div id="content-t" style="min-height:500px; padding-top:10px">
    <style>
        #loading {width: 100%;height: 100%;top: 0px;left: 0px;position: fixed;display: block; z-index: 99;}
        #loading-image {position: absolute;top: 40%;left: 45%;z-index: 100} 
        label {width: auto !important;color: #f36926;}
    </style>
    <script type="text/javascript">
        $(document).ready(function () {
            $('#service_id').on('change', function () {
                getData(this.value);
            })
            $('#create').on('click', function () {
                window.location.href = '/?control=gmtoolapi&func=add&module=all';
            });
        });
        function getData(service_id) {
//            var url = 'http://graph.mobo.vn/v2/control=inside&func=get_icon_mobo?service_id=155&app=ginside&token=3d6c9fd65f8f6f5ba51759003b038dfa';
            $.ajax({
                url: "/?control=gmtoolapi&func=get_gm_support&module=all",
                dataType: 'json',
                method: "POST",
                data: {service_id: service_id},
                bRetrieve: true,
                bDestroy: true,
                error: function (jqXHR, textStatus, errorThrown) {
                },
                success: function (data, textStatus, jqXHR) {
                    $('#data_table_send').dataTable({
                        "aaData": data.data,
                        aoColumns: [
                            {
                                sTitle: "Service ID",
                                mData: "service_id",
                            },
                            {
                                sTitle: "GM Support",
                                mData: "gm_support",
                            },
                            {
                                sTitle: "Create Date",
                                mData: "createDate",
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
                                    return "<a class='btn btn-success btn-xs' href='/?control=gmtoolapi&func=edit&id=" + data + "#giftcodemobo'>Sửa</a>\n\
                                           <a class='btn btn-danger btn-xs' onclick=\"if(!window.confirm('Bạn có muốn xóa không ?')) return false;\" href='/?control=gmtoolapi&func=delete&id=" + data + "#giftcodemobo'>Xóa</a>";
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
            <?php include 'tab.php'; ?>
            <div class="widget-name">
                <div class="clearboth"></div>
            </div>
            <!--END CONTROL ADD CHEST-->
            <div class="widget" id="viewport">
                <div class="well form-horizontal">
                    <div class="table-overflow">     
                        <div style="margin-top: 10px; margin-bottom: 10px;">
                            <button id="create"  class="btn btn-primary"><span>THÊM MỚI</span></button>
                        </div>                               
                        <table class="table table-striped table-bordered" id="data_table">      
                        </table>
                    </div>
                    <div class="rows">	
                        <label for="menu_group_id">Game</label>
                        <select name="service_id" id="service_id" class="textinput">
                            <option value="">Chọn Game</option>
                            <?php if (empty($listScopes) !== TRUE) : ?>
                                <?php foreach ($listScopes as $v): ?>
                                    <option value="<?php echo $v['service']; ?>"><?php echo $v['app_fullname']; ?></option>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </select>
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