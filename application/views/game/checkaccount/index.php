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
                            <tr>
                                <th>Field</th>
                                <th>Value</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php 
                                    if(count($item)>0){
                            ?>
                            <tr>
                                <td align="center">Chiến Lực (battleScore):</td>
                                <td align="center"><?php echo $item['battleScore'];?></td>
                            </tr>
                            <tr>
                                <td align="center">Nguyên Khí (coin):</td>
                                <td align="center"><?php echo $item['coin'];?></td>
                            </tr>
                            <tr>
                                <td align="center">Ngày tạo (createDate):</td>
                                <td align="center"><?php echo date_format(date_create($item['createDate']),"d-m-Y G:i:s");?></td>
                            </tr>
                            <tr>
                                <td align="center">Tinh Hồn (daoXing):</td>
                                <td align="center"><?php echo $item['daoXing'];?></td>
                            </tr>
                            <tr>
                                <td align="center">Thiết bị cuối (device):</td>
                                <td align="center"><?php echo $item['device'];?></td>
                            </tr>
                            <tr>
                                <td align="center">Số bạn tối đa (friendsMaxLimit):</td>
                                <td align="center"><?php echo $item['friendsMaxLimit'];?></td>
                            </tr>
                            <tr>
                                <td align="center">Số bạn (friendsNum):</td>
                                <td align="center"><?php echo $item['friendsNum'];?></td>
                            </tr>
                            <tr>
                                <td align="center">Vàng (gold):</td>
                                <td align="center"><?php echo $item['gold'];?></td>
                            </tr>
                            <tr>
                                <td align="center">IP (ip):</td>
                                <td align="center"><?php echo $item['ip'];?></td>
                            </tr>
                            <tr>
                                <td align="center">Login cuối (loginDate):</td>
                                <td align="center"><?php echo $item['loginDate'];?></td>
                            </tr>
                            <tr>
                                <td align="center">Logout cuối (logoutDate):</td>
                                <td align="center"><?php echo $item['logoutDate'];?></td>
                            </tr>
                            <tr>
                                <td align="center">Level (lv):</td>
                                <td align="center"><?php echo $item['lv'];?></td>
                            </tr>
                            <tr>
                                <td align="center">Platform (platform):</td>
                                <td align="center"><?php echo $item['platform'];?></td>
                            </tr>
                            <tr>
                                <td align="center">UID (playerId):</td>
                                <td align="center"><?php echo $item['playerId'];?></td>
                            </tr>
                            <tr>
                                <td align="center">Tên nhân vật (playerName):</td>
                                <td align="center"><?php echo $item['playerName'];?></td>
                            </tr>
                            <tr>
                                <td align="center">Tổng số trận đấu trường (pvpFightTotalNum):</td>
                                <td align="center"><?php echo $item['pvpFightTotalNum'];?></td>
                            </tr>
                            <tr>
                                <td align="center">Tổng số trận thắng (pvpFightWinNum):</td>
                                <td align="center"><?php echo $item['pvpFightWinNum'];?></td>
                            </tr>
                            <tr>
                                <td align="center">Hạng Đấu Trường (pvpRank):</td>
                                <td align="center"><?php echo $item['pvpRank'];?></td>
                            </tr>
                            <tr>
                                <td align="center">Số trận thắng trong ngày (pvpWinNum):</td>
                                <td align="center"><?php echo $item['pvpWinNum'];?></td>
                            </tr>
                            <tr>
                                <td align="center">Liên thắng hiện tại (pvpWins):</td>
                                <td align="center"><?php echo $item['pvpWins'];?></td>
                            </tr>
                            <tr>
                                <td align="center">Hạng sát thương Thần Ma (shenMoDmgRank):</td>
                                <td align="center"><?php echo $item['shenMoDmgRank'];?></td>
                            </tr>
                            <tr>
                                <td align="center">Hạng Thần Ma (shenMoRank):</td>
                                <td align="center"><?php echo $item['shenMoRank'];?></td>
                            </tr>
                            <tr>
                                <td align="center">Danh Vọng (shengWang):</td>
                                <td align="center"><?php echo $item['shengWang'];?></td>
                            </tr>
                            <tr>
                                <td align="center">Bạc (silver):</td>
                                <td align="center"><?php echo $item['silver'];?></td>
                            </tr>
                            <tr>
                                <td align="center">Tinh Lực (spirit):</td>
                                <td align="center"><?php echo $item['spirit'];?></td>
                            </tr>
                            <tr>
                                <td align="center">Thể Lực (stamina):</td>
                                <td align="center"><?php echo $item['stamina'];?></td>
                            </tr>
                            <tr>
                                <td align="center">Logout cuối (userId):</td>
                                <td align="center"><?php echo $item['userId'];?></td>
                            </tr>
                            <tr>
                                <td align="center">MSI (username):</td>
                                <td align="center"><?php echo $item['username'];?></td>
                            </tr>
                            <tr>
                                <td align="center">VIP (vip):</td>
                                <td align="center"><?php echo $item['vip'];?></td>
                            </tr>
                            <tr>
                                <td align="center">Tiên Duyên (xianYuan):</td>
                                <td align="center"><?php echo $item['xianYuan'];?></td>
                            </tr>
                            <tr>
                                <td align="center">Vé Ngọc (xiuWei):</td>
                                <td align="center"><?php echo $item['xiuWei'];?></td>
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