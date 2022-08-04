<?php

// display errors to form after validation fails
function display_form_error($validation,$field,$formname)
{
    if ($validation->hasError($field,$formname)) {
        return $validation->getError($field);
        // echo "請檢查您的". $formname. "是否輸入正確";
    }
}
