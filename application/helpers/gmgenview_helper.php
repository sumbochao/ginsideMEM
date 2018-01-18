<?php

function GMGenView($element) {

    extract($element);

    $strOption = '';
    if (!empty($extend)) {
        foreach ($extend as $key => $val) {
            $strOption .= "$key='$val' ";
        }
    }
    $action = isset($action) ? 'action="' . $action . '"' : '';
    $method = isset($method) ? $method : 'GET';
    $lenght = isset($lenght) ? $lenght : 12;

    $xhtml = '<div class="row">';
    $xhtml .= '<div class="col-lg-' . $lenght . '">';
    $xhtml .= '<div class="box dark">';
    $xhtml .= '<header>';
    $xhtml .= '<h5>'.$legend.'</h5>';
    $xhtml .= '<div class="toolbar">';
    $xhtml .= '<ul class="nav">';
    $xhtml .= '<li>';
    $xhtml .= '<a class="minimize-box" data-toggle="collapse" href="#div-1">';
    $xhtml .= '<i class="fa fa-chevron-up"></i>';
    $xhtml .= '</a>';
    $xhtml .= '</li>';
    $xhtml .= '</ul>';
    $xhtml .= '</div>';
    $xhtml .= '</header>';
    $xhtml .= '<div id="div-1" class="accordion-body collapse in body">';
    $xhtml .= '<form id="' . $id . '" ' . $action . '  method="' . $method . '" class="form-horizontal">';
    $xhtml .= $content;
    $xhtml .= '</form>';
    $xhtml .= '</div>';
    $xhtml .= '</div>';
    $xhtml .= '</div>';

    $xhtml .= '</div>';


    return $xhtml;
}
