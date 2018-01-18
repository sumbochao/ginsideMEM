<?php

function GMDropDown($element) {
    extract($element);

    $strOption = '';
    if (!empty($extend)) {
        foreach ($extend as $key => $val) {
            $strOption .= "$key='$val' ";
        }
    }


    $lenght = isset($lenght) ? $lenght : 8;
    $class = isset($class) ? $class : 'form-control';

    $xhtml = '<div class="form-group">';
    $xhtml .= isset($label) ? "<label class='control-label col-lg-2'>{$label} : </label>" : "<label class='control-label col-lg-2'></label>";
    $xhtml .= '<div class="col-lg-' . $lenght . '">';

    $xhtml .= '<select ' . $strOption . ' name="' . $name . '" class="' . $class . '" id="' . $id . '">';
    if (!empty($all))
        $xhtml .= '<option value="">' . $all . '</option>';

    foreach ($option as $key => $val) {
        if ($value == $key) {
            $xhtml .= '<option value="' . $key . '" selected="selected">' . $val . '</option>';
        } else {
            $xhtml .= '<option value="' . $key . '">' . $val . '</option>';
        }
    }
    $xhtml .= '</select>';
    if (!empty($desc)) {
        $xhtml .= '<small>' . $desc . '</small>';
    }
    $xhtml .= '</div></div>';
    return $xhtml;
}
