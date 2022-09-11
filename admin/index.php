<!DOCTYPE html>
<?php
	ini_set('upload_max_filesize', '10M');
	ini_set('post_max_size', '12M');

	// configuration
	include_once(__DIR__.'/../inc/config/config.php');
	// locales
	foreach (glob(__DIR__.'/../inc/lang/*.php') as $filename) include_once($filename);
	// common functions
	include_once(__DIR__.'/../inc/functions.php');
	// authentication
	include(__DIR__.'/../inc/msoauth.php');

	global $SETTINGS, $OAUTH, $MESSAGES;

	$OAUTH = $_SESSION['msoauth'];
	$LANG = calcLanguage($_SERVER['HTTP_ACCEPT_LANGUAGE']);
?>

<html lang="<?php echo $LANG ?>" xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="content-type" content="text/html; charset=UTF-8">
	<meta charset="utf-8" />
	<meta name="author" content="szumielxd" />
	<meta name="viewport" content="width=device-width, initial-scale=1" />
	<meta name="description" content="<?php echo $MESSAGES[$LANG]['description'] ?>" />
    <meta name="theme-color" content="#e05269" />
	<title><?php echo $MESSAGES[$LANG]['title'] ?></title>
	<link rel="apple-touch-icon" href="<?php echo applyUriPrefix($SETTINGS['apple_touch_icon']) ?>" />
	<link rel="stylesheet" type="text/css" href="https://use.fontawesome.com/releases/v6.2.0/css/all.css" />
	<link rel="stylesheet" type="text/css" href="<?php echo applyUriPrefix('/css/common.css') ?>" />
	<link rel="stylesheet" type="text/css" href="<?php echo applyUriPrefix('/css/upload.css') ?>" />
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
            <div id="upload-table" class="content-table" >
                <h1><?php echo $MESSAGES[$LANG]['header'] ?></h1>
                <div id="upload-table-content">
					<!-- Start: Process Uploaded File -->
					<?php
						global $NAME_ERR, $URL_ERR;
						if (!isSet($_SESSION['upload_result']) && isSet($_POST['name']) && isSet($_FILES['file'])) {
							if (!validateFile($_FILES['file']['name'])) $FILE_ERR = true;
							else if (!file_exists($_FILES['file']['tmp_name'])) $FILE_ERR = true;
							else if (!validateName($_POST['name'])) $NAME_ERR = true;
							else {
								$_SESSION['upload_result'] = uploadPack($_FILES['file']['tmp_name'], $_POST['name']);
								$_SESSION['upload_result']['url_name'] = $_POST['name'];
								header("Location: ".$_SERVER['REQUEST_URI']);
								exit;
							}
						}
					?>
					<!-- End: Process Uploaded File -->
                    <form action="#" method="post" enctype="multipart/form-data" >
						<div class="big-input">
							<small><?php global $NAME_ERR; echo $MESSAGES[$LANG]['input_name']; if (isSet($NAME_ERR)) echo $MESSAGES[$LANG]['invalid_name'] ?></small>
							<input type="text" pattern="[(A-Za-z0-9)]+" name="name" required="true" placeholder="<?php echo $MESSAGES[$LANG]['placeholder_name'] ?>" value="<?php if (isSet($_POST['name'])) echo htmlentities($_POST['name']) ?>" />
						</div>
						<div class="big-input">
							<small><?php global $FILE_ERR; echo $MESSAGES[$LANG]['input_file']; if (isSet($FILE_ERR)) echo $MESSAGES[$LANG]['invalid_file'] ?></small>
							<input type="file" accept=".zip" name="file" required="true" placeholder="<?php echo $MESSAGES[$LANG]['placeholder_file'] ?>" />
						</div>
						<div>
							<button type="submit" id="submit-button"><?php echo $MESSAGES[$LANG]['submit'] ?></button>
						</div>
						<?php 
							if(isSet($_SESSION['upload_result'])) {
								$json = $_SESSION['upload_result'];
								unset($_SESSION['upload_result']);
								echo '<div id="result">';
								echo '<h2 style="color: #555;padding: 0 40px;margin: 5px;float: left;">'.$MESSAGES[$LANG]['result_copy_header'].'</h2>';
								echo '<textarea readonly onclick="this.select();">resource-pack-sha1='.$json['sha1'].PHP_EOL.'resource-pack=http://'.$_SERVER['HTTP_HOST'].'/'.$json['url_name'].'.zip</textarea>';
								echo '</div>';
							}
						?>
					</form>
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