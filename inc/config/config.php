<?php

    $SETTINGS['allowed_groups'] = [1, 2]; // groupId separeded by commas (used by msoauth)
    $SETTINGS['allowed_users'] = [1]; // userId separeded by commas (used by msoauth)
    $SETTINGS['group_displays'] = array( // format: <groupId> => <groupDisplayName>
        '1' => '<font color="">Head Admin</font>',
        '2' => '<font color="darkred">Administrators</font>'
    );
    $SETTINGS['default_theme'] = 'light'; // available: light, dark
    $SETTINGS['default_locale'] = 'en'; // default language (used when none of client defined languages is matched)
    $SETTINGS['default_avatar'] = '/img/avatar.svg'; // default avarat icon displayed in right upper corner
    $SETTINGS['base_path'] = ''; // prefix applied to all local URIs
    $SETTINGS['home_url'] = 'https://example.net'; // homepage addres
    $SETTINGS['logo_url'] = 'https://example.net/logo.webp'; // logo address
    $SETTINGS['user_url'] = 'https://example.net/User-{username}'; // current user address format (user {username} as username placeholder)
    $SETTINGS['avatar_url'] = 'https://example.net/avatars/{path}'; // avarat image url (use {path} as path placeholder)
    $SETTINGS['msoauth_url'] = 'https://example.net'; // TO REMOVE
    $SETTINGS['apple_touch_icon'] = 'https://example.net/logo-apple.jpg'; // icon displayed on apple homepage

?>