<link rel="stylesheet" href="<?php echo base_url('assets/datetime/css/style.css'); ?>"/>
<link rel="stylesheet" href="<?php echo base_url('assets/datetime/css/bootstrap.css'); ?>"/>
<div id="content-t" style="min-height:500px; padding-top:10px">
    <style>
        #loading {width: 100%;height: 100%;top: 0px;left: 0px;position: fixed;display: block; z-index: 99;}
        #loading-image {position: absolute;top: 40%;left: 45%;z-index: 100} 
        label {width: auto !important;color: #f36926;}
        .modal-dialog{
            width: 90%;
        }
    </style>
    <script type="text/javascript">
        $(document).ready(function () {
            getData();
            $('#create').on('click', function () {
                window.location.href = '/?control=rednumber&func=add&view=<?php echo $_GET['view'];?>&module=all';
            });
        });
        function getData() {
            $.ajax({
                url: "<?php echo $url_service; ?>/cms/rednumber/index_<?php echo $_GET['view'];?>?game=<?php echo $_SESSION['account']['id_group']==2?$game_id:'';?>",
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
                               mData: "id",
                            },
                            {
                               sTitle: "Tên nhóm",
                               mData: "name_group",
                            },
                            {
                               sTitle: "Ngày",
                               mData: "day",
                            },
                            {
                               sTitle: "Liên kết tối đa",
                               mData: "joinmax",
                            },
                            {
                               sTitle: "Kết quả",
                               mData: "result",
                            },
                            {
                               sTitle: "Min",
                               mData: "min",
                            },
                            {
                               sTitle: "Max",
                               mData: "max",
                            },
                            {
                               sTitle: "Tùy Chọn",
                               mData: "id",
                               mRender: function (data,avg1,avg) {
                                   return "<a class='btn btn-success btn-xs' href='javascript:;' onclick='loadIframecontentResult("+avg.id+",\""+avg.name_group+"\",\""+avg.day+"\");'>Kết quả</a>\n\
                                            <a class='btn btn-success btn-xs' href='/?control=rednumber&func=edit&view=<?php echo $_GET['view'];?>&module=all&id=" + data + "'>Sửa</a>\n\
                                           <a class='btn btn-danger btn-xs' onclick=\"if(!window.confirm('Bạn có muốn xóa không ?')) return false;\" href='/?control=rednumber&func=delete&view=<?php echo $_GET['view'];?>&module=all&id=" + data + "'>Xóa</a>";
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
            <?php include APPPATH . 'views/game/Events/rednumber/tab.php'; ?>
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
    function loadIframecontentResult(tid,name_group,day) {
        $("#messgage").html('<iframe style="width:100%;height:350px;border:0px;" id="ifmresultcontent" src="<?php echo APPLICATION_URL;?>?control=rednumber&func=index&view=result&module=all&iframe=1&tid='+tid+'"></iframe>');
        $('.bs-example-modal-sm').modal('show');
        $("h4.modal-title").text("Kết quả "+name_group+' Ngày '+ day);
    } 
</script>