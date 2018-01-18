<?php $fb_canvas = $object_store_urls['fb_canvas']; unset($object_store_urls['fb_canvas']);?>
<?php foreach($platform as $p):?>
    <?php $title = $p == 'itunes' ? 'IOS' : 'Android';?>
    <div class="form-group app-url">
        <label class="col-sm-2 control-label"><?php echo $title;?> App URL</label>

        <div class="col-sm-10">
            <input type="text" class="form-control" name="appURL_<?php echo $title;?>" value="<?php if(isset($object_store_urls[$p]))echo $object_store_urls[$p]?>">
        </div>
    </div>
<?php endforeach?>

<div class="form-group tracking">
    <label class="col-sm-2 control-label">Tracking via</label>
    <div class="col-sm-10">Facebook app "<?php echo $name;?>" <span style="color: #0000FF; text-decoration: underline;">(<?php echo $id;?>)</span> </div>

</div>

