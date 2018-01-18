<script>
    $(function () {        
        $('#user_active_by_server').on('click', function (e) {
            window.location.href = "/?control=reports&func=user_active_byserver&module=all&game=<?php echo $_GET['game'];?>#user_active_by_server";
        });
		$('#user_active_by_date').on('click', function (e) {
            window.location.href = "/?control=reports&func=user_active_bydate&module=all&game=<?php echo $_GET['game'];?>#user_active_by_date";
        });
		$('#role_active_by_server').on('click', function (e) {
            window.location.href = "/?control=reports&func=role_active_byserver&module=all&game=<?php echo $_GET['game'];?>#role_active_by_server";
        });
        $('#role_active_by_date').on('click', function (e) {
            window.location.href = "/?control=reports&func=role_active_bydate&module=all&game=<?php echo $_GET['game'];?>#role_active_by_date";
        });
        $('#money_bydate').on('click', function (e) {
            window.location.href = "/?control=reports&func=money_bydate&module=all&game=<?php echo $_GET['game'];?>#money_bydate";
        });
        $('#money_byserver').on('click', function (e) {
            window.location.href = "/?control=reports&func=money_byserver&module=all&game=<?php echo $_GET['game'];?>#money_byserver";
        });
        $('#bluegem_statistics_bydate').on('click', function (e) {
            window.location.href = "/?control=reports&func=bluegem_statistics_bydate&module=all&game=<?php echo $_GET['game'];?>#bluegem_statistics_bydate";
        });
        $('#bluegem_statistics_byserver').on('click', function (e) {
            window.location.href = "/?control=reports&func=bluegem_statistics_byserver&module=all&game=<?php echo $_GET['game'];?>#bluegem_statistics_byserver";
        });
        $('#money_statistics_activeuser_all').on('click', function (e) {
            window.location.href = "/?control=reports&func=money_statistics_activeuser_all&module=all&game=<?php echo $_GET['game'];?>#money_statistics_activeuser_all";
        });
        $('#money_statistics_activeuser_details').on('click', function (e) {
            window.location.href = "/?control=reports&func=money_statistics_activeuser_details&module=all&game=<?php echo $_GET['game'];?>#money_statistics_activeuser_details";
        });
    });
</script>
<ul role="tablist" class="nav nav-tabs">
    <li class="<?php echo ($_GET['func']=='user_active_byserver')?'active':'';?>" role="presentation"><a data-toggle="tab" role="tab" aria-controls="user_active_by_server" href="#user_active_by_server" id="user_active_by_server">TK kích hoạt theo server</a></li>
    <li class="<?php echo ($_GET['func']=='user_active_bydate')?'active':'';?>" role="presentation"><a data-toggle="tab" role="tab" aria-controls="user_active_by_date" href="#user_active_by_date" id="user_active_by_date">TK kích hoạt theo ngày</a></li>
    <li class="<?php echo ($_GET['func']=='role_active_byserver')?'active':'';?>" role="presentation"><a data-toggle="tab" role="tab" aria-controls="role_active_by_server" href="#role_active_by_server" id="role_active_by_server">Role kích hoạt theo server</a></li>
    <li class="<?php echo ($_GET['func']=='role_active_bydate')?'active':'';?>" role="presentation"><a data-toggle="tab" role="tab" aria-controls="role_active_by_date" href="#role_active_by_date" id="role_active_by_date">Role kích hoạt theo ngày</a></li>
    <li class="<?php echo ($_GET['func']=='money_bydate')?'active':'';?>" role="presentation"><a data-toggle="tab" role="tab" aria-controls="money_bydate" href="#money_bydate" id="money_bydate">Thống Kê Tiền theo ngày</a></li>
    <li class="<?php echo ($_GET['func']=='money_byserver')?'active':'';?>" role="presentation"><a data-toggle="tab" role="tab" aria-controls="money_byserver" href="#money_byserver" id="money_byserver">Thống Kê Tiền theo server</a></li>
    <li class="<?php echo ($_GET['func']=='bluegem_statistics_bydate')?'active':'';?>" role="presentation"><a data-toggle="tab" role="tab" aria-controls="bluegem_statistics_bydate" href="#bluegem_statistics_bydate" id="bluegem_statistics_bydate">Thống Kê Lam Ngọc theo ngày</a></li>
    <li class="<?php echo ($_GET['func']=='bluegem_statistics_byserver')?'active':'';?>" role="presentation"><a data-toggle="tab" role="tab" aria-controls="bluegem_statistics_byserver" href="#bluegem_statistics_byserver" id="bluegem_statistics_byserver">Thống Kê Lam Ngọc theo server</a></li>
    <li class="<?php echo ($_GET['func']=='money_statistics_activeuser_all')?'active':'';?>" role="presentation"><a data-toggle="tab" role="tab" aria-controls="money_statistics_activeuser_all" href="#money_statistics_activeuser_all" id="money_statistics_activeuser_all">MoneyDAU_ByServer</a></li>
    <li class="<?php echo ($_GET['func']=='money_statistics_activeuser_details')?'active':'';?>" role="presentation"><a data-toggle="tab" role="tab" aria-controls="money_statistics_activeuser_details" href="#money_statistics_activeuser_details" id="money_statistics_activeuser_details">MoneyDAU_ByUser</a></li>
</ul>