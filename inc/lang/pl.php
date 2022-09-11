<?php

global $MESSAGES;
$MESSAGES['pl'] = array(
    'header' => 'Wrzuć texturepack',
    'title' => 'System Zaawansowanego Importu Texturepacków - S.Z.I.T',
    'description' => 'Panel administracyjny uploadu resourcepack\'ów',
    'submit' => 'Do it!',
    'change_theme' => 'Zmień motyw',
    'invalid_name' => '<font color=red>BŁĄD KRYTYCZNY: niepoprawna nazwa</font>',
    'invalid_file' => '<font color=red>BŁĄD KRYTYCZNY: niepoprawny plik max: '.ini_get('upload_max_filesize').', '.json_encode($_FILES).'</font>',
    'placeholder_name' => 'np. WvsP3',
    'placeholder_file' => 'No uploaduj coś',
    'input_name' => 'Nazwa serwera',
    'input_file' => 'Plik',
    'create_success' => '<font size=4dx color=green>Skrócony link utworzony: <a href="{url}">{url}</a></font>',
    'default_username' => 'Unknown',
    'default_rank' => 'None',
    'result_copy_header' => 'Skopiuj mnie',

    '403_title' => 'Odmowa dostępu',
    '403_description' => 'Nie masz dostępu do zawartości tej strony.',
    '403_header' => 'Odmowa dostępu',
    '403_message' => 'Nie masz dostępu do zawartości tej strony. Jeżeli uważasz to za błąd, skontaktuj się z administratorem.'
);

?>