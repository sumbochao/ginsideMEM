<?php

function GMTextarea($element) {
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
    $xhtml .= isset($label) ? "<label for='limiter' class='control-label col-lg-2'>{$label} : </label>" : '<label for="limiter" class="control-label col-lg-2"></label>';

    $xhtml .= '<div class="col-lg-' . $lenght . '">';

    $xhtml .= '<textarea name="' . $name . '" type="text"  class="' . $class . '" id="' . $id . ' ' . $strOption . '"> ' . $value . ' </textarea>';
    if (!empty($desc)) {
        $xhtml .= '<small>' . $desc . '</small>';
    }
    $xhtml .= '</div></div>';
    return $xhtml;
}

