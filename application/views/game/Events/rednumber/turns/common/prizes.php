<style>
    .item_rule > .rows > .title{
        float: left;
        margin-right: 10px;
        margin-top:5px;
    }
    .item_rule > .rows > .input{
        float: left;
        padding-right: 5px;
    }
</style>

<div class="control-group">
    <label class="control-label">Giải thưởng (Đặc biệt : 9):</label>
    <div class="controls">
        <?php
            if(!empty($items['prize_prices'])){
                $prize = json_decode($items['prize_prices'],true);
            }
            if(count($listPrizes)>0){
                foreach($listPrizes as $v){
                    
        ?>
        <div class="item_rule">
            <div class="rows">
                <div class="title">Giải</div>
                <div class="input"><input type="text" placeholder="Nhập Giải" value="<?php echo $v['id']; ?>" name="id_prizes" disabled="disabled"/></div>
            </div>
            <div class="rows">
                <div class="title">Price</div>
                <div class="input"><input type="text" placeholder="Nhập price" value="<?php echo $prize[$v['id']]['price']; ?>" name="price" size="20"/></div>
            </div>
            <div class="rows">
                <div class="title">Percent</div>
                <div class="input"><input type="text" placeholder="Nhập percent" value="<?php echo $prize[$v['id']]['percent']; ?>" name="percent" size="20"/></div>
            </div>
            <div class="clr"></div>
        </div>
        <?php
                }
            }
        ?>
    </div>
</div>
