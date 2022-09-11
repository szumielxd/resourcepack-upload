<?php

// configuration
include_once(__DIR__.'/config/config.php');
// locales
foreach (glob(__DIR__.'/lang/*.php') as $filename) include_once($filename);

function applyUriPrefix($link) {
    global $SETTINGS;
    if (strpos($link, '/') === 0) return '/'.$SETTINGS['base_path'].substr($link, 1);
    return $link;
}

function calcLanguage($lang) {
    global $MESSAGES, $SETTINGS;
    foreach (explode(',', $lang) as $str) {
        if ($index = strpos($str, ';')) {
            $locales[substr($str, 0, $index)] = floatval(preg_replace('/q=(\d+(.\d+)?)/', '$1', substr($str, $index)));
        }
    }
    arsort($locales);
    foreach ($locales as $locale => $weight) {
        if (isSet($MESSAGES[$locale])) return $locale;
    }
    return $SETTINGS['default_locale'];
}

function validateName($link) {
    return preg_match('/^[a-z0-9]+$/', polishToLower($link));
}

function validateFile($link) {
    return preg_match('/^.+\.zip$/', polishToLower($link));
}

function polishToLower($link) {
    $link = strtolower($link);
    return str_replace(array('Ż','Ź','Ć','Ń','Ó','Ł','Ę','Ą','Ś'), array('ż','ź','ć','ń','ó','ł','ę','ą','ś'), $link);
}

function getBiggestGroup($groups) {
    global $SETTINGS;
    $big = 0;
    $gr = 0;
    foreach ($groups as $group) {
        if ($big < 0) return $gr;
        if (isSet($SETTINGS['max_time'][$group]) && ($SETTINGS['max_time'][$group] < 0 || $SETTINGS['max_time'][$group] > $big)) {
            $big = $SETTINGS['max_time'][$group];
            $gr = $group;
        }
    }
    return $gr;
}

function info($text) {
    internal_log($text, 0);
}

function warn($text) {
    internal_log($text, 1);
}

function error($text) {
    internal_log($text, 2);
}

function internal_log($text, $status = 0) {
    if ($status === 1) $type = "[WARN]";
    else if ($status === 1) $type = "[ERROR]";
    else $type = "[INFO]";
    file_put_contents('txt_upload.log', '['.date('d-M-y H:m:s', time()).'] '.$type.' '.$text.PHP_EOL, FILE_APPEND);
}

function human_filesize($bytes, $decimals = 2) {
    $sz = 'BKMGTP';
    $factor = floor((strlen($bytes) - 1) / 3);
    return sprintf("%.{$decimals}f", $bytes / pow(1024, $factor)) . @$sz[$factor];
}

function uploadPack($file, $name) {
    global $OAUTH;
    $name = strtolower(basename($name));
    if (!file_exists($dir = dirname(__DIR__).'/upload/'.$name)) mkdir($dir);
    $time = time();
    $sha = sha1_file($file);
    $fname = $dir.'/'.$sha.'.zip';
    if (!file_exists($fname)) move_uploaded_file($file, $fname);
    if (!file_exists($data = $dir.'/update.json')) file_put_contents($data, json_encode(array()));
    $json = json_decode(file_get_contents($data), JSON_OBJECT_AS_ARRAY);
    $json['latest'] = $time;
    $json['uploads'][$time] = array(
        'sha1' => $sha,
        'size' => filesize($fname),
        'size_human' => human_filesize(filesize($fname)),
        'author' => $OAUTH['user_name']
    );
    $json['files'][$sha] = array(
        'file' => basename(dirname($fname)).'/'.basename($fname),
        'size' => filesize($fname),
        'size_human' => human_filesize(filesize($fname)),
    );
    file_put_contents($data, json_encode($json, JSON_PRETTY_PRINT));
    
    // raw resourcepack
    if (file_exists($dir = dirname(__DIR__).'/raw/'.$name)) deleteDirectory($dir);
    mkdir($dir);
    $zip = new ZipArchive;
    $r = $zip->open($fname);
    if ($r === true) {
        $zip->extractTo($dir);
        $zip->close();
        clearDirectory($dir, '.htaccess');
        info("successfully unzipped file `$fname`.");
    } else {
        error("Cannot unzip file `$fname`.");
    }
    return $json['uploads'][$time];
}

function deleteDirectory($dir) : bool {
    system('rm -rf -- ' . escapeshellarg($dir), $retval);
    return $retval == 0; // UNIX commands returns zero on success
}

function clearDirectory($dir, $fileName) : bool {
    system('find ' . escapeshellarg($dir) . ' -type f -name ' . escapeshellarg($fileName) . ' -delete', $retval);
    return $retval == 0; // UNIX commands returns zero on success
}

?>