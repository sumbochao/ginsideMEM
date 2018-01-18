<link rel="stylesheet" href="<?php echo base_url('assets/datetime/css/style.css'); ?>"/>
<link rel="stylesheet" href="<?php echo base_url('assets/datetime/css/bootstrap.css'); ?>"/>
<!--<script src="<?php echo base_url('assets/js/chosen.jquery.js'); ?>" type="text/javascript"></script>
<link rel="stylesheet" href="<?php echo base_url('assets/css/chosen.css'); ?>">-->
<link rel="stylesheet" href="<?php echo base_url('assets/css/lightbox.css'); ?>"/>
<script src="<?php echo base_url('assets/js/lightbox.js'); ?>"></script>

<script type="text/javascript">
    function loadPage(area, url) {
        $(area).load(url);
    }
</script>
<style>
    .success_signios{
        color: green;
        text-align: center;
        font-size: 20px;
    }
    .unsuccess_signios{
        color: red;
        text-align: center;
        font-size: 20px;
    }
    .main-bar{
        display:none;
    }
</style>
<!--<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js" type="text/javascript" type="text/javascript"></script>
<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/prettyPhotos/prettyPhoto.css'); ?>" media="screen" title="prettyPhoto main stylesheet" charset="utf-8" />
<script type="text/javascript" src="<?php echo base_url('assets/css/prettyPhotos/jquery.prettyPhoto.js'); ?>"></script>
<script type="text/javascript" charset="utf-8">
                         $(document).ready(function(){
                $("a[rel^='prettyPhoto']").prettyPhoto({
                        allow_resize: false
                    });                
            });
$("a[rel^='prettyPhoto3']").prettyPhoto({animationSpeed:'fast',slideshow:10000});
$("a[rel^='prettyPhoto2']").prettyPhoto({animationSpeed:'fast',slideshow:10000});
</script>-->
<div class="loading_warning"></div>
<div id="content-t" style="min-height:500px; padding-top:10px">
    <?php 
    if (!isset($_GET['type']) || $_GET['type'] == "filter") {
        ?>
        <form id="appForm" action="" method="post" name="appForm" enctype="multipart/form-data">
            <?php include_once 'include/toolbar.php'; ?>
            <div class="filter">
                <select name="game_id" id="game_id" class="chosen-select" tabindex="2" data-placeholder="Chọn game">
                    <option value="">Chọn game</option>
                    <?php
                    if (count($slbGame) > 0) {
                        foreach ($slbGame as $v) {
                            ?>
                            <option value="<?php echo $v['service_id']; ?>" <?php echo $_POST['game_id'] == $v['service_id'] ? 'selected="selected"' : ''; ?>><?php echo $v['app_fullname']; ?></option>
                            <?php
                        }
                    }
                    ?>
                </select>
                <input type="text" name="values_query" value="<?php echo isset($_POST['values_query'])?$_POST['values_query']:'';?>"/>
                <input type="submit" name="btn_search" id="btn_search" value="Tìm" class="btnB btn-primary"/>
                <input type="button" name="btn_history" id="btn_history" value="History" class="btnB btn-primary" onclick="showhistory();" style="margin-bottom:0;" /> 			
            </div>

            <div class="wrapper_scroolbar" style="height:400px;">
                <div class="scroolbar" style="width:1500px;">
                    <div style="float:left;margin-bottom:10px;" id="divpage">
                        <?php echo $pages ?>
                    </div>
                    <table width="100%" border="0" class="table table-striped table-bordered table-condensed table-hover" id="tblsort">
                        <thead>
                            <tr>
                                <!--<th align="center" width="50px"><input type="checkbox" name="checkbox" onclick="checkedAll();"/></th>-->
                                <th></th>
                                <th align="center" width="80px">Game</th>
                                <th align="center" width="150px">Gói quà</th>
                                <th align="center" width="150px">Avatar</th>
                                <th align="center" width="150px">Số lượng</th>
                                <th align="center" width="150px">Ngày bán</th>
                                <th align="center" width="150px">Ngày hết hạn</th>
                                <th align="center" width="150px">Số lần mua</th>
                                <th align="center" width="150px">Hình thức mua</th>
                                <th align="center" width="150px">Shop</th>
                                <th align="center" width="150px">Tình trạng</th>
                                <th align="center" width="150px">Ngày tạo</th>
                                <th align="center" width="150px">User</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $i = 0;
                            if (empty($listItems) !== TRUE) {
                                foreach ($listItems as $i => $v) {
                                    ?>
                                    <tr id="rows_<?php echo $i ?>" class="rows_class">
                                        <td>
                                            <?php
                                            if ((@in_array($_GET['control'] . '-delete', $_SESSION['permission']) && $_SESSION['account']['id_group'] == 2) || $_SESSION['account']['id_group'] == 1) {
                                                ?>
                                                <a onclick="deleletitems(<?php echo $v['id']; ?>);" href='javascript:void(0);' title="Xóa"><img border="0" title="Xóa" src="<?php echo base_url(); ?>assets/img/icon_del.png"></a>
                                            <?php } ?>
                                        </td>
                    <!--<td><input type="checkbox" value="<?php echo $v['id']; ?>" id="cid[<?php echo $v['id']; ?>]" name="cid[]"></td>-->

                                        <td style="text-align:left" title="<?php echo $slbGame[$v['game_id']]['app_fullname']; ?>"><?php echo $slbGame[$v['game_id']]['app_fullname']; ?></td>
                                        <td><strong style="color:#036" >
                                                <a href="<?php echo base_url() ?>?control=listpack&func=edit&id=<?php echo $v['id']; ?>"><?php echo $v['titles_pack']; ?></a>
                                            </strong></td>
                                        <td><img src="<?php echo $v['img_pack']; ?>" width="50px" height="50px"  /></td>
                                        <td><?php echo $v['num_pack']; ?></td>
                                        <td><?php echo $v['start_date_pack']; ?></td>
                                        <td><?php echo $v['expired_date_pack']; ?></td>
                                        <td><?php echo $v['limit_buy_day']; ?></td>
                                        <td><?php echo $v['values_query']; ?></td>
                                        <td><?php echo $v['cost_pack']; ?></td>
                                        <td><i style="color:#B017D2">
                                                <?php
                                                switch ($v['status_publish']) {
                                                    case 0: echo "Chưa duyệt";
                                                        break;
                                                    case 1: echo "Đã duyệt";
                                                        break;
                                                    case 2: echo "Public";
                                                        break;
                                                }
                                                ?>
                                            </i></td>
                                        <td><?php echo $v['datecreate']; ?></td>
                                        <td><?php echo $slbUser[$v['user_log']]['username']; ?></td>
                                    </tr>
                                    <?php
                                }
                            } else {
                                ?>
                                <tr>
                                    <td colspan="11" class="emptydata">Dữ liệu không tìm thấy</td>
                                </tr>
        <?php
    }
    ?>
                        </tbody>
                    </table>
    <?php echo $pages ?>
                </div> <!--scroolbar-->
            </div><!-- wrapper_scroolbar -->

        </form>
<?php } ?>
</div>
<script language="javascript">
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

    function checkdelall() {
        var myForm = document.forms.appForm;
        var myControls = myForm.elements['cid[]'];
        var isok = false;
        for (var i = 0; i < myControls.length; i++) {
            var aControl = myControls[i];
            if (aControl.checked) {
                isok = true;
            }
        }
        if (!isok) {
            alert('Vui lòng chọn dòng cần xóa');
            return false;
        } else {
            c = confirm('Bạn có muốn xóa !');
            if (c) {
                onSubmitForm('appForm', '<?php echo base_url() . "?control=" . $_GET['control'] . "&func=delete&type=multi"; ?>');
                return true;
            }
        }
    }
    function deleletitems(id) {
        c = confirm('Bạn có muốn xóa !');
        if (c) {
            onSubmitForm('appForm', '<?php echo base_url() . "?control=" . $_GET['control'] . "&func=delete&id="; ?>' + id);
            return true;
        }
    }

    function showhistory() {
        var g = $('#game_id').val();
        if (g == 0) {
            alert('Vui lòng chọn game');
        } else {
            onSubmitForm('appForm', '<?php echo base_url() . "?control=" . $_GET['control'] . "&func=history&game_id="; ?>' + g);
        }
    }
</script>