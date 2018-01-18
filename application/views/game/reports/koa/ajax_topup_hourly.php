<table width="100%" id="table2excel" border="0" class="table table-striped table-bordered table-condensed table-hover">
    <thead>
        <tr>
            <th align="center" width="100px">Date</th>
            <th align="center" width="100px">Mcoin</th>
            <th align="center" width="100px">Tiền VNĐ (Value)</th>
            <th align="center" width="100px">Số lần nạp (Times)</th>
            <th align="center" width="100px">Số lượng user nạp (Quantities)</th>
        </tr>
    </thead>
    <tbody>
        <?php
            if(count($listItems)>0){
                foreach($listItems as $v){
        ?>
        <tr>
            <td>
                <?php 
                    $date = new DateTime($v['date']);
                    echo $date->format('d-m-Y H:i:s');
                ?>
            </td>
            <td><?php echo $v['mcoin'];?></td>
            <td><?php echo ($v['value']>0)?number_format($v['value']):'0';?></td>
            <td><?php echo ($v['times']>0)?number_format($v['times']):'0';?></td>
            <td><?php echo ($v['quantities']>0)?number_format($v['quantities']):'0';?></td>
        </tr>
        <?php
                }
            }else{
        ?>
        <tr>
            <td colspan="5" class="emptydata">Dữ liệu không tìm thấy</td>
        </tr>
        <?php
            }
        ?>
    </tbody>
</table>