<?php

function GMTextView($element) {
    extract($element);

    $class = isset($class) ? $class : 'form-control';
    $lenght = isset($lenght) ? $lenght : 8;

    $xhtml = '<div class="form-group">';
    $xhtml .= isset($label) ? "<label class='control-label col-lg-2'>{$label} : </label>" : "<label class='control-label col-lg-2'></label>";
    $xhtml .= '<div class="col-lg-' . $lenght . '">';
    $xhtml .= $value . ' ' . implode(' ', $extend);
    if (!empty($desc)) {
        $xhtml .= '<small>' . $desc . '</small>';
    }
    $xhtml .= '</div></div>';
    return $xhtml;
}
