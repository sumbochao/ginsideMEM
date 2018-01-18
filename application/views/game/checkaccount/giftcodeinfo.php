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
        width: 200px;
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
                <input type="text" name="giftId" value="<?php echo $_POST['giftId'];?>" class="textinput" placeholder="Gift ID" title="Gift ID"/>
                <input type="text" name="zoneid" value="<?php echo $_POST['zoneid'];?>" class="textinput" placeholder="Zone ID" title="Zone ID"/>
                <span><input type="submit" value="Tìm" class="btn btn-primary"/></span>
            </div>
            <div class="content_search">
                <div class="title_search">Kết quả tìm kiếm: </div>
                <div class="main_search">
                    <table width="100%" border="0" class="table table-striped table-bordered table-condensed table-hover">
                        <thead>
                            <tr>
                                <th>Field</th>
                                <th>Value</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                                if(count($item)>0){
                                    $reqJson = json_decode($item['reqJson'],true);
                            ?>
                            <tr>
                                <td align="center">Giftcode (code)</td>
                                <td align="center"><?php echo $item['code'];?></td>
                            </tr>
                            <tr>
                                <td align="center">Batch túi quà (cardType)</td>
                                <td align="center"><?php echo $item['cardType'];?></td>
                            </tr>
                            <tr>
                                <td align="center">Server dùng (reqServerId)</td>
                                <td align="center"><?php echo $reqJson['reqServerId'];?></td>
                            </tr>
                            <tr>
                                <td align="center">ID login (userId)</td>
                                <td align="center"><?php echo $item['userId'];?></td>
                            </tr>
                            <tr>
                                <td align="center">Server của gamer (serverId)</td>
                                <td align="center"><?php echo $item['serverId'];?></td>
                            </tr>
                            <tr>
                                <td align="center">ID gamer (playerId)</td>
                                <td align="center"><?php echo $item['playerId'];?></td>
                            </tr>
                            <tr>
                                <td align="center">Tên nhân vật (playerName)</td>
                                <td align="center"><?php echo $item['playerName'];?></td>
                            </tr>
                            <tr>
                                <td align="center">Đã được dùng (used)</td>
                                <td align="center"><?php echo $item['used'];?></td>
                            </tr>
                            <?php
                                }else{
                            ?>
                            <tr>
                                <td align="center" colspan="2" class="error">Không tìm thấy dữ liệu</td>
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