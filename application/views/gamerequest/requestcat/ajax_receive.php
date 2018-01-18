<script>
    jQuery('.dropdown input, .dropdown label').click(function (event) {
        event.stopPropagation();
    });
    jQuery(document).ready(function () {
        jQuery('#receiveGame').multiselect({
            includeSelectAllOption: true,
            enableCaseInsensitiveFiltering: true
        });
    });
</script>
<?php
    $arrReceiveGame = explode(',', $items['receiveGame']);
    $arrNewRecei = array();
    if(count($arrReceiveGame)>0){
        foreach($arrReceiveGame as $are){
            $arrNewRecei[$are] = $are;
        }
    }
?>
<select id="receiveGame" class="server" name="receiveGame[]" multiple="multiple">
    <?php

        if(count($slbReceiveGame)>0){
            foreach($slbReceiveGame as $vs){
    ?>
    <option value="<?php echo $vs['gameID'];?>" <?php echo ($vs['gameID']==$arrNewRecei[$vs['gameID']])?'selected="selected"':'';?>><?php echo $vs['name'];?></option>
    <?php
            }
        }
    ?>
</select>