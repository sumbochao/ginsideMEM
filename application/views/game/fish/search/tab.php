<style>
    .nav > li > a{
        padding: 5px;
    }
</style>
<h4><?php echo $title;?></h4>
<script>
    $(function () {
        $('#accountwallet').on('click', function (e) {
            window.location.href = "/?control=vicambo&func=accountwallet&module=all";
        });
        $('#cashin').on('click', function (e) {
            window.location.href = "/?control=vicambo&func=cashin&module=all";
        });
        $('#cashout').on('click', function (e) {
            window.location.href = "/?control=vicambo&func=cashout&module=all";
        });
    });
</script>
<ul role="tablist" class="nav nav-tabs">
    <li role="presentation" <?php echo $_GET['func']=='accountwallet'?'class="active"':''; ?>><a id="accountwallet" href="#accountwallet" aria-controls="accountwallet" role="tab" data-toggle="tab">TRA CỨU SỐ DƯ NGỌC</a></li>
    <li role="presentation" <?php echo $_GET['func']=='cashin'?'class="active"':''; ?>><a id="cashin" href="#cashin" aria-controls="cashin" role="tab" data-toggle="tab">TRA CỨU NẠP NGỌC</a></li>
    <li role="presentation" <?php echo $_GET['func']=='cashout'?'class="active"':''; ?>><a id="cashout" href="#cashout" aria-controls="cashout" role="tab" data-toggle="tab">TRA CỨU CHUYỂN NGỌC</a></li>
</ul>