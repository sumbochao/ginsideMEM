<?php

function GMCheckbox($element) {
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


    $i = 1;
    foreach ($option as $key => $val) {
        $xhtml .= '<div class="checkbox anim-checkbox">';
        if (empty($value) === FALSE && in_array($key, $value)) {
            $xhtml .= '<input class="primary"  value="' . $key . '" checked="checked" type="checkbox" id="ch' . $i . '">';
            $xhtml .= '<label for="ch' . $i . '">' . $val . '</label>';
        } else {
            $xhtml .= '<input class="primary"  value="' . $key . '" type="checkbox" id="ch' . $i . '">';
            $xhtml .= '<label for="ch' . $i . '">' . $val . '</label>';
        }
        $xhtml .= '</div>';
        $i++;
    }
    if (!empty($desc)) {
        $xhtml .= '<small>' . $desc . '</small>';
    }
    $xhtml .= '</div></div>';
    return $xhtml;
}
