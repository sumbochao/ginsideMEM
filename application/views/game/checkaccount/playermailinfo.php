<link rel="stylesheet" href="<?php echo base_url('assets/datetime/css/style.css'); ?>"/>
<link rel="stylesheet" href="<?php echo base_url('assets/datetime/css/bootstrap.css'); ?>"/>
<link rel="stylesheet" href="<?php echo base_url('assets/css/lightbox.css'); ?>"/>
<script src="<?php echo base_url('assets/js/lightbox.js'); ?>"></script>
<script src="<?php echo base_url('assets/popup/bootstrap-modal.js') ?>"></script>
<script src="<?php echo base_url('assets/popup/bootstrap-transition.js') ?>"></script>

<style>
    span input[type='submit']{
        margin-top: -10px;
    }
    .content_search .title_search{
        color: red;
        font-weight: bold;
        font-size: 13px;
    }
    .main_search{
        margin-top: 10px;
    }
    .textinput{
        width: 180px;
    }
    .error{
        color: red;
    }
    .widget_content{
        margin-top: 15px;
    }
    h4.widget-name{
        font-size: 17px;
        text-transform: uppercase;
        margin-top: 0px;
        font-weight: bold;
        margin-bottom: 15px;
    }
</style>
<div class="loading_warning"></div>
<div id="content-t" style="min-height:500px; padding-top:10px">
    <?php include APPPATH . 'views/game/checkaccount/tab.php'; ?>
    <div class="widget_content">
        <form id="appForm" action="" method="post" name="appForm">
            <div class="filter">
                <input type="text" name="playerId" value="<?php echo $_POST['playerId'];?>" class="textinput" placeholder="Nhập mã người chơi" title="Nhập mã người chơi"/>
                <span>
                    <select name="serverId">
                        <option value="0">Chọn server</option>
                        <?php
                            if(empty($slbServer) !== TRUE){
                                foreach($slbServer as $v){
                        ?>
                        <option value="<?php echo $v['server_id'];?>" <?php echo ($v['server_id']==$_POST['serverId'])?'selected="selected"':'';?>><?php echo $v['server_name'];?></option>
                        <?php
                                }
                            }
                        ?>
                    </select>
                </span>
                <input type="text" name="zoneId" value="<?php echo $_POST['zoneId'];?>" class="textinput" placeholder="Nhập Zone ID" title="Nhập Zone ID"/>
                <input type="text" name="startDate" value="<?php echo $_POST['startDate'];?>" class="textinput datetime" placeholder="Ngày bắt đầu" title="Ngày bắt đầu"/>
                <input type="text" name="endDate" value="<?php echo $_POST['endDate'];?>" class="textinput datetime" placeholder="Ngày kết thúc" title="Ngày kết thúc"/>
                <input type="text" name="page" value="<?php echo ($_POST['page']>0)?$_POST['page']:1;?>" class="textinput" placeholder="Số trang" title="Số trang"/>
                <input type="text" name="perpage" value="<?php echo ($_POST['perpage']>0)?$_POST['perpage']:20;?>" class="textinput" placeholder="Số lượng mỗi trang" title="Số lượng mỗi trang"/>
                <span><input type="submit" value="Tìm" class="btn btn-primary"/></span>
            </div>
            <div class="content_search">
                <div class="title_search">Kết quả tìm kiếm: </div>
                <div class="main_search">
                    <table width="100%" border="0" class="table table-striped table-bordered table-condensed table-hover">
                        <thead>
                            <tr>
                                <th>ID nhân vật (playerId)</th>
                                <th>Tên nhân vật (playerName)</th>
                                <th>ID item (itemId)</th>
                                <th>Tên item (itemName)</th>
                                <th>Số item (itemNum)</th>
                                <th>Cấp item (itemLv)</th>
                                <th>Ngày nhận (createDate)</th>
                                <th>Tên tướng mang vào (cardName)</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php echo "<pre>";print_r($item);echo "<pre>";
                                if(count($item)>0){
                                    foreach($item as $v){
                            ?>
                            <tr>
                                <td align="center"><?php echo $v['playerId'];?></td>
                                <td align="center"><?php echo $v['playerName'];?></td>
                                <td align="center"><?php echo $v['itemId'];?></td>
                                <td align="center"><?php echo $v['itemName'];?></td>
                                <td align="center"><?php echo $v['itemNum'];?></td>
                                <td align="center"><?php echo $v['itemLv'];?></td>
                                <td align="center"><?php echo date_format(date_create($v['createDate']),"d-m-Y G:i:s");?></td>
                                <td align="center"><?php echo $v['cardName'];?></td>
                            </tr>
                            <?php
                                    }
                                }else{
                            ?>
                            <tr>
                                <td align="center" colspan="8" class="error">Không tìm thấy dữ liệu</td>
                            </tr>
                            <?php
                                }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </form>
    </div>
</div>
<script>
    $('.datetime').datetimepicker({
        dateFormat: 'dd-mm-yy',
        timeFormat: 'hh:mm:ss'//
    });
</script>