<table width="100%" id="table2excel" border="0" class="table table-striped table-bordered table-condensed table-hover">
    <thead>
        <tr>
            <th align="center" width="100px">Date</th>
            <th align="center" width="100px">ServerID</th>
            <th align="center" width="100px">Nạp (Input)</th>
            <th align="center" width="100px">Tiêu (Output)</th>
            <th align="center" width="100px">Tồn (Remain)</th>
        </tr>
    </thead>
    <tbody>
        <?php
            if(is_array($listItems)){
                $totalinput = 0;
                foreach($listItems as $v){
                    $totalinput +=$v['input'];
                    $totaloutput +=$v['output'];
                    $totalremain +=$v['remain'];
        ?>
        <tr>
            <td><?php echo $v['date'];?></td>
            <td><?php echo $v['serverid'];?></td>
            <td><?php echo ($v['input']>0)?number_format($v['input']):'0';?></td>
            <td><?php echo ($v['output']>0)?number_format($v['output']):'0';?></td>
            <td><?php echo ($v['remain']>0)?number_format($v['remain']):'0';?></td>
        </tr>
        <?php
                }
        ?>
        <tr>
            <td colspan="2">Tổng cộng</td>
            <td><?php echo ($totalinput>0)?number_format($totalinput):'0';?></td>
            <td><?php echo ($totaloutput>0)?number_format($totaloutput):'0';?></td>
            <td><?php echo ($totalremain>0)?number_format($totalremain):'0';?></td>
        </tr>
        <?php
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