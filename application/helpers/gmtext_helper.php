<?php

function GMText($element) {
    extract($element);
    $strOption = '';
    if (!empty($extend)) {
        foreach ($extend as $key => $val) {
            $strOption .= "$key='$val' ";
        }
    }
    $class = isset($class) ? $class.' form-control' : 'form-control';
    $lenght = isset($lenght) ? $lenght : 8;
    $xhtml = '<div class="form-group">';

    $xhtml .= isset($label) ? "<label class='control-label col-lg-2'>{$label} : </label>" : "<label class='control-label col-lg-2'></label>";
    $xhtml .= '<div class="col-lg-' . $lenght . '">';
    $xhtml .= '<input  name="' . $name . '" type="text"  class="' . $class . '" id="' . $id . '"' . $strOption . 'value="' . $value . '" />';
    if (!empty($desc)) {
        $xhtml .= '<small>' . $desc . '</small>';
    }
    $xhtml .= '</div>';
    $xhtml .= '</div>';
    return $xhtml;
}

