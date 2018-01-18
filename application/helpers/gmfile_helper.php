<?php

function GMFile($element) {
    extract($element);

    $strOption = '';
    if (!empty($extend)) {
        foreach ($extend as $key => $val) {
            $strOption .= "$key='$val' ";
        }
    }

    $class = isset($class) ? $class : 'form-control';
    $id = isset($id) ? $id : 'fileUpload';
    $lenght = isset($lenght) ? $lenght : 8;

    $xhtml = '<div class="form-group">';
    $xhtml .= isset($label) ? "<label class='control-label col-lg-2'>{$label} : </label>" : "<label class='control-label col-lg-2'></label>";
    $xhtml .= '<div class="col-lg-' . $lenght . '">';
    $xhtml .= '<div class="fileinput fileinput-new" data-provides="fileinput">';
    $xhtml .= '<span class="btn btn-default btn-file">';
    $xhtml .= '<span class="fileinput-new">Select file</span>';
    $xhtml .= '<span class="fileinput-exists">Change</span>';
    $xhtml .= '<input  name="' . $name . '" type="file" id="' . $id . '" ' . $strOption . ' />';
    $xhtml .= '</span>';
    $xhtml .= '<span class="fileinput-filename"></span>';
    $xhtml .= '</span>';
    $xhtml .= '<a href="#" class="close fileinput-exists" data-dismiss="fileinput" style="float: none">&times;</a>';
    if (!empty($desc)) {
        $xhtml .= '<small>' . $desc . '</small>';
    }
    $xhtml .= '</div></div></div>';



    return $xhtml;
}
