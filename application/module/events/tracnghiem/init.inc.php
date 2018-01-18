<?php
include_once("const.inc.php");
$srv_settings['dir_root_full'] = $_SERVER['DOCUMENT_ROOT'].'/../application/';
$srv_settings['url_root'] = base_url();
$srv_settings['table_prefix'] ="tracnghiem_";
ini_set('session.gc_maxlifetime', '36000');
session_set_cookie_params(0);
session_name(SYSTEM_SESSION_ID);
session_start();
//session_register('MAIN');
if (!isset($_SESSION['MAIN']))
    $_SESSION['MAIN'] = array();
$G_SESSION = &$_SESSION['MAIN'];
$DOCUMENT_ROOT = $srv_settings['dir_root_full'];
$DOCUMENT_LANG = $DOCUMENT_INC . 'languages/';
$DOCUMENT_INC = $DOCUMENT_ROOT . 'module/events/tracnghiem/';
$DOCUMENT_PAGES = $DOCUMENT_INC . 'pages/';
$DOCUMENT_FPDF = $DOCUMENT_INC . 'fpdf/';
$DOCUMENT_PHPMAILER = $DOCUMENT_INC . 'phpmailer/';
require_once($DOCUMENT_INC . 'functionAll.php');
$func = new functionAll();
require_once($DOCUMENT_INC . 'events.inc.php');
$m_strCurrentKVersion = '';
if (!empty($srv_settings['version']))
    $m_strCurrentKVersion = $srv_settings['version'];
else $m_strCurrentKVersion = 'NAV';
header("X-LM1-Version: " . IGT_TIMESTAMP . "-" . $m_strCurrentKVersion);

$m_strCurrentLanguage = $func->readCookieVar('current_language');
if (!empty($m_strCurrentLanguage)) {
    $srv_settings['language'] = $m_strCurrentLanguage;
} else {
}
if ($srv_settings['language'] != 'en')
    include_once($DOCUMENT_LANG . 'vn.lng.php');

reset($lngstr['language']['locale']);
$i_locale_set = false;
while (!$i_locale_set && list(, $val) = each($lngstr['language']['locale']))
    $i_locale_set = setlocale(LC_ALL, $val);

if (ini_get('magic_quotes_runtime') == 1)
    set_magic_quotes_runtime(0);
if (!isset($G_SESSION['config_itemsperpage'])) {
    $G_SESSION['config_itemsperpage'] = $func->getConfigItem(CONFIG_list_length,$srv_settings);
    if (!$G_SESSION['config_itemsperpage'])
        $G_SESSION['config_itemsperpage'] = 30;
}

if (!isset($G_SESSION['config_editortype'])) {
    $G_SESSION['config_editortype'] = $func->getConfigItem(CONFIG_editor_type,$srv_settings);
    if (!$G_SESSION['config_editortype'])
        $G_SESSION['config_editortype'] = 2;
}
$g_vars['page']['title'] = '';
$g_vars['page']['meta'] = '';
$g_vars['page']['body_tag'] = '';
$g_vars['page']['hide_cpanel'] = false;
$g_vars['page']['location'] = array();
$g_vars['page']['errors'] = '';
$g_vars['page']['errors_fatal'] = false;
$g_vars['page']['notifications'] = '';
$g_vars['page']['rowno'] = 0;
?>