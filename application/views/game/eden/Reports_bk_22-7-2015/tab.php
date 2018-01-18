<script>
    $(function () {        
        $('#user_active_by_server').on('click', function (e) {
            window.location.href = "/?control=eden_reports&func=user_active_byserver#user_active_by_server";
        });

        $('#user_active_by_date').on('click', function (e) {
            window.location.href = "/?control=eden_reports&func=user_active_bydate#user_active_by_date";
        });
        $('#level_active_by_server').on('click', function (e) {
            window.location.href = "/?control=eden_reports&func=level_active_byserver#level_active_by_server";
        });
        $('#level_active_by_date').on('click', function (e) {
            window.location.href = "/?control=eden_reports&func=level_active_bydate#level_active_by_date";
        });
        $('#level_statistics_by_date').on('click', function (e) {
            window.location.href = "/?control=eden_reports&func=level_statistics_bydate#level_statistics_by_date";
        });
    });
</script>
<ul role="tablist" class="nav nav-tabs">
    <?php
        if((@in_array($_GET['control'].'-user_active_byserver', $_SESSION['permission']) && $_SESSION['account']['id_group']==2)|| $_SESSION['account']['id_group']==1){
    ?>
    <li class="<?php echo ($_GET['func']=='user_active_byserver')?'active':'';?>" role="presentation"><a data-toggle="tab" role="tab" aria-controls="user_active_by_server" href="#user_active_by_server" id="user_active_by_server">User Active By Server</a></li>
    <?php } ?>
    <?php
        if((@in_array($_GET['control'].'-user_active_bydate', $_SESSION['permission']) && $_SESSION['account']['id_group']==2)|| $_SESSION['account']['id_group']==1){
    ?>
    <li class="<?php echo ($_GET['func']=='user_active_bydate')?'active':'';?>" role="presentation"><a data-toggle="tab" role="tab" aria-controls="user_active_by_date" href="#user_active_by_date" id="user_active_by_date">User Active By Date</a></li>
    <?php } ?>
    <?php
        if((@in_array($_GET['control'].'-user_active_bydate', $_SESSION['permission']) && $_SESSION['account']['id_group']==2)|| $_SESSION['account']['id_group']==1){
    ?>
    <li class="<?php echo ($_GET['func']=='level_active_byserver')?'active':'';?>" role="presentation"><a data-toggle="tab" role="tab" aria-controls="level_active_by_server" href="#level_active_by_server" id="level_active_by_server">Level Active By Server</a></li>
    <?php } ?>
    <?php
        if((@in_array($_GET['control'].'-user_active_bydate', $_SESSION['permission']) && $_SESSION['account']['id_group']==2)|| $_SESSION['account']['id_group']==1){
    ?>
    <li class="<?php echo ($_GET['func']=='level_active_bydate')?'active':'';?>" role="presentation"><a data-toggle="tab" role="tab" aria-controls="level_active_by_date" href="#level_active_by_date" id="level_active_by_date">Level Active By Date</a></li>
    <?php } ?>
    <?php
        if((@in_array($_GET['control'].'-user_active_bydate', $_SESSION['permission']) && $_SESSION['account']['id_group']==2)|| $_SESSION['account']['id_group']==1){
    ?>
    <li class="<?php echo ($_GET['func']=='level_statistics_bydate')?'active':'';?>" role="presentation"><a data-toggle="tab" role="tab" aria-controls="level_statistics_by_date" href="#level_statistics_by_date" id="level_statistics_by_date">Level Statistics By Date</a></li>
    <?php } ?>
</ul>