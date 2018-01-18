<link rel="stylesheet" href="<?php echo base_url('assets/datetime/css/style.css'); ?>"/>
<link rel="stylesheet" href="<?php echo base_url('assets/datetime/css/bootstrap.css'); ?>"/>
<div id="content-t" style="min-height: 500px; padding-top: 10px">
    <style>
        #loading {
            width: 100%;
            height: 100%;
            top: 0px;
            left: 0px;
            position: fixed;
            display: block;
            z-index: 99;
        }

        #loading-image {
            position: absolute;
            top: 40%;
            left: 45%;
            z-index: 100;
        }

        label {
            width: auto !important;
            color: #f36926;
        }
    </style>
    <script type="text/javascript">
        $(document).ready(function () {

            $('#comeback').on('click', function () {
                //window.location.href = '/?control=event_covu_pt&func=giaidau#giaidau';
                window.history.go(-1);
                return false;
            });

            //Load User Details
            load_user_detail(getParameterByName("id"));


            $('#onSubmit').on('click', function () {
                if ($('#frmSendChest').validationEngine('validate') === false)
                    return false;

                data_post = $("#frmSendChest").serializeArray();
                data_post.push({name: 'last_propose', value: '<?php echo $_SESSION['account']['username'] ?>'});

                $.ajax({
                    type: "POST",
                    dataType: 'jsonp',
                    url: "http://mem.net.vn/cms/toolsalarycollaborator/proposeeditsalary",
                    data: data_post,
                    beforeSend: function () {
                        $(".loading").fadeIn("fast");
                    }
                }).done(function (result) {
                    console.log(result);
                    $(".modal-body #messgage").html(result.message);
                    $('.bs-example-modal-sm').modal('show');
                    $(".loading").fadeOut("fast");
                });
            });
        });

        function load_user_detail(id) {
            $.ajax({
                method: "GET",
                url: "http://mem.net.vn/cms/toolsalarycollaborator/get_user_by_id?id=" + id,
                contentType: 'application/json; charset=utf-8',
                success: function (data) {
                    $("#id").val(data["id"]);
                    $("#mobo_id").val(data["mobo_id"]);
                    $("#name").val(data["name"]);

                    obj2 = jQuery.parseJSON(data["game_ids"]);
                    $.each(obj2, function (key2, value2) {
//                        $('input:checkbox[id^="game_ids_"'+value2['id']+']').prop('checked', true);
                        $('#game_ids_' + value2['id']).prop('checked', true);
                    });
                    if (data["status"] == 1) {
                        $('#status_enable').prop('checked', true);
                    } else if (data["status"] == 0) {
                        $('#status_disable').prop('checked', true);
                    } else {
                        $('#status_lock').prop('checked', true);
                    }
                },
                error: function (data) {
                    var obj = $.parseJSON(data);
                }
            });
        }

        function getParameterByName(name) {
            name = name.replace(/[\[]/, "\\[").replace(/[\]]/, "\\]");
            var regex = new RegExp("[\\?&]" + name + "=([^&#]*)"),
                    results = regex.exec(location.search);
            return results == null ? "" : decodeURIComponent(results[1].replace(/\+/g, " "));
        }
    </script>
    <div class="v2-border">
        <div class="box-chitiet-noback">
            <div class="form-action">
                <div class="controls-small" style="float:left; width:200px">
                    <div class="title-label ct-giaodich">
                        Từ ngày
                    </div>
                    <div class="controls-text" style="float:right">
                        <input type="text" id="NgayBatDauText" name="NgayBatDauText" style="width:120px" class="hasDatepicker">
                    </div>
                </div>
                <div class="controls-small" style="float:left; width:200px">
                    <div class="title-label ct-giaodich">
                        Đến ngày
                    </div>
                    <div class="controls-text" style="float:right">
                        <input type="text" id="NgayKetThucText" name="NgayKetThucText" style="width:120px" class="hasDatepicker">
                    </div>
                </div>
                <div style="float:right">
                    <button id="btnxemsaoke" type="submit" class="btn" style="margin-top: 2px; width:105px">
                        Xem sao kê
                    </button>
                </div>
            </div>
            <div id="tableGiaoDich" class="chitiettaikhoan" style="display: block;">
                <br>
                <table cellspacing="0" cellpadding="4" border="0" class="tabledata" style="width:50%;margin: 0 auto">
                    <tbody>
                        <tr class="ct-dauky">
                            <td style="border-right:1px solid white;padding: 5px">
                                Số dư đầu kỳ
                            </td>
                            <td id="sodudauky" style="text-align: right;vertical-align: middle">
                                1,054,511 VND
                            </td>
                        </tr>
                        <tr class="ct-dauky">
                            <td style="border-right:1px solid white;padding: 5px">
                                Số dư cuối kỳ
                            </td>
                            <td style="text-align: right;vertical-align: middle" id="soducuoiky">
                                1,064,938 VND
                            </td>
                        </tr>
                    </tbody>
                </table>
                <div>
                    <button id="btnExportExcel" type="button" class="btn fix-buttom" style="margin-top: 5px;float: right">
                        Xuất ra excel
                    </button>
                </div>
                <br>
                <table cellspacing="0" cellpadding="4" border="0" class="tabledata" style="table-layout: fixed">
                    <tbody id="headerdetails">
                        <tr class="title-table">
                            <th style="width:60px !important">
                                Ngày giao dịch
                            </th>
                            <th style="width:60px !important">
                                Số tham chiếu
                            </th>
                            <th style="width:34px !important">
                                Thay đổi
                            </th>
                            <th style="width:60px !important">
                                Số tiền
                            </th>
                            <th>
                                Mô tả
                            </th>
                        </tr>
                    </tbody>
                    <tbody id="datadetailts" style="display: table-row-group;">
                        <tr style="background-color: #DFF3FB; font-weight: bold; padding: 5px;border-bottom: 1px solid white">
                            <td>
                                04/02/2017
                            </td>
                            <td>
                                ZZZZ - 7094097
                            </td>
                            <td>
                                +
                            </td>
                            <td class="formatnumber">
                                10,427
                            </td>
                            <td class="formattextleft">
                                Tra lai tien gui/Interest paid
                            </td>
                        </tr>
                        <tr>
                            <td style="font-weight: bold;">
                                Tổng
                            </td>
                            <td>
                            </td>
                            <td>
                            </td>
                            <td style="font-weight: bold;" class="formatnumber">
                                10,427
                            </td>
                            <td>
                            </td>
                        </tr>
                    </tbody>
                </table>
                <br>
            </div>
        </div>
    </div>
</div>
