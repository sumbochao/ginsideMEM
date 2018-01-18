<table width="100%" id="table2excel" border="0" class="table table-striped table-bordered table-condensed table-hover">
    <thead>
        <tr>
            <th align="center" width="100px">Date</th>
            <th align="center" width="100px">Server ID</th>
            <th align="center" width="100px">Card ID</th>
            <th align="center" width="100px">Name</th>
            <th align="center" width="100px">ThroughNum 0</th>
            <th align="center" width="100px">ThroughNum 1</th>
            <th align="center" width="100px">ThroughNum 2</th>
            <th align="center" width="100px">ThroughNum 3</th>
            <th align="center" width="100px">ThroughNum 4</th>
            <th align="center" width="100px">ThroughNum 5</th>
            <th align="center" width="100px">ThroughNum 6</th>
        </tr>
    </thead>
    <tbody>
        <?php
            if(is_array($listItems)){
                $totalinput = 0;
                foreach($listItems as $v){
        ?>
        <tr>
            <td><?php echo $v['date'];?></td>
            <td><?php echo $v['serverID'];?></td>
            <td><?php echo $v['cardID'];?></td>
            <td><?php echo $v['Name'];?></td>
            <td><?php echo $v['throughNum0'];?></td>
            <td><?php echo $v['throughNum1'];?></td>
            <td><?php echo $v['throughNum2'];?></td>
            <td><?php echo $v['throughNum3'];?></td>
            <td><?php echo $v['throughNum4'];?></td>
            <td><?php echo $v['throughNum5'];?></td>
            <td><?php echo $v['throughNum6'];?></td>
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