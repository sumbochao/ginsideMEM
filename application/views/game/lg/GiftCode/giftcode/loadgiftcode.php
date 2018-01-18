<?php
    if(!empty($errors)){
?>
<div style="color:red;text-align: center"><?php echo $errors;?></div>
<?php
    }
?>
<script type="text/javascript">
    $(document).ready(function () {
        $('#create').on('click', function () {
            window.location.href = '/?control=giftcode_lg&func=add&view=<?php echo $_GET['view'];?>&module=<?php echo $_GET['module'];?>&code_type=<?php echo $_GET['code_type']?>&token=<?php echo $token;?>';
        });
    });
</script>
<?php
if(empty($errors)){
    if($listItems['result']=='0'){
?>
<?php
    if(!empty($code_type)){
?>
<div style="margin-top: 10px; margin-bottom: 10px;">
    <button id="create"  class="btn btn-primary"><span>THÊM MỚI</span></button>
</div>
<?php
    }
?>
<table width="100%" border="0" class="table table-striped table-bordered table-condensed table-hover" id="tblsort">
    <thead>
        <tr>
            <th align="center">Username</th>
            <th align="center" width="150px">Code</th>
            <th align="center" width="150px">Giá trị</th>
            <th align="center" width="150px">Tình trạng</th>
            <th align="center" width="150px">Ngày tạo</th>
            <th align="center" width="150px">Loại code</th>
            <th align="center" width="150px">Received</th>
            <th align="center" width="70px">ID</th>
        </tr>
    </thead>
    <tbody>
        <?php
            if(empty($listItems['data']) !== TRUE){
                foreach($listItems['data'] as $i=>$v){
        ?>
        <tr>
            <td><?php echo $v['ause_username'];?></td>
            <td><?php echo $v['gift_code'];?></td>
            <td><?php echo $v['gift_code_value'];?></td>                                        
            <td><?php echo $v['gift_code_staus'];?></td>
            <td><?php echo date_format(date_create($v['gen_date']),"d-m-Y G:i:s");?></td>
            <td><?php echo $v['code_type_id'];?></td>
            <td><?php echo $v['received'];?></td>
            <td><?php echo $v['id'];?></td>
        </tr>
        <?php
                }
            }else{
        ?>
        <tr>
            <td colspan="11" class="emptydata">Dữ liệu không tìm thấy</td>
        </tr>
        <?php
            }
        ?>
    </tbody>
</table>
<?php
    }else{
?>
<div style="color:red;text-align: center">Lấy thông tin thất bại</div>
<?php
    }
}
?>