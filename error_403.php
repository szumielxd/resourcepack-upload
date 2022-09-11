<!DOCTYPE html>
<?php
    http_response_code(403);
    // configuration
	include_once(__DIR__.'/inc/config/config.php');
    // locales
    foreach (glob(__DIR__.'/inc/lang/*.php') as $filename) include_once($filename);
	// common functions
	include_once(__DIR__.'/inc/functions.php');

    global $SETTINGS, $MESSAGES, $OAUTH;

	$LANG = calcLanguage($_SERVER['HTTP_ACCEPT_LANGUAGE']);
?>
<html lang="<?php echo $LANG ?>" xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="content-type" content="text/html; charset=UTF-8" />
	<meta charset="utf-8" />
	<meta name="author" content="szumielxd" />
	<meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta name="description" content="<?php echo $MESSAGES[$LANG]['403_description'] ?>" />
    <meta name="theme-color" content="#e05269" />
    <title><?php echo $MESSAGES[$LANG]['403_title'] ?></title>
	<link rel="apple-touch-icon" href="<?php echo applyUriPrefix($SETTINGS['apple_touch_icon']) ?>" />
	<link rel="stylesheet" type="text/css" href="https://use.fontawesome.com/releases/v6.2.0/css/all.css" />
	<link rel="stylesheet" type="text/css" href="<?php echo applyUriPrefix('/css/common.css') ?>" />
	<link rel="stylesheet" type="text/css" href="<?php echo applyUriPrefix('/css/forbidden.css') ?>" />
	<link rel="stylesheet" type="text/css" href="<?php echo applyUriPrefix('/css/themes/'.($_COOKIE['theme'] = $_COOKIE['theme']?: $SETTINGS['default_theme']).'.css') ?>" />
	<script src="<?php echo applyUriPrefix('/js/theme.js') ?>" defer></script>
</head>

<body>
    <header>
        <a href="<?php echo $SETTINGS['home_url'] ?>"><img src="<?php echo $SETTINGS['logo_url'] ?>" alt="logo" height="80px" style="margin: 0 16px" /></a>
        <div id="user-panel">
			<button id="theme-changer" title="<?php echo $MESSAGES[$LANG]['change_theme'] ?>" name="<?php echo $_COOKIE['theme'] ?>">
				<i class="fas theme-icon"></i>
			</button>
			
			<!-- Start: User Info -->
            <?php
                if (isSet($OAUTH)) { // triggered only when msoauth.php is included
                    $user_url = str_replace("{username}", $OAUTH['user_name'], $SETTINGS['user_url']);
                    $user_name = $OAUTH['user_name'];
                    if (isSet($OAUTH['user_avatar'])) {
						$user_avatar = $OAUTH['user_avatar'];
						// strip relative path
						if (strpos($user_avatar, '.') == 0) $user_avatar = substr($user_avatar, 1);
						if (strpos($user_avatar, '/') == 0) $user_avatar = substr($user_avatar, 1);
						$user_avatar = str_replace('{path}', $user_avatar, $SETTINGS['avatar_url']);
						$user_rank = getDisplayGroup($OAUTH);
					}
                }
            ?>
			<a href="<?php echo $user_url ?: "" ?>">
				<div id="user-info">
					<div id="user-name">
						<span id="user-nickname" ><?php echo $user_name ?: $MESSAGES[$LANG]['default_username'] ?></span>
						<span id="user-rank" ><?php echo $user_rank ?: $MESSAGES[$LANG]['default_rank'] ?>
					</div>
					<img id="user-avatar" src="<?php echo $user_avatar ?: $SETTINGS['default_avatar'] ?>" alt="avatar" height="70px" width="70px" />
				</div>
			</a>
			<!-- End: User Info -->
		</div>
    </header>
    <article>
        <div id="content">
            <div id="info-forbidden" class="content-table" >
                <h1 id="info-forbidden-header"><?php echo $MESSAGES[$LANG]['403_header'] ?></h1>
                <div id="info-forbidden-content">
                    <?php echo $MESSAGES[$LANG]['403_message'] ?>
                </div>
            </div>
        </div>
    </article>
    <footer>
        <div class="footer-line"></div>
        <div id="footer-content">Copyright © <?php echo date('Y') ?>&nbsp;<a href="https://github.com/szumielxd">szumielxd</a>. All Rights Reserved</div>
    </footer>
</body>
</html>