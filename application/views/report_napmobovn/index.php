<script src="<?php echo base_url('assets/datetime/js/jquery-1.11.1.min.js') ?>"></script>
<link rel="stylesheet" href="<?php echo base_url('assets/datetime/css/style.css'); ?>"/>
<link rel="stylesheet" href="<?php echo base_url('assets/datetime/css/bootstrap.css'); ?>"/>

<script src="<?php echo base_url('assets/datetime/js/jquery-ui.min.js') ?>"></script>
<script src="<?php echo base_url('assets/datetime/js/jquery-ui-timepicker-addon.js') ?>"></script>
<link rel="stylesheet" href="<?php echo base_url('assets/datetime/css/jquery-ui.css') ?>"/>
<link rel="stylesheet" href="<?php echo base_url('assets/datetime/css/jquery-ui-timepicker-addon.css') ?>"/>

<style>
    .loadserver .textinput{
        width:205px;
        margin-top:-10px;
    }
    .syntaxhighlighter .toolbar{
        display: none;
    }
    .w_scroolbar_des{
        overflow: scroll;
    }
    .scrool_des{
        height: 100px;
        width: 250px;
    }
    div.coppi_data {
        position: relative;
    }
    .copied::after {
        position: absolute;
        top: 12%;
        right: 110%;
        display: block;
        content: "copied";
        font-size: 13px;
        padding: 5px 5px;
        color: #fff;
        background-color:#f0ad4e;
        border-radius: 3px;
        opacity: 0;
        will-change: opacity, transform;
        animation: showcopied 1.5s ease;
    }
    @keyframes showcopied {
        0% {
            opacity: 0;
            transform: translateX(100%);
        }
        70% {
            opacity: 1;
            transform: translateX(0);
        }
        100% {
            opacity: 0;
        }
    }
    
    .split-column{
        -webkit-column-count: 2; /* Chrome, Safari, Opera */
        -moz-column-count: 2; /* Firefox */
        column-count: 2;
    }
    
    #popUpDiv{
        z-index: 100;
        position: absolute;
        background-color: rgba(25, 19, 19, 0.8);
        display: none;
        top: 0;
        left: 0;
        width: 300px;
        height: 60%;
        color: aliceblue;
        text-align: -webkit-auto;
        font-size: medium;
    }
    #popupSelect{
        z-index: 1000;
        position: absolute;
        top: 130px;
        left: 50px;
    }​
    
</style>


<div class="loading_warning"></div>
<div id="content-t" style="min-height:500px; padding-top:10px">
    <form id="appForm" action="" method="post" name="appForm">
        <div class="filter">

            <span class="loadgame">
                <select name="service_id" id="service_id" onchange="getServerIndex(this.value)">
                    <option value="">Chọn Game</option>
                    <?php foreach ($slbScopes as $k => $v): ?>
                        <option value="<?php echo $v['app_name'] . '-' . $v['service_id']; ?>" <?php echo ($v['service_id'] == $_SESSION['arrayfilter']['service_id']) ? 'selected="selected"' : ''; ?>><?php echo $v['app_fullname']; ?></option>
                    <?php endforeach; ?>
<!--<option value="<?php echo $v['server_id']; ?>" <?php echo ($v['server_id'] == $arrFilter['game_server_id']) ? 'selected="selected"' : ''; ?>><?php echo $v['server_name']; ?></option>-->
                </select>
            </span>
            <span class="loadserver">
                <select name="server_id" class="textinput">
                    <option value="">Chọn server</option>
                    <?php if (empty($slbServer) !== TRUE): ?>
                        <?php foreach ($slbServer as $v): ?>
                            <option value="<?php echo $v['server_id']; ?>" <?php echo ($v['server_id'] == $_SESSION['arrayfilter']['server_id']) ? 'selected="selected"' : ''; ?>><?php echo $v['server_name']; ?></option>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </select>
            </span>
            <input type="text" name="keyword" value="<?php echo $_SESSION['arrayfilter']['keyword']; ?>" class="textinput" placeholder="moboid, mobo service id, transactionid, characterid, character name, serial card" title="moboid, mobo service id, transactionid, characterid, character name, serial card"/>
            <input type="text" name="create_date_from" placeholder="Create Date From" value="<?php echo $_SESSION['arrayfilter']['create_date_from']; ?>"/>
            <input type="text" name="create_date_to" placeholder="Create Date To" value="<?php echo $_SESSION['arrayfilter']['create_date_to']; ?>"/>

            <?php if ((@in_array($_GET['control'] . '-filter_index', $_SESSION['permission']) && $_SESSION['account']['id_group'] == 2) || $_SESSION['account']['id_group'] == 1): ?>
                <input type="button" onclick="onSubmitFormAjax('appForm', '<?php echo base_url() . '?control=report_napmobo&func=index&type=filter'; ?>')" value="Tìm" class="btnB btn-primary"/>
            <?php else: ?>
                <input type="button" onclick='alert("Bạn không có quyền truy cập chức năng này !")' value="Tìm" class="btn btn-primary"/>
            <?php endif; ?>

        </div>
        <input type="button" value="View Columns Config" class="btn btn-primary" id="baseDiv"/>
        <div id="popUpDiv">
            <div class="split-column">
                <span style="white-space: nowrap;"><input type="checkbox" id="select_all" /> Toggle All</span><br/>
                <span style="white-space: nowrap;"><input type="checkbox" name="foo" value="cls-order-id"> Order ID</span><br/>
                <span style="white-space: nowrap;"><input type="checkbox" name="foo" value="cls-mobo-id"> Mobo ID</span><br/>
                <span style="white-space: nowrap;"><input type="checkbox" name="foo" value="cls-mobo-service-id"> Mobo Service ID</span><br/>
                <span style="white-space: nowrap;"><input type="checkbox" name="foo" value="cls-character-id"> Character ID</span><br/>
                <span style="white-space: nowrap;"><input type="checkbox" name="foo" value="cls-character-name"> Character Name</span><br/>
                <span style="white-space: nowrap;"><input type="checkbox" name="foo" value="cls-server-id"> Server ID</span><br/>
                <span style="white-space: nowrap;"><input type="checkbox" name="foo" value="cls-money"> VNĐ</span><br/>
                <span style="white-space: nowrap;"><input type="checkbox" name="foo" value="cls-credit"> Tiền Game</span><br/>
                <span style="white-space: nowrap;"><input type="checkbox" name="foo" value="cls-transaction-id"> TransID</span><br/>
                <span style="white-space: nowrap;"><input type="checkbox" name="foo" value="cls-status-code"> MoMo Status</span><br/>
                <span style="white-space: nowrap;"><input type="checkbox" name="foo" value="cls-response-time">Tg Hoàn Tất</span><br/>
                <span style="white-space: nowrap;"><input type="checkbox" name="foo" value="cls-create-date">Ngày Nạp</span><br/>
                <span style="white-space: nowrap;"><input type="checkbox" name="foo" value="cls-status-date"> Status</span><br/>
                <span style="white-space: nowrap;"><input type="checkbox" name="foo" value="cls-pay-response"> Pay Response</span><br/>
                <span style="white-space: nowrap;"><input type="checkbox" name="foo" value="cls-type"> Type</span><br/>
                <span style="white-space: nowrap;"><input type="checkbox" name="foo" value="cls-telco"> Telco</span><br/>
                <span style="white-space: nowrap;"><input type="checkbox" name="foo" value="cls-serial"> Serial</span><br/>
                <span style="white-space: nowrap;"><input type="checkbox" name="foo" value="cls-unit"> Unit</span><br/>
                <span style="white-space: nowrap;"><input type="checkbox" name="foo" value="cls-event-info"> Event Info</span><br/>
            </div>
            <br/><br/>
            <button type="button" id="applyselect" style="position:absolute; left:40%;">Apply!</button>
        </div>​
        <div class="wrapper_scroolbar">
            <div class="scroolbar">

                <table width="100%" border="0" class="table table-striped table-bordered table-condensed table-hover">
                    <thead>
                        <tr>
                            <th class="cls-order-id" align="center">Order ID</th>
                            <th class="cls-mobo-id" align="center">Mobo ID</th>
                            <th class="cls-mobo-service-id" align="center">Mobo Service ID</th>
                            <th class="cls-character-id" align="center">Character ID</th>
                            <th class="cls-character-name" align="center">Character Name</th>
                            <th class="cls-server-id" align="center">Server ID</th>     
                            <th class="cls-money" align="center">Money</th>     
                            <th class="cls-credit" align="center">Credit</th>
                            <th class="cls-transaction-id" align="center">Transaction ID</th>
                            <th class="cls-status-code" align="center">Status Code</th>
                            <th class="cls-response-time" align="center">Response Time</th>
                            <th class="cls-create-date" align="center">Create Date</th>
                            <th class="cls-status-date" align="center">Status</th>
                            <th class="cls-pay-response" align="center">Pay Response</th>
                            <th class="cls-type" align="center">Type</th>
                            <th class="cls-telco" align="center">Telco</th>
                            <th class="cls-serial" align="center">Serial</th>
                            <th class="cls-unit" align="center">Unit</th>
                            <th class="cls-event-info" align="center">Event Info</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($result as $key => $value): ?>
                            <tr>
                                <td  class="cls-order-id" align="center" class="cls-order-id space_wrap"><?php echo ($value['order_id']) ?></td>
                                <td class="cls-mobo-id" align="center"><?php echo ($value['mobo_id']); ?></td>
                                <td class="cls-mobo-service-id" align="center"><?php echo ($value['mobo_service_id']); ?></td>
                                <td class="cls-character-id" align="center"><?php echo ($value['character_id']); ?></td>
                                <td class="cls-character-name" align="center"><?php echo ($value['character_name']); ?></td>
                                <td class="cls-server-id" align="center"><?php echo ($value['server_id']); ?></td>
                                <td class="cls-money" align="center"><?php echo ($value['money']); ?></td>
                                <td class="cls-credit" align="center"><?php echo ($value['credit']); ?></td>
                                <td class="cls-transaction-id" align="center"><?php echo ($value['transaction_id']); ?></td>
                                <td class="cls-status-code" align="center"><?php echo $value['status_code']; ?></td>
                                <td class="cls-response-time" align="center"><?php echo $value['response_time']; ?></td>
                                <td class="cls-create-date" align="center"><?php echo $value['create_date']; ?></td>

                                <td class="cls-status-date" align="center">
                                    <?php
                                    if ($value['status'] == 0) {
                                        '<span class="success">Khởi tạo</span>';
                                    } elseif ($value['status'] == 1) {
                                        '<span class="success">Thành công</span>';
                                    } else {
                                        echo '<span class="btn-danger">Thất bại</span>';
                                    }
                                    ?>                                    
                                </td>

                                <td class="cls-pay-response" align="center"><?php echo $value['pay_response']; ?></td>
                                <td class="cls-type" align="center"><?php echo $value['type']; ?></td>
                                <td class="cls-telco" align="center"><?php echo $value['telco']; ?></td>
                                <td class="cls-serial" align="center"><?php echo $value['serial']; ?></td>
                                <td class="cls-unit" align="center"><?php echo $value['unit']; ?></td>
                                <td class="cls-event-info" align="center"><?php echo $value['event_info']; ?></td>
                            </tr>
                        <?php endforeach; ?>


                    </tbody>
                </table>
            </div>
        </div>
        <?php echo $pages ?>
    </form>
</div>

<script type="text/javascript">
    $('input[name=create_date_from]').datetimepicker({
        dateFormat: 'yy-mm-dd',
        timeFormat: 'HH:mm:ss'
    });
    $('input[name=create_date_to]').datetimepicker({
        dateFormat: 'yy-mm-dd',
        timeFormat: 'HH:mm:ss',
        /*onSelect: function(date){
         var date2 = $('input[name=date_to]').datetimepicker('getDate');
         date2.setDate(date2.getDate()+1);
         $('input[name=date_to]').datetimepicker('setDate', date2);
         }*/
    });
    create_date_from = '<?php echo $_SESSION['arrayfilter']['create_date_from'] ?>';
    create_date_to = '<?php echo $_SESSION['arrayfilter']['create_date_to'] ?>';
    if (create_date_from == '') {
        $('input[name=create_date_from]').val('');
    }
    if (create_date_to == '') {
        $('input[name=create_date_to]').val('');
    }
    function onSubmitFormAjax(formName, url) {
        service_id = $("#service_id").val();
        if (service_id === '') {
            alert("Vui lòng chọn game!");
            return;
        } else {
//            getServerIndex();
        }
        var theForm = document.getElementById(formName);
        theForm.action = url;
        theForm.submit();
        return true;
    }
    function getServerIndex(game) {
        var url = baseUrl + '?control=report_napmobo&func=getserver';
        jQuery.ajax({
            url: url,
            type: "POST",
            data: {game: game},
            async: false,
            dataType: "json",
            success: function (f) {
                if (f.status == 0) {
                    jQuery('.loadserver').html(f.html);
                } else {
                    jQuery('.loadserver').html(f.html);
                }
            }
        });
    }

    $(document).ready(function () {
        $("#baseDiv").click(function (e) {
            e.stopPropagation();
            $("#popUpDiv").show();
            
        });
        $("#applyselect").click(function (e) {
            $("input[name='foo']").each(function () {
                if (this.checked) {
                    $("." + $(this).val()).show();
                } else {
                    $("." + $(this).val()).hide();
                }
            });
            $("#popUpDiv").hide();
        });
    });

    $('body').click(function(e) {
        if (!$(e.target).closest('#popUpDiv', '#baseDiv').length){
            if($('#popUpDiv').is(":visible")) {
                $('#popUpDiv').hide();
            }
        }
        e.stopPropagation();
    });
    

    
//    function toggle(source) {
//        checkboxes = document.getElementsByName('foo');
//        for each(var checkbox in checkboxes)
//        checkbox.checked = source.checked;
//    }
//    $('#select_all').on('change', function(){
//        var select_all = this;
//        $('[name="foo"]').each(function () {
//            console.log(select_all.checked);
//            this.prop('checked',select_all.checked);
//        });
//    });

    $(function () {
        $("#select_all").click(function () {
            if ($("#select_all").is(':checked')) {
                $('[name="foo"]').prop("checked", true);
            } else {
                $('[name="foo"]').prop("checked", false);
            }
        });
    });
</script>
