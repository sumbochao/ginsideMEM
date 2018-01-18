<link rel="stylesheet" href="<?php echo base_url('assets/datetime/css/style.css'); ?>"/>
<link rel="stylesheet" href="<?php echo base_url('assets/datetime/css/bootstrap.css'); ?>"/>
<div id="content-t" style="min-height:500px; padding-top:10px">
    <form id="appForm" action="" method="post" name="appForm">
        <?php //include_once 'include/toolbar.php'; ?>

        <script>
            $(document).ready(function() {
                $("#select_domain").change(function() {
                    var id = $("#select_domain").val();
                    
                    if (id != null) {
                        window.location.href = "http://ginside.mobo.vn/?control=configappfacebook&func=index&id=" + id+"&module=all";
                    }
                });
                
//                var id = getParameterByName('id');
//                $("#select_domain").val(id);
                
                function getParameterByName(name) {
                    name = name.replace(/[\[]/, "\\[").replace(/[\]]/, "\\]");
                    var regex = new RegExp("[\\?&]" + name + "=([^&#]*)"),
                            results = regex.exec(location.search);
                    return results === null ? "" : decodeURIComponent(results[1].replace(/\+/g, " "));
                }
                
                //?control=configappfacebook&func=edit
                //function
                $(".btnadd").click(function() {
                    var game = $("#select_domain").val();
                    
                    if (game != "0") {
                        window.location.href = "?control=configappfacebook&func=edit&domain=" + game+"&module=all";
                    }
                    else{
                        alert("Vui lòng chọn game");
                    }
                });
            });
        </script>

        <div class="filter">  
            <select id="select_domain">
                <option value="0" selected>Chọn game</option>
                <?php
                if (count($domain_list) > 0) {
                    $selected = "";

                    foreach ($domain_list as $value) {
						if((@in_array($value['alias'], $_SESSION['permission']) && $_SESSION['account']['id_group']==2)
							|| $_SESSION['account']['id_group']==1){
							if ($_GET["id"] == $value["id"]) {
								?>
								<option value="<?php echo $value["id"] ?>" selected="">
									<?php echo $value["game"] ?>
								</option>
								<?php
							} else {
								?>
								<option value="<?php echo $value["id"] ?>">
									<?php echo $value["game"] ?>
								</option>
								<?php
							}						
						}
                        
                    }
                }
                ?>
            </select>
            <a class="btnB btn-primary btnadd">Thêm</a><br><br>
        </div>

        <table width="100%" border="0" class="table table-striped table-bordered table-condensed table-hover " id="tblsort">
            <thead>
                <tr>
                    <th align="center" width="50px">ID</th>
                    <th align="center">Tên</th>
                    <th align="center" width="100px">ClientID</th>
                    <th align="center" width="100px">InsertDate</th>
                    <th align="center" width="100px">Status</th>
					<th align="center" width="100px">Server</th>
                    <th align="center" width="100px"></th>
                </tr>
            </thead>
            <tbody>
                <?php
//                    if(empty($data) !== TRUE){
//                        foreach($listItems as $i=>$v){
//                            if($v['level'] == 1){
//                                $name = '<div> <strong>+ ' . $v['name'] . '</strong></div>';
//                            }else{
//                                $x = 25 * ($v['level']-1);
//                                $css = 'padding-left: ' . $x . 'px;';
//                                $name = '<div style="' . $css . '">- ' . $v['name'] . '</div>';
//                            }
                ?>

                <?php
                //var_dump($data);

                if (!empty($data)) {
                    foreach ($data as $value) {
                        ?>
                        <tr>
                            <td align="left"><?php echo $value["id"] ?></td>
                            <td align="left"><?php echo $value["name"] ?></td>
                            <td align="left"><?php echo $value["client_id"] ?></td>
                            <td align="left">
                                <?php echo date('Y-m-d H:i:s',strtotime($value["create_date"])); ?>
                            </td>
                            <td align="left"><?php echo $value["status"] ?></td>
							 <td align="left"><?php echo $value["server_id"] ?></td>
                            <td>
                                <a href="<?php echo base_url() ?>?control=<?php echo $_GET['control'] ?>&func=edit&id=<?php echo $value["id"] ?>&domain=<?php echo $_GET["id"] ?>&module=all" title="Sửa">
                                    <img border="0" title="Sửa" src="/assets/img/icon_edit.png"> 
                                </a>
                                <a onclick="if (!window.confirm('Bạn có muốn xóa này không ?'))
                                                    return false;" 
                                   href="<?php echo base_url() ?>?control=<?php echo $_GET['control'] ?>&func=delete&id=<?php echo $value["id"] ?>&per_page=<?php echo $_GET['per_page'] ?>&domain=<?php echo $_GET["id"] ?>" title="Xóa">
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