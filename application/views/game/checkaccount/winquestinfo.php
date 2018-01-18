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
                <input type="text" name="playerid" value="<?php echo $_POST['playerid'];?>" class="textinput" placeholder="Nhập mã người chơi" title="Nhập mã người chơi"/>
                <span>
                    <select name="game_server_id">
                        <option value="0">Chọn server</option>
                        <?php
                            if(empty($slbServer) !== TRUE){
                                foreach($slbServer as $v){
                        ?>
                        <option value="<?php echo $v['server_id'];?>" <?php echo ($v['server_id']==$_POST['game_server_id'])?'selected="selected"':'';?>><?php echo $v['server_name'];?></option>
                        <?php
                                }
                            }
                        ?>
                    </select>
                </span>
                <input type="text" name="zoneid" value="<?php echo $_POST['zoneid'];?>" class="textinput" placeholder="Nhập Zone ID" title="Nhập Zone ID"/>
                <span><input type="submit" value="Tìm" class="btn btn-primary"/></span>
            </div>
            <div class="content_search">
                <div class="title_search">Kết quả tìm kiếm: </div>
                <div class="main_search">
                    <table width="100%" border="0" class="table table-striped table-bordered table-condensed table-hover">
                        <thead>
                            <?php
                                if(count($item)>0){
                            ?>
                            <tr>
                                <th colspan="2">ID nhân vật (playerId) : <?php echo $item['playerId'];?></th>
                                <th colspan="3">Tên nhân vật (playerName) : <?php echo $item['playerName'];?></th>
                            </tr>
                            <?php
                                }
                            ?>
                            <tr>
                                <th>ID ải (questId)</th>
                                <th>Cấp sao (star)</th>
                                <th>Tên ải (questName)</th>
                                <th>Tên chương (chapterName)</th>
                                <th>Thời gian hoàn thành (finishTime)</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php 
                                if(count($item)>0){
                                    if(count($item['winQuest'])>0){
                                        foreach($item['winQuest'] as $v){
                            ?>
                            <tr>
                                <td align="center"><?php echo $v['questId'];?></td>
                                <td align="center"><?php echo $v['star'];?></td>
                                <td align="center"><?php echo $v['questName'];?></td>
                                <td align="center"><?php echo $v['chapterName'];?></td>
                                <td align="center"><?php echo $v['finishTime'];?></td>
                            </tr>
                            <?php
                                        }
                                    }
                                }else{
                            ?>
                            <tr>
                                <td align="center" colspan="5" class="error">Không tìm thấy dữ liệu</td>
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