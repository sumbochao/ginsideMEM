<link rel="stylesheet" href="<?php echo base_url('assets/datetime/css/style.css'); ?>"/>
<link rel="stylesheet" href="<?php echo base_url('assets/datetime/css/bootstrap.css'); ?>"/>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js" type="text/javascript" type="text/javascript"></script>
<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/prettyPhotos/prettyPhoto.css'); ?>" media="screen" title="prettyPhoto main stylesheet" charset="utf-8" />
<script type="text/javascript" src="<?php echo base_url('assets/css/prettyPhotos/jquery.prettyPhoto.js'); ?>"></script>
<script type="text/javascript" charset="utf-8">
    $(document).ready(function () {
        $("a[rel^='prettyPhoto']").prettyPhoto({
            allow_resize: false
        });
    });
    $("a[rel^='prettyPhoto3']").prettyPhoto({animationSpeed: 'fast', slideshow: 10000});
    $("a[rel^='prettyPhoto2']").prettyPhoto({animationSpeed: 'fast', slideshow: 10000});
</script>
<style>
    .main-bar{
        display:none;
    }
</style>
<div id="content-t" class="content_form" style="min-height:500px; padding-top:10px">

    <?php
    if (!isset($_GET['type']) || $_GET['type'] == "filter") {
        ?>
        <form id="appForm" action="" method="post" name="appForm">
            <?php include_once 'include/toolbar.php'; ?>
            <div class="filter">
                <input type="text" name="code" id="code" value="<?php echo $_POST['code']; ?>" class="textinput" placeholder="Nhập code ..." title="Nhập code ..." maxlength="20" style="width:150px;"   onblur="searchnotes(this.value);"/>
                <select name="cbo_app" id="cbo_app" class="chosen-select" tabindex="2" data-placeholder="Chọn game">
                    <option value="0">Chọn Game</option>
                    <?php
                    $arrGame = explode('-', $_POST['cbo_app']);
                    $_POST['cbo_app'] = $arrGame[0];
                    if (count($loadgame) > 0) {
                        foreach ($loadgame as $v) {
                            ?>
                            <option value="<?php echo $v['service_id'] . '-' . $v['type']; ?>" <?php echo ($_POST['cbo_app'] == $v['service_id']) || ($_GET['service_id'] == $v['service_id']) ? 'selected="selected"' : ''; ?>><?php echo $v['app_fullname']; ?></option>
                            <?php
                        }
                    }
                    ?>
                </select>
                <select name="cbo_platform">
                    <option value="0">Chọn Platform</option>
                    <?php
                    if (count($loadplatform) > 0) {
                        foreach ($loadplatform as $key => $value) {
                            ?>
                            <option value="<?php echo $key; ?>" <?php echo ($_POST['cbo_platform'] == $key) || ($_GET['platform'] == $key) ? 'selected="selected"' : ''; ?>><?php echo $value; ?></option>
                            <?php
                        }
                    }
                    ?>
                </select>
                <select name="cbo_status">
                    <option value="0">Chọn Status</option>
                    <?php
                    if (count($loadstatus) > 0) {
                        foreach ($loadstatus as $key => $value) {
                            ?>
                            <option value="<?php echo $key; ?>" <?php echo $_POST['cbo_status'] == $key ? 'selected="selected"' : ''; ?>><?php echo $value; ?></option>
                            <?php
                        }
                    }
                    ?>
                </select>
                <!--<select name="cbo_published" id="cbo_published" onchange="setrows(this.value);">
                            <option value="0">Kiểu Published</option>
                                <option value="yes">Yes</option>
                                <option value="no">No</option>
                        </select>-->
                <?php
                /* if((@in_array($_GET['control'].'-filter', $_SESSION['permission']) && $_SESSION['account']['id_group']==2)|| $_SESSION['account']['id_group']==1){
                  $lnkFilter = "onSubmitForm('appForm','".base_url()."?control=".$_GET['control']."&func=".$_GET['func']."&type=filter')";
                  }else{
                  $lnkFilter = "alert('Bạn không có quyền truy cập chức năng này!')";
                  } */
                $lnkFilter = "onSubmitForm('appForm','" . base_url() . "?control=" . $_GET['control'] . "&func=" . $_GET['func'] . "&type=filter')";
                ?>
                <input type="button" onclick="return checknull();" value="Tìm" class="btnB btn-primary"/>   
            </div>
            <div class="filter">
                <select name="cbo_published" id="cbo_published" onchange="setrows(this.value);" style="width:110px;margin-bottom:0;font-weight:bold;margin-bottom:10px;">
                    <option value="0" >Published</option>
                    <option value="waiting">Waiting ...</option>
                    <option value="0">All</option>
                    <option value="yes">Yes</option>
                    <option value="no">No</option>

                </select>
            </div>
            <div class="wrapper_scroolbar" style="height:350px;" >
                <div class="scroolbar">
                    <?php
                        if($views=='global'){
                    ?>
                    <table width="100%" border="0" class="table table-striped table-bordered table-condensed table-hover" id="tbl_viewdata">
                        <thead>
                            <tr>
                                <!--<th align="center" width="50px"><input type="checkbox" name="checkbox" onclick="checkedAll();"/></th>-->
                                <th align="center" width="200px">Tool</th>
                                <th align="center" width="30">STT</th>
                                <th align="center" width="30">ID</th>
                                <th align="center" width="70">Code</th>
                                <th align="center" width="190px">Game</th>
                                <th align="center" width="80px">Platform</th>
                                <th align="center" width="80px">Date publish</th>
                                <th align="center" width="80px">Bunlde</th>
                                <th align="center" width="80px">Status</th>
                                <th align="center" width="120px">Published</th>
                                <th align="center" width="100px">Type App</th>
                                <th align="center" width="100px">Me button</th>
                                <th align="center" width="80px">Me chat</th>
                                <th align="center" width="80px">Me event</th>
                                <th align="center" width="80px">Me game</th>
                                <th align="center" width="80px">Me login</th>
                                <th align="center" width="80px">Me GM</th>
                                <th align="center" width="70">State</th>
                                <th align="center" width="70">MSG</th>
                                <th align="center" width="150px">Create Time</th>

                                <th align="center" width="550px;">Notes</th>

                                <th align="center" width="120px">User</th>


                            </tr>
                        </thead>
                        <tbody>
                        <?php
                            $i = 0;
                            if (!empty($api_view_gsv['data'])) {

                                foreach ($api_view_gsv['data'] as $key => $value) {

                                    $i++;
                                    $rowdb['data'] = $value;
                                    if ($rowdb['data']['id'] == "") {
                                        break;
                                    }
                                    ?>
                                    <tr id="rows_<?php echo $i; ?>" class="rows_class">

                                        <?php
                                        if (count($rowdb['data']) > 0) {
                                            if (!$this->db_slave1)
                                                $this->db_slave1 = $this->load->database(array('db' => 'gapi', 'type' => 'slave'), TRUE);
                                            $this->db_slave1->select(array('service_id', 'app_fullname'));
                                            $this->db_slave1->where('service_id', $rowdb['data']['service_id']);
                                            $data = $this->db_slave1->get('scopes');
                                            if (is_object($data)) {
                                                $result = $data->result_array();
                                            }
                                            ////////////////////
                                            if (!$this->db_slave)
                                                $this->db_slave = $this->load->database(array('db' => 'inside_info', 'type' => 'slave'), TRUE);
                                            $this->db_slave->select(array('*'));
                                            $this->db_slave->where('service_id', $rowdb['data']['service_id']);
                                            $this->db_slave->where('msv_id', $rowdb['data']['gsv_id']);
                                            $this->db_slave->where('platform', $rowdb['data']['platform']);
                                            /* if(isset($_POST['cbo_published']) && $_POST['cbo_published']!='0'){
                                              $this->db_slave->where('published',$_POST['cbo_published']);
                                              } */

                                            $data1 = $this->db_slave->get('tbl_get_msv');
                                            if (is_object($data1)) {
                                                $result1 = $data1->result_array();
                                            }
                                            ?>
                                            <td><a href="javascript:void(0);" onclick="onSubmitForm('appForm', '<?php echo base_url() . "?control=" . $_GET['control'] . "&func=edit&type_game=global&idv=" . $result1[0]['id'] . "&service_id=" . $rowdb['data']['service_id'] . "&msv_id=" . $rowdb['data']['gsv_id'] . "&platform=" . $rowdb['data']['platform'] . "&status=" . $rowdb['data']['status'] . "&type_app=" . $result1[0]['type_app'] . "&published=" . $result1[0]['published'] . "&id=" . $rowdb['data']['id'] . "&notes=" . base64_encode($result1[0]['notes'] == "" ? "" : $result1[0]['notes']) . "&cert_id=" . $result1[0]['cert_id'] . "&bunlderid=" . base64_encode($result1[0]['bunlderid']) . "&mebutton=" . $rowdb['data']['me_button'] . "&mechat=" . $rowdb['data']['me_chat'] . "&meevent=" . $rowdb['data']['me_event'] . "&megame=" . $rowdb['data']['me_game'] . "&melogin=" . $rowdb['data']['me_login'] . "&datepublish=" . $result1[0]['datepublish'] . "&memsg=" . base64_encode($rowdb['data']['msg_login'] == "" ? "{\"link\":\"\",\"message\":\"\"}" : $rowdb['data']['msg_login']); ?>')">Edit Msv</a> | 
                                            <!--<a href="javascript:void(0);" onclick="popitup('<?= base_url() . "?control=popupbutton&func=index&id=" . $rowdb['data']['id']; ?>','Xem log');">Edit button</a>-->
                                            <!--<a href="<?= base_url() . "popup_button.php?msv_id=" . $rowdb['data']['msv_id'] . "&platform=" . $rowdb['data']['platform'] . "&id=" . $rowdb['data']['id'] . "&mebutton=" . $rowdb['data']['me_button'] . "&mechat=" . $rowdb['data']['me_chat'] . "&meevent=" . $rowdb['data']['me_event'] . "&megame=" . $rowdb['data']['me_game'] . "&melogin=" . $rowdb['data']['me_login'] . "&memsg=ok&iframe=true&width=800&height=200&"; ?>" rel="prettyPhoto2[iframes]" >Edit button 1</a>-->
                                                <a href="<?= base_url() . "?control=popupbutton&func=index&type_game=global&msv_id=" . $rowdb['data']['gsv_id'] . "&platform=" . $rowdb['data']['platform'] . "&status=" . $rowdb['data']['status'] . "&service_id=" . $rowdb['data']['service_id'] . "&id=" . $rowdb['data']['id'] . "&mebutton=" . $rowdb['data']['me_button'] . "&mechat=" . $rowdb['data']['me_chat'] . "&meevent=" . $rowdb['data']['me_event'] . "&megame=" . $rowdb['data']['me_game'] . "&state=" . $rowdb['data']['state'] . "&megm=" . $rowdb['data']['me_gm'] . "&memsg=" . base64_encode($rowdb['data']['msg_login'] == "" ? "{\"link\":\"\",\"message\":\"\"}" : $rowdb['data']['msg_login']) . "&iframe=true&width=330&height=430"; ?>" rel="prettyPhoto2[iframes]" >Edit Me button</a>
                                            </td>
                                            <td><?php echo trim($i); ?></td>
                                            <td><?php echo $rowdb['data']['id']; ?></td>	
                                            <td><strong style="color:#0b55c4;"><?php echo $rowdb['data']['gsv_id']; ?></strong></td>
                                            <td><?php echo $result[0]['app_fullname']; ?></td>
                                            <td><?php echo $rowdb['data']['platform']; ?></td>
                                            <td><?php echo ($result1[0]['datepublish'] == "0000-00-00 00:00:00") || ($result1[0]['datepublish'] == "") ? "" : date_format(date_create($result1[0]['datepublish']), "d/m/Y H:m:s"); ?></td>
                                            <td><?php echo $result1[0]['bunlderid']; ?></td>
                                            <td><?php echo $rowdb['data']['status']; ?></td>
                                            <td id="td_<?php echo $i; ?>"><?php echo trim($result1[0]['published']); ?></td>
                                            <td><?php echo $result1[0]['type_app']; ?></td>
                                            <td><?php echo $rowdb['data']['me_button'] == "on" ? "<strong style='color:#0B41C4'>on</strong>" : "<strong style='color:#C40B3A'>off</strong>"; ?></td>
                                            <td><?php echo $rowdb['data']['me_chat'] == "on" ? "<strong style='color:#0B41C4'>on</strong>" : "<strong style='color:#C40B3A'>off</strong>"; ?></td>
                                            <td><?php echo $rowdb['data']['me_event'] == "on" ? "<strong style='color:#0B41C4'>on</strong>" : "<strong style='color:#C40B3A'>off</strong>"; ?></td>
                                            <td><?php echo $rowdb['data']['me_game'] == "on" ? "<strong style='color:#0B41C4'>on</strong>" : "<strong style='color:#C40B3A'>off</strong>"; ?></td>
                                            <td><?php echo $rowdb['data']['me_login'] == "on" ? "<strong style='color:#0B41C4'>on</strong>" : "<strong style='color:#C40B3A'>off</strong>"; ?></td>
                                            <td><?php echo $rowdb['data']['me_gm'] == "on" ? "<strong style='color:#0B41C4'>on</strong>" : "<strong style='color:#C40B3A'>off</strong>"; ?></td>
                                            <td><?php echo $rowdb['data']['state']; ?></td>
                                            <td><?php $js = json_decode($rowdb['data']['msg_login'],true);
                                                        echo $js['link'] . "<br/>" . $js['message']; ?>
                                            </td>
                                            <td><?php echo $rowdb['data']['created_date']; ?></td>

                                            <td title="<?php echo $result1[0]['notes']; ?>"><?php echo $result1[0]['notes']; ?></td>

                                            <td><?php echo $slbUser[$result1[0]['users_act']]['username']; ?></td>	
                                            <?php }//end if 
                                        ?>

                                    </tr>

                                <?php
                                }//end for
                            } else {
                                ?>
                                <tr>
                                    <td colspan="9">Không tìm thấy dữ liệu</td>
                                </tr>
    <?php }//end if  ?>
                        </tbody>
                    </table>
                    <?php
                        }else{
                    ?>
                    <table width="100%" border="0" class="table table-striped table-bordered table-condensed table-hover" id="tbl_viewdata">
                        <thead>
                            <tr>
                                <!--<th align="center" width="50px"><input type="checkbox" name="checkbox" onclick="checkedAll();"/></th>-->
                                <th align="center" width="200px">Tool</th>
                                <th align="center" width="30">STT</th>
                                <th align="center" width="30">ID</th>
                                <th align="center" width="70">Code</th>
                                <th align="center" width="190px">Game</th>
                                <th align="center" width="80px">Platform</th>
                                <th align="center" width="80px">Date publish</th>
                                <th align="center" width="80px">Bunlde</th>
                                <th align="center" width="80px">Status</th>
                                <th align="center" width="120px">Published</th>
                                <th align="center" width="100px">Type App</th>
                                <th align="center" width="100px">Me button</th>
                                <th align="center" width="80px">Me chat</th>
                                <th align="center" width="80px">Me event</th>
                                <th align="center" width="80px">Me game</th>
                                <!--<th align="center" width="80px">Me login</th>-->
                                <th align="center" width="80px">Me GM</th>
                                <th align="center" width="70">State</th>
                                <th align="center" width="70">MSG</th>
                                <th align="center" width="150px">Create Time</th>

                                <th align="center" width="550px;">Notes</th>

                                <th align="center" width="120px">User</th>


                            </tr>
                        </thead>
                        <tbody>
                        <?php
                            $i = 0;
                            if (!empty($api_view_msv['data'])) {

                                foreach ($api_view_msv['data'] as $key => $value) {

                                    $i++;
                                    $rowdb['data'] = $value;
                                    if ($rowdb['data']['id'] == "") {
                                        break;
                                    }
                                    ?>
                                    <tr id="rows_<?php echo $i; ?>" class="rows_class">

                                        <?php
                                        if (count($rowdb['data']) > 0) {
                                            if (!$this->db_slave1)
                                                $this->db_slave1 = $this->load->database(array('db' => 'gapi', 'type' => 'slave'), TRUE);
                                            $this->db_slave1->select(array('service_id', 'app_fullname'));
                                            $this->db_slave1->where('service_id', $rowdb['data']['service_id']);
                                            $data = $this->db_slave1->get('scopes');
                                            if (is_object($data)) {
                                                $result = $data->result_array();
                                            }
                                            ////////////////////
                                            if (!$this->db_slave)
                                                $this->db_slave = $this->load->database(array('db' => 'inside_info', 'type' => 'slave'), TRUE);
                                            $this->db_slave->select(array('*'));
                                            $this->db_slave->where('service_id', $rowdb['data']['service_id']);
                                            $this->db_slave->where('msv_id', $rowdb['data']['msv_id']);
                                            $this->db_slave->where('platform', $rowdb['data']['platform']);
                                            /* if(isset($_POST['cbo_published']) && $_POST['cbo_published']!='0'){
                                              $this->db_slave->where('published',$_POST['cbo_published']);
                                              } */

                                            $data1 = $this->db_slave->get('tbl_get_msv');
                                            if (is_object($data1)) {
                                                $result1 = $data1->result_array();
                                            }
                                            ?>
                                            <td><a href="javascript:void(0);" onclick="onSubmitForm('appForm', '<?php echo base_url() . "?control=" . $_GET['control'] . "&func=edit&idv=" . $result1[0]['id'] . "&service_id=" . $rowdb['data']['service_id'] . "&msv_id=" . $rowdb['data']['msv_id'] . "&platform=" . $rowdb['data']['platform'] . "&status=" . $rowdb['data']['status'] . "&type_app=" . $result1[0]['type_app'] . "&published=" . $result1[0]['published'] . "&id=" . $rowdb['data']['id'] . "&notes=" . base64_encode($result1[0]['notes'] == "" ? "" : $result1[0]['notes']) . "&cert_id=" . $result1[0]['cert_id'] . "&bunlderid=" . base64_encode($result1[0]['bunlderid']) . "&mebutton=" . $rowdb['data']['me_button'] . "&mechat=" . $rowdb['data']['me_chat'] . "&meevent=" . $rowdb['data']['me_event'] . "&megame=" . $rowdb['data']['me_game'] . "&melogin=" . $rowdb['data']['me_login'] . "&datepublish=" . $result1[0]['datepublish'] . "&memsg=" . base64_encode($rowdb['data']['msg_login'] == "" ? "{\"link\":\"\",\"message\":\"\"}" : $rowdb['data']['msg_login']); ?>')">Edit Msv</a> | 
                                            <!--<a href="javascript:void(0);" onclick="popitup('<?= base_url() . "?control=popupbutton&func=index&id=" . $rowdb['data']['id']; ?>','Xem log');">Edit button</a>-->
                                            <!--<a href="<?= base_url() . "popup_button.php?msv_id=" . $rowdb['data']['msv_id'] . "&platform=" . $rowdb['data']['platform'] . "&id=" . $rowdb['data']['id'] . "&mebutton=" . $rowdb['data']['me_button'] . "&mechat=" . $rowdb['data']['me_chat'] . "&meevent=" . $rowdb['data']['me_event'] . "&megame=" . $rowdb['data']['me_game'] . "&melogin=" . $rowdb['data']['me_login'] . "&memsg=ok&iframe=true&width=800&height=200&"; ?>" rel="prettyPhoto2[iframes]" >Edit button 1</a>-->
                                                <a href="<?= base_url() . "?control=popupbutton&func=index&msv_id=" . $rowdb['data']['msv_id'] . "&platform=" . $rowdb['data']['platform'] . "&status=" . $rowdb['data']['status'] . "&service_id=" . $rowdb['data']['service_id'] . "&id=" . $rowdb['data']['id'] . "&mebutton=" . $rowdb['data']['me_button'] . "&mechat=" . $rowdb['data']['me_chat'] . "&meevent=" . $rowdb['data']['me_event'] . "&megame=" . $rowdb['data']['me_game'] . "&state=" . $rowdb['data']['state'] . "&megm=" . $rowdb['data']['me_gm'] . "&memsg=" . base64_encode($rowdb['data']['msg_login'] == "" ? "{\"link\":\"\",\"message\":\"\"}" : $rowdb['data']['msg_login']) . "&iframe=true&width=330&height=430"; ?>" rel="prettyPhoto2[iframes]" >Edit Me button</a>
                                            </td>
                                            <td><?php echo trim($i); ?></td>
                                            <td><?php echo $rowdb['data']['id']; ?></td>	
                                            <td><strong style="color:#0b55c4;"><?php echo $rowdb['data']['msv_id']; ?></strong></td>
                                            <td><?php echo $result[0]['app_fullname']; ?></td>
                                            <td><?php echo $rowdb['data']['platform']; ?></td>
                                            <td><?php echo ($result1[0]['datepublish'] == "0000-00-00 00:00:00") || ($result1[0]['datepublish'] == "") ? "" : date_format(date_create($result1[0]['datepublish']), "d/m/Y H:m:s"); ?></td>
                                            <td><?php echo $result1[0]['bunlderid']; ?></td>
                                            <td><?php echo $rowdb['data']['status']; ?></td>
                                            <td id="td_<?php echo $i; ?>"><?php echo trim($result1[0]['published']); ?></td>
                                            <td><?php echo $result1[0]['type_app']; ?></td>
                                            <td><?php echo $rowdb['data']['me_button'] == "on" ? "<strong style='color:#0B41C4'>on</strong>" : "<strong style='color:#C40B3A'>off</strong>"; ?></td>
                                            <td><?php echo $rowdb['data']['me_chat'] == "on" ? "<strong style='color:#0B41C4'>on</strong>" : "<strong style='color:#C40B3A'>off</strong>"; ?></td>
                                            <td><?php echo $rowdb['data']['me_event'] == "on" ? "<strong style='color:#0B41C4'>on</strong>" : "<strong style='color:#C40B3A'>off</strong>"; ?></td>
                                            <td><?php echo $rowdb['data']['me_game'] == "on" ? "<strong style='color:#0B41C4'>on</strong>" : "<strong style='color:#C40B3A'>off</strong>"; ?></td>
                                            <!--<td><?php echo $rowdb['data']['me_login'] == "on" ? "<strong style='color:#0B41C4'>on</strong>" : "<strong style='color:#C40B3A'>off</strong>"; ?></td>-->
                                            <td><?php echo $rowdb['data']['me_gm'] == "on" ? "<strong style='color:#0B41C4'>on</strong>" : "<strong style='color:#C40B3A'>off</strong>"; ?></td>
                                            <td><?php echo $rowdb['data']['state']; ?></td>
                                            <td><?php $js = json_decode($rowdb['data']['msg_login']);
                            echo $js->{'link'} . "<br/>" . $js->{'message'}; ?></td>
                                            <td><?php echo $rowdb['data']['created_date']; ?></td>

                                            <td title="<?php echo $result1[0]['notes']; ?>"><?php echo $result1[0]['notes']; ?></td>

                                            <td><?php echo $slbUser[$result1[0]['users_act']]['username']; ?></td>	
                                            <?php }//end if 
                                        ?>

                                    </tr>

                                <?php
                                }//end for
                            } else {
                                ?>
                                <tr>
                                    <td colspan="9">Không tìm thấy dữ liệu</td>
                                </tr>
    <?php }//end if  ?>
                        </tbody>
                    </table>
                    <?php
                        }
                    ?>
                </div> <!--scroolbar-->
            </div><!-- wrapper_scroolbar -->
        <?php echo $pages ?>
        </form>
<?php } ?>
</div>
<script language="javascript">
    function checknull() {
        _val = $('#cbo_app').val();
        if (_val == 0) {
            alert('Vui lòng chọn Game!');
            $('#cbo_app').focus();
            return false;
        }
<?php echo $lnkFilter; ?>
    }
    function searchnotes(_val) {
        var t = document.getElementById('tbl_viewdata');
        var rows = t.rows;
        for (var i = 0; i < rows.length; i++) {
            var cells = rows[i].cells;
            var f = cells[3].innerHTML;
            var f1 = cells[14].innerHTML;
            $('#rows_' + i).css('display', 'table-row');
            //var regex = /.*/f1/.*/;
            //var matchesRegex = regex.test(_val);
            var myMatch = f1.search(_val);
            var myMatch_msv = f.search(_val);
            if (myMatch != -1) {
                $('#rows_' + i).css('display', 'table-row');
            } else {
                $('#rows_' + i).css('display', 'none');
                if (myMatch_msv != -1) {
                    $('#rows_' + i).css('display', 'table-row');
                } else {
                    $('#rows_' + i).css('display', 'none');
                }
            }
        }
    }
    function setrows(_val) {
        var t = document.getElementById('tbl_viewdata');
        var rows = t.rows;
        for (var i = 0; i < rows.length; i++) {
            var cells = rows[i].cells;
            var f1 = cells[9].innerHTML;
            var id = cells[1].innerHTML;

            $('#rows_' + id).css('display', 'table-row');
            if (f1 != _val) {
                $('#rows_' + id).css('display', 'none');
            }
            if (_val == '0') {
                $('.rows_class').css('display', 'table-row');
            }
        }
    }
    function popitup(url, windowName) {
        var left = (screen.width / 2) - (800 / 2);
        var top = (screen.height / 2) - (250 / 2);
        newwindow = window.open(url, windowName, "toolbar=no, location=no, directories=no, status=no, menubar=no, scrollbars=no, resizable=no, copyhistory=no, width=800, height=250, top=" + top + ",left=" + left + "\"");
        if (window.focus) {
            newwindow.focus()
        }
        return false;
    }

    var config = {
        '.chosen-select': {},
        '.chosen-select-deselect': {allow_single_deselect: true},
        '.chosen-select-no-single': {disable_search_threshold: 10},
        '.chosen-select-no-results': {no_results_text: 'Oops, nothing found!'},
        '.chosen-select-width': {width: "95%"}
    }
    for (var selector in config) {
        $(selector).chosen(config[selector]);
    }
</script>