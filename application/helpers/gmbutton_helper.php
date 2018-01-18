<?php

function GMButton($element) {

    extract($element);
    $strOption = '';
    if (!empty($extend)) {
        foreach ($extend as $key => $val) {
            $strOption .= "$key='$val' ";
        }
    }
    $xhtml = '<div class="form-group">';
    $xhtml .= isset($label) ? "<label class='control-label col-lg-2'>{$label} : </label>" : "<label class='control-label col-lg-2'></label>";
    $xhtml .= '<div class="col-lg-' . $lenght . '">';
    
    foreach ($button as $key => $value) {
        if (is_array($value) AND $value['name']) {
            $type = isset($value['type']) ? $value['type'] : 'submit';
            $xhtml .= '&nbsp;&nbsp;<input  name="' . $value['name'] . '" type="' . $type . '"  class="navigation_button btn btn-primary" id="' . $value['id'] . '' . $strOption . '" value="' . $value['value'] . '" />';
        
            
        } else {
            foreach ($value as $k => $v) {
                $type = isset($v['type']) ? $v['type'] : 'submit';
                $xhtml .= '<input  name="' . $v['name'] . '" type="' . $type . '"  class="navigation_button btn btn-primary" id="' . $v['id'] . ' ' . $strOption . '" value="' . $v['value'] . '" />';
            }
        }
    }
    $xhtml .= '</div></div>';
    return $xhtml;
}

