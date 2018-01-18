<?php

function GMImage($element) {
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

    $xhtml .= '<div class="form-group">';
    $xhtml .= isset($label) ? "<label class='control-label col-lg-2'>{$label} : </label>" : "<label class='control-label col-lg-2'></label>";
    $xhtml .= '<div class="col-lg-' . $lenght . '">';
    $xhtml .= '<div class="fileinput fileinput-new" data-provides="fileinput">';
    $xhtml .= '<div class="fileinput-new thumbnail" style="width: 200px; height: 150px;">';
    $xhtml .= '<img data-src="holder.js/100%x100%" alt="...">';
    $xhtml .= '</div>';
    $xhtml .= '<div class="fileinput-preview fileinput-exists thumbnail" style="max-width: 200px; max-height: 150px;"></div>';
    $xhtml .= '<div>';
    $xhtml .= '<span class="btn btn-default btn-file"><span class="fileinput-new">Select image</span><span class="fileinput-exists">Change</span>';
    $xhtml .= '<input  name="' . $name . '" type="file" id="' . $id . '" ' . $strOption . ' />';
    $xhtml .= '</span>';
    $xhtml .= '<a href="#" class="btn btn-default fileinput-exists" data-dismiss="fileinput">Remove</a>';
    $xhtml .= '</div></div></div></div>';



    return $xhtml;
}
