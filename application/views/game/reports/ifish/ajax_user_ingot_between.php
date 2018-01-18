<table width="100%" border="0" id="table2excel" class="table table-striped table-bordered table-condensed table-hover">
    <thead>
        <tr>
            <th align="center" width="50px">STT</th>
            <th align="center" width="50px">Ngày</th>
            <th align="center" width="130px">Số lượng User mới nhận được sò</th>
            <th align="center" width="100px">Số lượng User đang có sò</th>
            <th align="center" width="110px">Tổng lượng sò phát sinh trong ngày</th>
			<th align="center" width="110px">Tổng sò</th>
			<th align="center" width="110px">Tổng ngọc</th>
			<th align="center" width="110px">Tổng vàng</th>
			<th align="center" width="110px">Tổng đóng góp</th>
        </tr>
    </thead>
    <tbody>
        <?php
            if(count($listItems)>0){
                $i=0;
                foreach($listItems as $key=>$v){
                    $i++;
        ?>
        <tr>
            <td><?php echo $i;?></td>
            <td><?php  echo date_format(date_create($v['Date']),"d-m-Y");?></td>
            <td><?php echo $v["NewUserIngot"]>0?number_format($v['NewUserIngot']):"";?></td>
            <td><?php echo $v["UserIngot"]>0?number_format($v['UserIngot']):""?></td>
            <td><?php echo $v["TotalNewIngot"]>0?number_format($v['TotalNewIngot']):""?></td>
			<td><?php echo $v["TotalCurrIngot"]>0?number_format($v['TotalCurrIngot']):"0"?></td>
			<td><?php echo $v["TotalCurrSilver"]>0?number_format($v['TotalCurrSilver']):"0"?></td>
			<td><?php echo $v["TotalCurrScore"]>0?number_format($v['TotalCurrScore']):"0"?></td>
			<td><?php echo $v["TotalCurrIngotContribution"]>0?number_format($v['TotalCurrIngotContribution']):"0"?></td>
        </tr>
        <?php
                }
            }else{
        ?>
        <tr>
            <td colspan="8" style="color:red;text-align: center;">Dữ liệu không tìm thấy</td>
        </tr> 
        <?php
            }
        ?>
    </tbody>
</table>