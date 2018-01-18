<select name="id_projects" class=chosen-select tabindex='2' data-placeholder='Chọn danh mục' onchange='visibleParents(this.value)'>
    <option value="0">Chọn package</option>
    <?php
        if($slbProjects==true){
            foreach($slbProjects as $v){
    ?>
    <option value="<?php echo $v['id'];?>" <?php echo $v['id']==$items['id_projects']?'selected="selected"':'';?>><?php echo $v['package_name'];?></option>
    <?php
            }
        }
    ?>
</select>
<script type="text/javascript">
    var config = {
      '.chosen-select'           : {},
      '.chosen-select-deselect'  : {allow_single_deselect:true},
      '.chosen-select-no-single' : {disable_search_threshold:10},
      '.chosen-select-no-results': {no_results_text:'Oops, nothing found!'},
      '.chosen-select-width'     : {width:"100%"}
    }
    for (var selector in config) {
      $(selector).chosen(config[selector]);
    }
</script>