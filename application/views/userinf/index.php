<?php

$GMText = GMText(array('label' => 'Text', 'name' => 'abc', 'id' => 'text1'));
$GMDate = GMText(array('label' => 'Date', 'class' => 'datepicker', 'name' => 'abc', 'id' => 'text1'));
$GMDateTime = GMText(array('label' => 'Date', 'class' => 'timepicker', 'name' => 'abc', 'id' => 'form-control'));
$GMTextarea = GMTextarea(array('label' => 'editor', 'class' => 'ckeditor', 'name' => 'abc', 'id' => 'text1'));
$GMCheckbox = GMCheckbox(array('label' => 'Checkbox', 'name' => 'abc', 'id' => 'text1', 'option' => array('a', 'b', 'c')));
$GMDropDown = GMDropDown(array('label' => 'Dropdown', 'name' => 'abc', 'id' => 'text1', 'option' => array('a', 'b', 'c')));
$GMFile = GMFile(array('label' => 'File', 'name' => 'abc', 'id' => 'text1', 'option' => array('a', 'b', 'c')));
$Image = GMImage(array('label' => 'Image', 'name' => 'abc', 'id' => 'text1', 'option' => array('a', 'b', 'c')));
$Button = GMButton(array('button' => array(
        array('name' => 'btnSubmit', 'type' => 'submit', 'id' => 'btnSubmit', 'value' => 'Tổng lượng nạp'),
        array('name' => 'btnSubmit', 'type' => 'submit', 'id' => 'btnSubmit', 'value' => 'Tổng lượng nạp'),
        array('name' => 'btnSubmit', 'type' => 'submit', 'id' => 'btnSubmit', 'value' => 'Tổng lượng nạp'),
        array('name' => 'btnSubmit', 'type' => 'submit', 'id' => 'btnSubmit', 'value' => 'Tổng lượng nạp'),
        )));
$content = $GMText . $GMDate . $GMDateTime . $GMCheckbox . $GMDropDown . $GMFile . $Image . $GMTextarea . $Button;
$xhtml = GMGenView(array('content' => $content, 'action' => base_url('?control=cron&func=activeMobo'), 'method' => 'POST', 'legend' => 'GM REPORT'));
echo $xhtml;
?> 