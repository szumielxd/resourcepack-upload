<?php

global $MESSAGES;
$MESSAGES['en'] = array(
    'header' => 'Upload resourcepack',
    'title' => 'Resourcepack Upload System - R.U.S',
    'description' => 'Resourcepack upload panel for administrators',
    'submit' => 'Do it!',
    'change_theme' => 'Change theme',
    'invalid_name' => '<font color=red>CRITICAL ERROR: invalid filename</font>',
    'invalid_file' => '<font color=red>CRITICAL ERROR: exceeded max filesize: '.ini_get('upload_max_filesize').', '.json_encode($_FILES).'</font>',
    'placeholder_name' => 'ex. WvsP3',
    'placeholder_file' => 'Insert your filename',
    'input_name' => 'Server name',
    'input_file' => 'File',
    'create_success' => '<font size=4dx color=green>Skrócony link utworzony: <a href="{url}">{url}</a></font>',
    'default_username' => 'Unknown',
    'default_rank' => 'None',
    'result_copy_header' => 'Copy me',

    '403_title' => 'Access forbidden',
    '403_description' => 'You do not have access to content of this page.',
    '403_header' => 'Access forbidden',
    '403_message' => 'You do not have access to content of this page. If you think this is an error, please contact with administrator.'
);

?>