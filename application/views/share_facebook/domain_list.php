<link rel="stylesheet" href="<?php echo base_url('assets/datetime/css/style.css'); ?>"/>
<link rel="stylesheet" href="<?php echo base_url('assets/datetime/css/bootstrap.css'); ?>"/>
<div id="content-t" style="min-height:500px; padding-top:10px">
    <form id="appForm" action="" method="post" name="appForm">
        <?php //include_once 'include/toolbar.php'; ?>
        <div class="filter">  
            <a href="?control=sharefacebook&func=domain_edit" class="btnB btn-primary">Thêm</a><br><br>
        </div>

        <table width="100%" border="0" class="table table-striped table-bordered table-condensed table-hover " id="tblsort">
            <thead>
                <tr>
                    <th align="center" width="50px">ID</th>
                    <th align="center">Game</th>
                    <th align="center" width="100px">Domain</th>
                    <th align="center" width="100px"></th>
                </tr>
            </thead>
            <tbody>

                <?php
                //var_dump($data);

                if (!empty($data)) {
                    foreach ($data as $value) {
                        ?>
                        <tr>
                            <td align="left"><?php echo $value["id"] ?></td>
                            <td align="left" style="text-align: left"><?php echo $value["game"] ?></td>
                            <td align="left"><?php echo $value["domain"] ?></td>
                            <td>
                                <a href="<?php echo base_url() ?>?control=<?php echo $_GET['control'] ?>&func=domain_edit&id=<?php echo $value["id"] ?>" title="Sửa">
                                    <img border="0" title="Sửa" src="/assets/img/icon_edit.png"> 
                                </a>
                                <a onclick="if (!window.confirm('Bạn có muốn xóa này không ?'))
                                                    return false;" 
                                   href="<?php echo base_url() ?>?control=<?php echo $_GET['control'] ?>&func=domain_delete&id=<?php echo $value["id"] ?>" title="Xóa">
                                    <img border="0" title="Xóa" src="/assets/img/icon_del.png"> 
                                </a>
                            </td>
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


        <style>
            #tblsort td{
                font-size: 12px;
            }
            .pagination>a, .pagination>li>span {
                position: relative;
                float: left;
                padding: 6px 12px;
                margin-left: -1px;
                line-height: 1.428571429;
                text-decoration: none;
                background-color: #fff;
                border: 1px solid #ddd;
            }
            .pagination>.paginate_active, .pagination>.active>span, .pagination>.active>a:hover, .pagination>.active>span:hover, .pagination>.active>a:focus, .pagination>.active>span:focus {
                z-index: 2;
                color: #fff;
                cursor: default;
                background-color: #428bca;
                border-color: #428bca;
            }
        </style>
        <div class="pagination">
            <?php echo $paging ?>
        </div>

    </form>
</div>
<script type="text/javascript">
    (new TableDnD).init("tblsort");
</script>