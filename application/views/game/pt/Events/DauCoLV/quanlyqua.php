<link rel="stylesheet" href="<?php echo base_url('assets/datetime/css/style.css'); ?>"/>
<link rel="stylesheet" href="<?php echo base_url('assets/datetime/css/bootstrap.css'); ?>"/>
<div id="content-t" style="min-height:500px; padding-top:10px">
    <style>
        #loading {width: 100%;height: 100%;top: 0px;left: 0px;position: fixed;display: block; z-index: 99;}
        #loading-image {position: absolute;top: 40%;left: 45%;z-index: 100} 
        label {width: auto !important;color: #f36926;}
    </style>
    <script type="text/javascript">
		var table;
        $(document).ready(function () {
            getData();

            $('#create_reward').on('click', function () {
                window.location.href = '/?control=event_dau_co_lv&func=themqua#quanlyqua';
            });
        });

        function getData() {
            $.ajax({
                url: "http://game.mobo.vn/phongthan/cms/tooldaucolv/gift_list",
                dataType: 'jsonp',
                method: "POST",
                bRetrieve: true,
                bDestroy: true,
                error: function (jqXHR, textStatus, errorThrown) {
                },
                success: function (data, textStatus, jqXHR) {
                    $('#data_table').DataTable({
                        "aaData": data
                        ,
                        aoColumns: [
                            {
                                sTitle: "Mã giao dịch",
                                mData: "id"
                            },
                             {
                                 sTitle: "Level",
                                 mData: "level"
                             },
                            {
                                sTitle: "Vàng",
                                mData: "vang"
                                },
                                {
                                    sTitle: "",
                                    mData: "id",
                                    mRender: function (data, arg1, arg2) {
                                        return "<a class='btn btn-success btn-xs' href=' /?control=event_dau_co_lv&func=themqua&id=" + data + "&level="+arg2.level+"&vang="+arg2.vang + "#quanlyqua '>Chỉnh Sửa</a>";
                                    }

                                },
                            {
                                sTitle: "",
                                mData: "id",
                                mRender: function (data) {
                                    return "<a onclick='delete_gift(this,"+data+");' class='btn btn-success btn-xs' href='#quanlyqua'>Xóa</a>";
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
                url: "http://game.mobo.vn/phongthan/cms/tooldaucolv/delete_gift",
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
            <?php include APPPATH . 'views/game/pt/Events/DauCoLV/tab.php'; ?>
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