<link rel="stylesheet" href="<?php echo base_url('assets/datetime/css/style.css'); ?>"/>
<link rel="stylesheet" href="<?php echo base_url('assets/datetime/css/bootstrap.css'); ?>"/>
<div id="content-t" style="min-height:500px; padding-top:10px">
    <style>
        #loading {width: 100%;height: 100%;top: 0px;left: 0px;position: fixed;display: block; z-index: 99;}
        #loading-image {position: absolute;top: 40%;left: 45%;z-index: 100} 
        label {width: auto !important;color: #f36926;}
        .btn{
            position: relative;
            top:-5px;
        }
    </style>
    <?php
        if(isset($_POST['game_id'])){
            if($_SESSION['account']['id_group']==2){
                if($_POST['game_id']>=0){
                    $gameid = $_POST['game_id'];
                }else{
                    $gameid = $game_id;
                }
            }else{
                if($_POST['game_id']>=0){
                    $gameid = $_POST['game_id'];
                }
            }
        }else{
            if($_SESSION['account']['id_group']==2){
                $gameid = $game_id;
            }
        }
    ?>
    <script type="text/javascript">
        $(document).ready(function () {
            getData();
            $('#create').on('click', function () {
                window.location.href = '/?control=cardgame&func=add&view=<?php echo $_GET['view'];?>&module=all';
            });
        });
        function getData() {
            $.ajax({
                url: "<?php echo $url_service; ?>/cms/cardgame/index_<?php echo $_GET['view'];?>?game_id=<?php echo $gameid;?>",
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
                               sTitle: "Game ID",
                               mData: "game_id",
                            },
                            {
                               sTitle: "Tên",
                               mData: "name",
                            },
                            {
                               sTitle: "Chính",
                               mData: "primary",
                            },
                            {
                               sTitle: "Đơn vị",
                               mData: "unit",
                            },
                            {
                               sTitle: "Bắt đầu",
                               mData: "startdate",
                            },
                            {
                               sTitle: "Kết thúc",
                               mData: "enddate",
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
                                   return "<a class='btn btn-success btn-xs' href='/?control=cardgame&func=edit&view=<?php echo $_GET['view'];?>&module=all&id=" + data + "'>Sửa</a>\n\
                                           <a class='btn btn-danger btn-xs' style='display:none' onclick=\"if(!window.confirm('Bạn có muốn xóa không ?')) return false;\" href='/?control=cardgame&func=delete&view=<?php echo $_GET['view'];?>&module=all&id=" + data + "'>Xóa</a>";
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
            <?php include APPPATH . 'views/game/Events/cardgame/tab.php'; ?>
            <div class="widget-name">
                <div class="clearboth"></div>
            </div>
            <!--END CONTROL ADD CHEST-->
            <div class="widget" id="viewport">
                <div class="well form-horizontal">
                    <div class="table-overflow">     
                        <div style="margin-top: 10px; margin-bottom: 10px;">
                            <form action="" method="post">
                                <select name="game_id">
                                   <option value="-1">Chọn game</option>
                                   <?php 
                                       if(count($slbGame)>0){
                                           foreach($slbGame as $v){
                                               if((@in_array($_GET['control'].'-'.$v['app_name'], $_SESSION['permission']) && $_SESSION['account']['id_group']==2) || $_SESSION['account']['id_group']==1){
                                   ?>
                                   <option value="<?php echo $v['service_id'];?>" <?php echo $_POST['game_id']==$v['service_id']?'selected="selected"':'';;?>><?php echo $v['app_fullname'].' ('.$v['service_id'].')';?></option>
                                   <?php
                                               }
                                           }
                                       }
                                   ?>
                               </select>
                                <button id="submit"  class="btn btn-primary"><span>Tìm kiếm</span></button>
                                <button id="create"  class="btn btn-primary" onclick='return false;'><span>THÊM MỚI</span></button>
                            </form>
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