<link rel="stylesheet" href="<?php echo base_url('assets/datetime/css/style.css'); ?>"/>
<table width="100%" border="0" class="table table-striped table-bordered table-condensed table-hover">
    <thead>
        <tr>
            <th align="center">Sự kiện</th>
            <th align="center">Còn lại</th>
			<th align="center">Tổng</th>
            <th align="center">Ghi chú</th>
        </tr>
    </thead>
    <tbody>
        <?php
            if(empty($listEvent) !== TRUE){
                foreach($listEvent as $v){
        ?>
        <tr>
            <td align="left"><?php echo $v['event'];?></td>
            <td align="left"><?php echo ($v['count']>0)?number_format($v['count'],0,',','.'):0;?></td>
			<td align="left"><?php echo $v['totalcount'];?></td>
            <td align="left"><?php echo $v['note'];?></td>
        </tr>
        <?php
                }
            }else{
        ?>
        <tr>
            <td colspan="4" class="emptydata">Dữ liệu không tìm thấy</td>
        </tr>
        <?php
            }
        ?>
    </tbody>
</table>