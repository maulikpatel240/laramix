<?php

use App\Models\Api\Hashtags;
use App\Models\Modules;
use App\Models\Permission;
use App\Models\RoleAccess;
use App\Models\Api\Post;
use App\Models\Api\PostComment;
use App\Models\Api\PostCommentReply;
use App\Models\Api\User;
use Carbon\Carbon;
use Illuminate\Support\Route;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

/**
 * Henerate UUID.
 *
 * @return uuid
 */
function generateUuid()
{
    return Str::uuid();
}

if (!function_exists('homeRoute')) {
    /**
     * Return the route to the "home" page depending on authentication/authorization is_active.
     *
     * @return string
     */
    function homeRoute()
    {
        if (access()->allow('view-backend')) {
            return 'admin.dashboard';
        } elseif (auth()->check()) {
            return 'frontend.user.dashboard';
        }

        return 'frontend.index';
    }
}

// Global helpers file with misc functions.
if (!function_exists('app_name')) {
    /**
     * Helper to grab the application name.
     *
     * @return mixed
     */
    function app_name()
    {
        return config('app.name');
    }
}

if (!function_exists('access')) {
    /**
     * Access (lol) the Access:: facade as a simple function.
     */
    function access()
    {
        return app('access');
    }
}

if (!function_exists('includeRouteFiles')) {
    /**
     * Loops through a folder and requires all PHP files
     * Searches sub-directories as well.
     *
     * @param $folder
     */
    function includeRouteFiles($folder)
    {
        $directory = $folder;
        $handle = opendir($directory);
        $directory_list = [$directory];

        while (false !== ($filename = readdir($handle))) {
            if ($filename != '.' && $filename != '..' && is_dir($directory . $filename)) {
                array_push($directory_list, $directory . $filename . '/');
            }
        }

        foreach ($directory_list as $directory) {
            foreach (glob($directory . '*.php') as $filename) {
                require $filename;
            }
        }
    }
}

if (!function_exists('getRtlCss')) {
    /**
     * The path being passed is generated by Laravel Mix manifest file
     * The webpack plugin takes the css filenames and appends rtl before the .css extension
     * So we take the original and place that in and send back the path.
     *
     * @param $path
     *
     * @return string
     */
    function getRtlCss($path)
    {
        $path = explode('/', $path);
        $filename = end($path);
        array_pop($path);
        $filename = rtrim($filename, '.css');

        return implode('/', $path) . '/' . $filename . '.rtl.css';
    }
}

if (!function_exists('escapeSlashes')) {
    /**
     * Access the escapeSlashes helper.
     */
    function escapeSlashes($path)
    {
        $path = str_replace('\\', DIRECTORY_SEPARATOR, $path);
        $path = str_replace('//', DIRECTORY_SEPARATOR, $path);
        $path = trim($path, DIRECTORY_SEPARATOR);

        return $path;
    }
}

if (!function_exists('getRouteUrl')) {
    /**
     * Converts querystring params to array and use it as route params and returns URL.
     */
    function getRouteUrl($url, $url_type = 'route', $separator = '?')
    {
        $routeUrl = '';

        if (!empty($url)) {
            if ($url_type == 'route') {
                if (strpos($url, $separator) !== false) {
                    $urlArray = explode($separator, $url);
                    $url = $urlArray[0];
                    parse_str($urlArray[1], $params);
                    $routeUrl = route($url, $params);
                } else {
                    $routeUrl = route($url);
                }
            } else {
                $routeUrl = $url;
            }
        }

        return $routeUrl;
    }
}

if (!function_exists('checkDatabaseConnection')) {
    /**
     * @return bool
     */
    function checkDatabaseConnection()
    {
        try {
            DB::connection()->reconnect();
            return true;
        } catch (Exception $ex) {
            return false;
        }
    }
}

if (!function_exists('encode')) {
    /**
     * @return bool
     */
    function encode($str)
    {
        return base64_encode($str);
    }
}

if (!function_exists('decode')) {
    /**
     * @return bool
     */
    function decode($str)
    {
        return base64_decode($str);
    }
}

if (!function_exists('currentDateTime')) {
    function currentDateTime()
    {
        $format = 'Y-m-d H:i:s';
        return date($format);
    }
}
if (!function_exists('currentDate')) {
    function currentDate()
    {
        $format = 'Y-m-d';
        return date($format);
    }
}
if (!function_exists('currentTime')) {
    function currentTime($format = '24')
    {
        $format = 'H:i:s';
        if ($format == 12) {
            $format = 'H:i A';
        }
        return date($format);
    }
}

if (!function_exists('checkaccess')) {
    function checkaccess($action = "", $controller = "")
    {
        if ($action == 'store') {
            $action = 'create';
        } elseif ($action == 'edit') {
            $action = 'update';
        } elseif ($action == 'accessupdate') {
            $action = 'access';
        }
        $adminuser = auth()->user();
        if ($action && $controller) {
            $modulesdata = Modules::where(['is_active' => '1', 'controller' => $controller, 'action' => $action])->first();
            if (empty($modulesdata)) {
                $modulesdata = Modules::where(['is_active' => '1', 'controller' => $controller])->first();
            }
            if ($modulesdata) {
                $permissionAction = Permission::where(['module_id' => $modulesdata->id, 'controller' => $controller])->where('action', $action)->first();
                if ($permissionAction) {
                    $module_access = RoleAccess::where(['role_id' => $adminuser->role_id, 'permission_id' => $permissionAction->id, 'access' => '1'])->first();
                    if ($module_access) {
                        return true;
                    }
                } else {
                    $permissionName = Permission::where(['module_id' => $modulesdata->id, 'controller' => $controller])->where('name', $action)->first();
                    if ($permissionName) {
                        $module_access = RoleAccess::where(['role_id' => $adminuser->role_id, 'permission_id' => $permissionName->id, 'access' => '1'])->first();
                        if ($module_access) {
                            return true;
                        }
                    }
                }
            }
        }
        return false;
    }
}

if (!function_exists('getController')) {
    function getControllerName()
    {
        $action = app('request')->route()->getAction();

        $controller = class_basename($action['controller']);

        list($controller, $action) = explode('@', $controller);
        $current = strtolower(str_replace('Controller', '', $controller));
        return $current;
    }
}

if (!function_exists('getAction')) {
    function getActionName()
    {
        $action = app('request')->route()->getAction();

        $controller = class_basename($action['controller']);

        list($controller, $action) = explode('@', $controller);

        return $action;
    }
}

if (!function_exists('ImageFullUrl')) {
    function ImageFullUrl($image_name, $path)
    {
        return url('storage/' . $path . '/' . $image_name);
    }
}

if (!function_exists('UtcToLocal')) {
    function UtcToLocal($date, $format = "")
    {
        if ($date) {
            $user = auth()->user();
            $format = $format ? $format : config('params.datetimeFormat');
            if ($user && $user->timezone) {
                $dateformated = Carbon::parse($date)->timezone($user->timezone)->format($format);
                return $dateformated;
            }
        }
        return "";
    }
}

if (!function_exists('storageDate')) {
    function storageDate()
    {
        return date('Y') . '/' . date('m') . '/' . date('d');
    }
}

if (!function_exists('mime_type')) {
    function mime_type($filename)
    {

        $mime_types = array(
            'txt' => 'text/plain',
            'htm' => 'text/html',
            'html' => 'text/html',
            'css' => 'text/css',
            'json' => array('application/json', 'text/json'),
            'xml' => 'application/xml',
            'swf' => 'application/x-shockwave-flash',
            'flv' => 'video/x-flv',

            'hqx' => 'application/mac-binhex40',
            'cpt' => 'application/mac-compactpro',
            'csv' => array('text/x-comma-separated-values', 'text/comma-separated-values', 'application/octet-stream', 'application/vnd.ms-excel', 'application/x-csv', 'text/x-csv', 'text/csv', 'application/csv', 'application/excel', 'application/vnd.msexcel'),
            'bin' => 'application/macbinary',
            'dms' => 'application/octet-stream',
            'lha' => 'application/octet-stream',
            'lzh' => 'application/octet-stream',
            'exe' => array('application/octet-stream', 'application/x-msdownload'),
            'class' => 'application/octet-stream',
            'so' => 'application/octet-stream',
            'sea' => 'application/octet-stream',
            'dll' => 'application/octet-stream',
            'oda' => 'application/oda',
            'ps' => 'application/postscript',
            'smi' => 'application/smil',
            'smil' => 'application/smil',
            'mif' => 'application/vnd.mif',
            'wbxml' => 'application/wbxml',
            'wmlc' => 'application/wmlc',
            'dcr' => 'application/x-director',
            'dir' => 'application/x-director',
            'dxr' => 'application/x-director',
            'dvi' => 'application/x-dvi',
            'gtar' => 'application/x-gtar',
            'gz' => 'application/x-gzip',
            'php' => 'application/x-httpd-php',
            'php4' => 'application/x-httpd-php',
            'php3' => 'application/x-httpd-php',
            'phtml' => 'application/x-httpd-php',
            'phps' => 'application/x-httpd-php-source',
            'js' => array('application/javascript', 'application/x-javascript'),
            'sit' => 'application/x-stuffit',
            'tar' => 'application/x-tar',
            'tgz' => array('application/x-tar', 'application/x-gzip-compressed'),
            'xhtml' => 'application/xhtml+xml',
            'xht' => 'application/xhtml+xml',
            'bmp' => array('image/bmp', 'image/x-windows-bmp'),
            'gif' => 'image/gif',
            'jpeg' => array('image/jpeg', 'image/pjpeg'),
            'jpg' => array('image/jpeg', 'image/pjpeg'),
            'jpe' => array('image/jpeg', 'image/pjpeg'),
            'png' => array('image/png', 'image/x-png'),
            'tiff' => 'image/tiff',
            'tif' => 'image/tiff',
            'shtml' => 'text/html',
            'text' => 'text/plain',
            'log' => array('text/plain', 'text/x-log'),
            'rtx' => 'text/richtext',
            'rtf' => 'text/rtf',
            'xsl' => 'text/xml',
            'docx' => 'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
            'xlsx' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
            'word' => array('application/msword', 'application/octet-stream'),
            'xl' => 'application/excel',
            'eml' => 'message/rfc822',

            // images
            'png' => 'image/png',
            'jpe' => 'image/jpeg',
            'jpeg' => 'image/jpeg',
            'jpg' => 'image/jpeg',
            'gif' => 'image/gif',
            'bmp' => 'image/bmp',
            'ico' => 'image/vnd.microsoft.icon',
            'tiff' => 'image/tiff',
            'tif' => 'image/tiff',
            'svg' => 'image/svg+xml',
            'svgz' => 'image/svg+xml',

            // archives
            'zip' => array('application/x-zip', 'application/zip', 'application/x-zip-compressed'),
            'rar' => 'application/x-rar-compressed',
            'msi' => 'application/x-msdownload',
            'cab' => 'application/vnd.ms-cab-compressed',

            // audio/video
            'mid' => 'audio/midi',
            'midi' => 'audio/midi',
            'mpga' => 'audio/mpeg',
            'mp2' => 'audio/mpeg',
            'mp3' => array('audio/mpeg', 'audio/mpg', 'audio/mpeg3', 'audio/mp3'),
            'aif' => 'audio/x-aiff',
            'aiff' => 'audio/x-aiff',
            'aifc' => 'audio/x-aiff',
            'ram' => 'audio/x-pn-realaudio',
            'rm' => 'audio/x-pn-realaudio',
            'rpm' => 'audio/x-pn-realaudio-plugin',
            'ra' => 'audio/x-realaudio',
            'rv' => 'video/vnd.rn-realvideo',
            'wav' => array('audio/x-wav', 'audio/wave', 'audio/wav'),
            'mpeg' => 'video/mpeg',
            'mpg' => 'video/mpeg',
            'mpe' => 'video/mpeg',
            'qt' => 'video/quicktime',
            'mov' => 'video/quicktime',
            'avi' => 'video/x-msvideo',
            'movie' => 'video/x-sgi-movie',

            // adobe
            'pdf' => 'application/pdf',
            'psd' => array('image/vnd.adobe.photoshop', 'application/x-photoshop'),
            'ai' => 'application/postscript',
            'eps' => 'application/postscript',
            'ps' => 'application/postscript',

            // ms office
            'doc' => 'application/msword',
            'rtf' => 'application/rtf',
            'xls' => array('application/excel', 'application/vnd.ms-excel', 'application/msexcel'),
            'ppt' => array('application/powerpoint', 'application/vnd.ms-powerpoint'),

            // open office
            'odt' => 'application/vnd.oasis.opendocument.text',
            'ods' => 'application/vnd.oasis.opendocument.spreadsheet',
        );

        $ext = explode('.', $filename);
        $ext = strtolower(end($ext));

        if (array_key_exists($ext, $mime_types)) {
            return (is_array($mime_types[$ext])) ? $mime_types[$ext][0] : $mime_types[$ext];
        } else if (function_exists('finfo_open')) {
            if (file_exists($filename)) {
                $finfo = finfo_open(FILEINFO_MIME);
                $mimetype = finfo_file($finfo, $filename);
                finfo_close($finfo);
                return $mimetype;
            }
        }

        return 'application/octet-stream';
    }
}


if (!function_exists('IsUrl')) {
    function IsUrl($uri)
    {
        if (empty($uri)) {
            return false;
        }
        if (filter_var($uri, FILTER_VALIDATE_URL)) {
            return true;
        }
        return false;
    }
}


if (!function_exists('GetHashtag')) {
    function GetHashtag($tag = '', $type = true)
    {
        $create = false;
        if (empty($tag)) {
            return false;
        }
        if (is_numeric($tag)) {
            $query = Hashtags::where(['id' => $tag]);
        } else {
            $query  = Hashtags::where(['tag' => $tag]);
            $create = true;
        }
        $sql_query   = $query->get();
        $sql_numrows = $sql_query->count();
        $week        = date('Y-m-d', strtotime(date('Y-m-d') . " +1week"));
        if ($sql_numrows == 1) {
            if ($sql_query->count()) {
                $sql_fetch = $query->first();
                return $sql_fetch->toArray();
            }
            return false;
        } elseif ($sql_numrows == 0 && $type == true) {
            if ($create == true) {
                $HashtagsModel = new Hashtags;
                $HashtagsModel->tag = $tag;
                $HashtagsModel->last_trend_time = time();
                $HashtagsModel->expire = $week;
                $HashtagsModel->trend_use_num = 0;
                $HashtagsModel->save();
                if ($HashtagsModel) {
                    return $HashtagsModel->toArray();
                }
            }
        }
    }
}

if (!function_exists('GetHashtag')) {
    function sanitize_output($buffer)
    {
        $search  = array(
            '/\>[^\S ]+/s', // strip whitespaces after tags, except space
            '/[^\S ]+\</s', // strip whitespaces before tags, except space
            '/(\s)+/s', // shorten multiple whitespace sequences
            '/<!--(.|\s)*?-->/'
            // Remove HTML comments
        );
        $replace = array(
            '>',
            '<',
            '\\1',
            ''
        );
        $buffer  = preg_replace($search, $replace, $buffer);
        return $buffer;
    }
}
if (!function_exists('Markup')) {
    function Markup($text, $link = true, $hashtag = true, $mention = true, $post_id = 0, $comment_id = 0, $reply_id = 0)
    {
        if ($mention == true) {
            $Orginaltext   = $text;
            $mention_regex = '/@\[([0-9]+)\]/i';
            if (preg_match_all($mention_regex, $text, $matches)) {
                foreach ($matches[1] as $match) {
                    $match_user   = UserData($match);
                    $match_search = '@[' . $match . ']';
                    if (isset($match_user['id'])) {
                        $match_replace = '@' . $match_user['username'] . '';
                        $text          = str_replace($match_search, $match_replace, $text);
                    } else {
                        $match_replace = '';
                        $Orginaltext   = str_replace($match_search, $match_replace, $Orginaltext);
                        $text          = str_replace($match_search, $match_replace, $text);
                        if (!empty($post_id)) {
                            Post::where('id', $post_id)->update(['post_text' => $Orginaltext]);
                        } elseif (!empty($comment_id)) {
                            PostComment::where('id', $comment_id)->update(['text' => $Orginaltext]);
                        } elseif (!empty($reply_id)) {
                            PostCommentReply::where('id', $reply_id)->update(['text' => $Orginaltext]);
                        }
                    }
                }
            }
        }
        if ($link == true) {
            $link_search = '/\[a\](.*?)\[\/a\]/i';
            if (preg_match_all($link_search, $text, $matches)) {
                foreach ($matches[1] as $match) {
                    $match_decode     = urldecode($match);
                    $match_decode_url = $match_decode;
                    $count_url        = mb_strlen($match_decode);
                    if ($count_url > 50) {
                        $match_decode_url = mb_substr($match_decode_url, 0, 30) . '....' . mb_substr($match_decode_url, 30, 20);
                    }
                    $match_url = $match_decode;
                    if (!preg_match("/http(|s)\:\/\//", $match_decode)) {
                        $match_url = 'http://' . $match_url;
                    }
                    $text = str_replace('[a]' . $match . '[/a]', '<a href="' . strip_tags($match_url) . '" target="_blank" class="hash" rel="nofollow">' . $match_decode_url . '</a>', $text);
                }
            }
        }
        if ($hashtag == true) {
            $hashtag_regex = '/(#\[([0-9]+)\])/i';
            preg_match_all($hashtag_regex, $text, $matches);
            $match_i = 0;
            foreach ($matches[1] as $match) {
                $hashtag  = $matches[1][$match_i];
                $hashkey  = $matches[2][$match_i];
                $hashdata = GetHashtag($hashkey);
                if (is_array($hashdata)) {
                    $hashlink = '#' . $hashdata['tag'] . '';
                    $text = str_replace($hashtag, $hashlink, $text);
                }
                $match_i++;
            }
        }
        return $text;
    }
}

if (!function_exists('UserData')) {
    function UserData($user_id)
    {
        if (empty($user_id) || !is_numeric($user_id) || $user_id < 0) {
            return false;
        }
        $query_one = User::where('id', $user_id)->first();
        $fetched_data = $query_one->toArray();
        if (empty($fetched_data)) {
            return array();
        }
        return $fetched_data;
    }
}
if (!function_exists('UserIdFromUsername')) {
    function UserIdFromUsername($username)
    {
        if (empty($username)) {
            return false;
        }
        $query = User::select(['id'])->where('username', $username)->first();
        return $query ? $query->id : "";
    }
}
if (!function_exists('generate_string')) {
    function generate_string($input, $strength = 16)
    {
        $input_length = strlen($input);
        $random_string = '';
        for ($i = 0; $i < $strength; $i++) {
            $random_character = $input[mt_rand(0, $input_length - 1)];
            $random_string .= $random_character;
        }

        return $random_string;
    }
}
