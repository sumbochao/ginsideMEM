<style>
    .nav > li > a{
        padding: 5px;
    }
</style>
<script>
    $(function () {
        $('#user_realtime').on('click', function (e) {
            window.location.href = "/?control=reports&func=user_realtime&module=all&game=<?php echo $_GET['game'];?>";
        });
        $('#user_ingot_between').on('click', function (e) {
            window.location.href = "/?control=reports&func=user_ingot_between&module=all&game=<?php echo $_GET['game'];?>";
        });
        $('#user_ingot').on('click', function (e) {
            window.location.href = "/?control=reports&func=user_ingot&module=all&game=<?php echo $_GET['game'];?>";
        });
		$('#rpt_account_info').on('click', function (e) {
            window.location.href = "/?control=reports&func=rpt_account_info&module=all&game=<?php echo $_GET['game'];?>";
        });
		$('#info_daily_realtime').on('click', function (e) {
            window.location.href = "/?control=reports&func=info_daily_realtime&module=all&game=<?php echo $_GET['game'];?>";
        });
		$('#rpt_server_info_daily').on('click', function (e) {
            window.location.href = "/?control=reports&func=rpt_server_info_daily&module=all&game=<?php echo $_GET['game'];?>";
        });
    });
</script>
<ul role="tablist" class="nav nav-tabs">
    <li role="presentation" <?php echo $_GET['func']=='user_realtime'?'class="active"':''; ?>><a id="user_realtime" href="#user_realtime" aria-controls="user_realtime" role="tab" data-toggle="tab">USER NHẬN THEO NGÀY</a></li>
    <li role="presentation" <?php echo $_GET['func']=='user_ingot_between'?'class="active"':''; ?>><a id="user_ingot_between" href="#user_ingot_between" aria-controls="user_ingot_between" role="tab" data-toggle="tab">TỔNG HỢP USER NGÀY</a></li>
    <li role="presentation" <?php echo $_GET['func']=='user_ingot'?'class="active"':''; ?>><a id="user_ingot" href="#user_ingot" aria-controls="user_ingot" role="tab" data-toggle="tab">TỔNG HỢP USER</a></li>
	<li role="presentation" <?php echo $_GET['func']=='rpt_account_info'?'class="active"':''; ?>><a id="rpt_account_info" href="#rpt_account_info" aria-controls="rpt_account_info" role="tab" data-toggle="tab">VÍ TIỀN USER</a></li>
	<li role="presentation" <?php echo $_GET['func']=='info_daily_realtime'?'class="active"':''; ?>><a id="info_daily_realtime" href="#info_daily_realtime" aria-controls="info_daily_realtime" role="tab" data-toggle="tab">LƯỢNG NẠP TRONG NGÀY</a></li>
	<li role="presentation" <?php echo $_GET['func']=='rpt_server_info_daily'?'class="active"':''; ?>><a id="rpt_server_info_daily" href="#rpt_server_info_daily" aria-controls="rpt_server_info_daily" role="tab" data-toggle="tab">LƯỢNG NẠP KHOẢNG NGÀY</a></li>
</ul>