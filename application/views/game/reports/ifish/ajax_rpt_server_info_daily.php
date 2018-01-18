<table width="100%" border="0" id="table2excel" class="table table-striped table-bordered table-condensed table-hover">
    <thead>
        <tr>
            <th align="center" width="50px">STT</th>
            <th align="center" width="50px">Ngày</th>
            <th align="center" width="230px">Số lượng user nạp tiền trong ngày (PayUser)</th>
            <th align="center" width="200px">Lượng ngọc phát sinh (ở ví tiền) trong ngày (GemlnDay)</th>
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
            <td><?php echo $v["PayUser"]>0?number_format($v['PayUser']):0; ?></td>
            <td><?php echo $v["GemlnDay"]>0?number_format($v['GemlnDay']):0; ?></td>
        </tr>
        <?php
                }
            }else{
        ?>
        <tr>
            <td colspan="5" style="color:red;text-align: center;">Dữ liệu không tìm thấy</td>
        </tr>  
        <?php
            }
        ?>
    </tbody>
</table>