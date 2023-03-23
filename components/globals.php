<?php
/**
 * This is the shortcut to DIRECTORY_SEPARATOR
 */
defined('DS') or define('DS',DIRECTORY_SEPARATOR);
define("STARTDATE", "2022-01-01");
define("ENDDATE",   "2022-12-31");
define("SECOND_JANUARY", "2020-01-02");
define("PERCENT",   "1.02");        // tannarxga qo'shiladigan procent
// qarzdorliklar limiti DEBT1 - muxim qilientlarga
// DEBT2 yaxshi qlientlarga
define("DEBT1",     "0.15");
define("DEBT2",     "0.05");
// LIMIT_IN QARZ LIMITIGA RIOYA QILGANDA, LIMIT_OUT OSHIB KETGANIDA  
define("MUXIM_LIMIT_IN", "0.20");       // 20%
define("MUXIM_LIMIT_OUT", "0.80");      // 80%
define("YAXSHI_LIMIT_IN", "0.40");      // 40%
define("YAXSHI_LIMIT_OUT", "1.00");     // 100%
//minum qarz balli uchun
define("MINQARZ",5);

//NDS
define("NDS",1.12);


function addDays($date, $days){
    $newdate = strtotime ( "+$days day", strtotime ($date));
    $newdate = date ( 'Y-m-d' , $newdate );

    return $newdate;
}

function decDays($date, $days){
    $newdate = strtotime ( "-$days day", strtotime ($date));
    $newdate = dateBase(date ( 'Y-m-d' , $newdate ));

    return $newdate;
}

function dateDiff($date1, $date2)
{
    // ikkita sana orasidagi kunlar soni, farqi
    $date1 = new DateTime($date1);
    $date2 = new DateTime($date2);
    $interval = $date1->diff($date2);

    return $interval->days;
}

function checkMonth($yymm, $date)
{
    $dateNew = DateTime::createFromFormat("Y-m-d", $date);
    $year = $dateNew->format("Y");
    $month = $dateNew->format("m");

    $current = $year % 100;
    $current .= ''.$month;

    if ($yymm == $current)
    {
        return true;
    } else {
        return false;
    }
}
function nextMonthYYMM($yymm)
{
    $month = $yymm % 100;
    $year = $yymm / 100 - $month / 100;

    $month++;
    if ($month > 12){
        return ($year + 1).'01'; // keyingi yilning birinchi oyi yanvar
    }

    if ($month < 10){
        return $year.'0'.$month; // 02, 03, 09 bo'lishi uchun
    }

    return $year.''.$month;
}

function getYYMM($date)
{
    $date = \DateTime::createFromFormat("Y-m-d", $date);
    $year = $date->format("Y") % 100;
    $month = $date->format("m");
    return $year.''.$month;
}

function wrap($fontSize, $fontFace, $string, $width) {

    $ret = "";
    $arr = explode(" ", $string);

    foreach ( $arr as $word ){
      $testboxWord = imagettfbbox($fontSize, 0, $fontFace, $word);

      // huge word larger than $width, we need to cut it internally until it fits the width
      $len = strlen($word);
      while ( $testboxWord[2] > $width && $len > 0) {
        $word = substr($word, 0, $len);
        $len--;
        $testboxWord = imagettfbbox($fontSize, 0, $fontFace, $word);
      }

      $teststring = $ret.' '.$word;
      $testboxString = imagettfbbox($fontSize, 0, $fontFace, $teststring);
      if ( $testboxString[2] > $width ){
        $ret.=($ret==""?"":"\n").$word;
       } else {
         $ret.=($ret==""?"":' ').$word;
      }
    }

  return $ret;
}

function drawBorder(&$img, &$color, $thickness) {
  $x = ImageSX($img);
  $y = ImageSY($img);
  for($i = 0; $i < $thickness; $i++)
    ImageRectangle($img, $i, $i, $x--, $y--, $color);
}

function base64_to_jpeg( $base64_string, $output_file ) {
    
    $ifp = fopen( $output_file, "wb" ); 
    fwrite( $ifp, base64_decode( $base64_string) ); 
    fclose( $ifp ); 
    return( $output_file ); 
}


/**
 * This is the shortcut to Yii::app()
 */
function app()
{
    return Yii::app();
}
 
/**
 * This is the shortcut to Yii::app()->clientScript
 */
function cs()
{
    // You could also call the client script instance via Yii::app()->clientScript
    // But this is faster
    return Yii::app()->getClientScript();
}
 
/**
 * This is the shortcut to Yii::app()->user.
 */
function user() 
{
    return Yii::app()->getUser();
}
 
/**
 * This is the shortcut to Yii::app()->createUrl()
 */
function url($route,$params=array(),$ampersand='&')
{
    return Yii::$app->getUrlManager()->createUrl($route,$params,$ampersand);
    // return Yii::app()->createUrl($route,$params,$ampersand);
}

/**
 * This is the shortcut to Yii::app()->createUrl()
 */
function urlServer($route,$params=array())
{
    $url = param('serverUrl').'/'.$route.'?'.http_build_query($params);
    return $url;
}
 
/**
 * This is the shortcut to CHtml::encode
 */
function h($text)
{
    return htmlspecialchars($text,ENT_QUOTES,Yii::app()->charset);
}
 
/**
 * This is the shortcut to CHtml::link()
 */
function l($text, $url = '#', $htmlOptions = array()) 
{
    return CHtml::link($text, $url, $htmlOptions);
}
 
/**
 * This is the shortcut to Yii::t() with default category = 'stay'
 */
function t($message, $category = 'stay', $params = array(), $source = null, $language = null) 
{
    return Yii::t($category, $message, $params, $source, $language);
}
 
/**
 * This is the shortcut to Yii::app()->request->baseUrl
 * If the parameter is given, it will be returned and prefixed with the app baseUrl.
 */
function bu($url=null) 
{
    static $baseUrl;
    if ($baseUrl===null)
        $baseUrl=Yii::app()->getRequest()->getBaseUrl();
    return $url===null ? $baseUrl : $baseUrl.'/'.ltrim($url,'/');
}

function n_format($number, $decimals=2)
{
    if (empty($number)) return 0;

    if (strpos($number, '.')) {
        $number = remove_last_zero($number);
    }

    if (strpos($number, '.')) {
        $verguldan_keyin = explode('.', $number);
        $num_length = strlen($verguldan_keyin[1]);
    } else {
        $num_length = 0;
    }

    if ($num_length>$decimals) {
        return number_format($number, $decimals, '.', ' ');
    } else {
        return number_format($number, $num_length, '.', ' ');
    }
}

function n_format1($number, $decimals=2)
{

    if (strpos($number, '.')) {
        $number = remove_last_zero($number);
    }

    if (strpos($number, '.')) {
        $verguldan_keyin = explode('.', $number);
        $num_length = strlen($verguldan_keyin[1]);
    } else {
        $num_length = 0;
    }

    if ($num_length>$decimals) {
        return number_format($number, $decimals, '.', '');
    } else {
        return $number;
    }
}

function remove_last_zero($number)
{
    $length = strlen($number);

    $qush = false;
    $new_number = '';

    for($i=$length; $i>=0; $i--) {

        $last_sign = substr($number, $i, 1);

        if ($last_sign!=0) {
            $qush = true;
        }

        if ($qush) {
            $new_number = $last_sign.$new_number;
        }

        if (!$qush && $last_sign=='.') {

            $qush = true;
        }

    }

    return $new_number;
}
/**
 * This is the shortcut to Yii::app()->theme->baseUrl
 * If the parameter is given, it will be returned and prefixed with the app baseUrl.
 */
function thu($url=null) 
{
    static $baseUrl;
    if ($baseUrl===null)
        $baseUrl=Yii::app()->getTheme()->getBaseUrl();
    return $url===null ? $baseUrl : $baseUrl.'/'.ltrim($url,'/');
}
 
/**
 * Returns the named application parameter.
 * This is the shortcut to Yii::app()->params[$name].
 */
function param($name) 
{
    return Yii::app()->params[$name];
}

//
// returns trace
function fb($what){
  echo Yii::trace(CVarDumper::dumpAsString($what),'vardump');
}

/**
 * <pre>$var</pre>
 */
function pr($variable)
{
    echo '<pre>';print_r($variable);echo '</pre>';
}

/**
 * <pre>$var</pre>;die();
 */
function prd($variable)
{
    echo '<pre>';print_r($variable);echo '</pre>';die;
}

function pul($value, $fixed)
{
    return number_format($value, $fixed, '.', ' ');
}

function pul2($value, $fixed)
{
    return number_format($value, $fixed, ',', ' ');
}

// view da 12.04.2018 shaklida chiqarish uchu
function dateView($date)
{
    return Yii::$app->formatter->asDate($date, 'php:d.m.Y');
}

function dateViewNew($date)
{
    return Yii::$app->formatter->asDate($date, 'php:Y-m-d');
}

// bazaga saqlash uchun 2018-04-12 shaklida
function dateBase($date)
{
    return Yii::$app->formatter->asDate($date, 'php:Y-m-d');
}


// data ni vaqti bilan korsatish uchun
function datetimeView($date)
{
    $date = explode(' ',$date);
    return Yii::$app->formatter->asDate($date[0], 'php:d.m.Y').' '.$date[1];
}
/**
 * cut text and put special string to last
 */
function cut_text($string, $len, $show = '...') {

    $string = strip_tags($string);

    if (mb_strlen($string) > $len) {

        return mb_substr($string, 0, $len, 'utf8') . $show;
    } else {

        return $string;
    }
}

/**
 * returns correct russian date with month name
 * Assume $date is in d.m.Y format
 */
function russianDate($date){
    $date=explode(".", $date);
    switch ($date[1]){
        case 1: $m='января'; break;
        case 2: $m='февраля'; break;
        case 3: $m='марта'; break;
        case 4: $m='апреля'; break;
        case 5: $m='мая'; break;
        case 6: $m='июня'; break;
        case 7: $m='июля'; break;
        case 8: $m='августа'; break;
        case 9: $m='сентября'; break;
        case 10: $m='октября'; break;
        case 11: $m='ноября'; break;
        case 12: $m='декабря'; break;
    }
    return $date[0].'&nbsp;'.$m;//.'&nbsp;'.$date[2];
}

/**
 * returns correct russian date with month name
 * Assume $date is in d.m.Y format
 */
function russianDate2($date){
    $date=explode("-", $date);
    switch ($date[1]){
        case 1: $m='янв'; break;
        case 2: $m='фев'; break;
        case 3: $m='мар'; break;
        case 4: $m='апр'; break;
        case 5: $m='мая'; break;
        case 6: $m='июн'; break;
        case 7: $m='июл'; break;
        case 8: $m='авг'; break;
        case 9: $m='сент'; break;
        case 10: $m='окт'; break;
        case 11: $m='нояб'; break;
        case 12: $m='дек'; break;
    }
    return $date[2].'&nbsp;'.$m;//.'&nbsp;'.$date[2];
}

function russianMonth($month){
    switch ($month){
        case 1: $m='Январь'; break;
        case 2: $m='Февраль'; break;
        case 3: $m='Март'; break;
        case 4: $m='Апрель'; break;
        case 5: $m='Май'; break;
        case 6: $m='Июнь'; break;
        case 7: $m='Июль'; break;
        case 8: $m='Август'; break;
        case 9: $m='Сентябрь'; break;
        case 10: $m='Октябрь'; break;
        case 11: $m='Ноябрь'; break;
        case 12: $m='Декабрь'; break;
    }
    return $m;
}

function monthDate($date) {
    $date=explode("-", $date);
    $year = $date[0] % 100;
    switch ($date[1]) {
        case 1: $m='янв '; break;
        case 2: $m='фев'; break;
        case 3: $m='март'; break;
        case 4: $m='апр'; break;
        case 5: $m='май'; break;
        case 6: $m='июн'; break;
        case 7: $m='июл'; break;
        case 8: $m='авг'; break;
        case 9: $m='сен'; break;
        case 10: $m='окт'; break;
        case 11: $m='ноя'; break;
        case 12: $m='дек'; break;
    }

    return $m.' '.$year;
}

function russianMonthList(){

    $m = [
        '1' => 'январь',
        '2' => 'февраль',
        '3' => 'март',
        '4' => 'апрель',
        '5' => 'май',
        '6' => 'июнь',
        '7' => 'июль',
        '8' => 'август',
        '9' => 'сентябрь',
        '10' => 'октябрь',
        '11' => 'ноябрь',
        '12' => 'декабрь'
        ];
    return $m;
}

function mb_ucfirst($string)
{
    return mb_strtoupper(mb_substr($string, 0, 1)).mb_strtolower(mb_substr($string, 1));
}

/**
* PHP hide_email() is a PHP function to protect the E-mail address you publish on your website against bots or spiders that index or harvest E-mail addresses for sending you spam. 
* It uses a substitution cipher with a different key for every page load.
* Read more at http://www.webappers.com/2010/02/02/protect-your-email-address-with-php-hide_email/#r0vokldmqAhxqrW6.99 
*/
function hide_email($email)

{ $character_set = '+-.0123456789@ABCDEFGHIJKLMNOPQRSTUVWXYZ_abcdefghijklmnopqrstuvwxyz';

  $key = str_shuffle($character_set); $cipher_text = ''; $id = 'e'.rand(1,999999999);

  for ($i=0;$i<strlen($email);$i+=1) $cipher_text.= $key[strpos($character_set,$email[$i])];

  $script = 'var a="'.$key.'";var b=a.split("").sort().join("");var c="'.$cipher_text.'";var d="";';

  $script.= 'for(var e=0;e<c.length;e++)d+=b.charAt(a.indexOf(c.charAt(e)));';

  $script.= 'document.getElementById("'.$id.'").innerHTML="<a href=\\"mailto:"+d+"\\">"+d+"</a>"';

  $script = "eval(\"".str_replace(array("\\",'"'),array("\\\\",'\"'), $script)."\")"; 

  $script = '<script type="text/javascript">/*<![CDATA[*/'.$script.'/*]]>*/</script>';

  return '<span id="'.$id.'">[javascript protected email address]</span>'.$script;

}

/**
 * add http:// to the url if there isn't a http:// or https:// or ftp://
 */
function addhttp($url) {
    if (!preg_match("~^(?:f|ht)tps?://~i", $url)) {
        $url = "http://" . $url;
    }
    return $url;
}

/**
 * show thumb for image
 * status 1 for crop else 0
 */
function thumb($full_image_path, $thumb_width, $thumb_height, $status = 0)
{
    // get thumb folder
    $thumbFolder = Yii::getPathOfAlias('webroot').param('thumbFolder');

    $pathinfo = pathinfo($full_image_path);
    //$newFileName = $pathinfo['filename'].$thumb_width.'x'.$thumb_height.'.'.$pathinfo['extension'];
    $newFileName = $pathinfo['filename'].$thumb_width.'x'.$thumb_height.'.png';

    if (file_exists($thumbFolder.$newFileName)) {

        $image = imagecreatefrompng($thumbFolder.$newFileName);

    } else {

        $filename = $full_image_path;

        // resize it
        $obj = new MyImage();
        //set maximum width within wich the image should be resized
        $obj->max_width($thumb_width);
        // set maximum height within wich the image should be resized
        // for example size of the area in which image to be displayed
        $obj->max_height($thumb_height);
        $obj->image_path($filename);
        //call the function to resize the image
        if ($status==0) {
            $image = $obj->get_image_resize();
        } else {
            $image = $obj->get_image_crop();
        }

        // save image to file
        imagepng($image, $thumbFolder.$newFileName);

    }

    header('Content-type: image/jpeg');

    print imagejpeg($image, null, 100);

    exit;           

}


/**
 * keep file from overwriting, if file exist it renames file name until unique
 * it receives full path file name
 * returns renamed full path file name
 */
function fileOverwrite($full_file_path)
{
    $pathinfo = pathinfo($full_file_path);

    $uploadDirectory = $pathinfo['dirname'];

    $filename = $pathinfo['filename'];

    $ext = $pathinfo['extension'];

    while (file_exists($uploadDirectory .DIRECTORY_SEPARATOR. $filename . '.' . $ext)) {
        $filename .= rand(10, 999);
    }

    return $uploadDirectory .DIRECTORY_SEPARATOR. $filename . '.' . $ext;

}

/*
* email send function
*
*/
function send_mime_mail($name_from, // имя отправителя
                        $email_from, // email отправителя
                        $email_to, // email получателя
                        $subject, // тема письма
                        $body, // текст письма
                        $data_charset='UTF-8', // кодировка переданных данных
                        $send_charset='KOI8-R' // кодировка письма                        
                        ) 
{

    // if many email receivers
    if (is_array($email_to)) {
        $to = implode(", ", $email_to);
    } else {
        $to = $email_to;
    }    
  
  $subject = mime_header_encode($subject, $data_charset, $send_charset);
  $from =  mime_header_encode($name_from, $data_charset, $send_charset).' <' . $email_from . '>';
  if($data_charset != $send_charset) {
    $body = iconv($data_charset, $send_charset, $body);
  }
  
  $headers ="Content-type: text/html; charset=\"".$send_charset."\"\n";
  $headers .="From: $from\n";
  $headers .="Mime-Version: 1.0\n";

  return mail($to, $subject, $body, $headers);
}

/*
* helper for email send function
*/
function mime_header_encode($str, $data_charset, $send_charset) {
  if($data_charset != $send_charset) {
    $str = iconv($data_charset, $send_charset, $str);
  }
  return '=?' . $send_charset . '?B?' . base64_encode($str) . '?=';
}

function clearPHPMailer()
{
    Yii::app()->mailer->ClearAddresses();
    Yii::app()->mailer->ClearCCs();
    Yii::app()->mailer->ClearBCCs();
    Yii::app()->mailer->ClearReplyTos();
    Yii::app()->mailer->ClearAllRecipients();
    Yii::app()->mailer->ClearAttachments();
    Yii::app()->mailer->ClearCustomHeaders();
}

// embed images for phpmailer
function embed_images($body)
{
    // get all img tags
    preg_match_all('/<img.*?>/', $body, $matches);
    if (!isset($matches[0])) return;
    // foreach tag, create the cid and embed image
    $i = 1;
    foreach ($matches[0] as $img)
    {
        // make cid
        $id = 'img'.($i++);
        // replace image web path with local path
        preg_match('/src="(.*?)"/', $img, $m);
        if (!isset($m[1])) continue;
        $arr = parse_url($m[1]);
        if (!isset($arr['host']) || !isset($arr['path'])) continue;
        // add
        $imgPath = param('webroot').$arr['path'];
        $fileName = pathinfo($imgPath, PATHINFO_FILENAME).'.'.pathinfo($imgPath, PATHINFO_EXTENSION);
        Yii::app()->mailer->AddEmbeddedImage($imgPath, $id, $fileName);
        $body = str_replace($img, '<img alt="" src="cid:'.$id.'" style="border: none;" />', $body); 
    }
    return $body;
}    


function getSetting($name)
{
    $market = Yii::app()->session['market'];

    $criteria = new CDbCriteria;
    $criteria->condition = 'name="'.$name.'" and idMarket='.$market->id;
    $settings = getDataApi('Setting', 'GET', $criteria);
    $setting = $settings[0];

    return $setting;
}

function getDataPk($model, $id)
{
    $criteria = new CDbCriteria;
    $criteria->condition = 'id='.$id;
    $value = getDataApi($model, 'GET', $criteria);
    $result = array();
    if (!empty($value)) {
        $result = $value[0];
    }
    return $result;
}

/*
*   function for getting result from API
*   $model - model name
*   $methos - sending method, [GET, POST, PUT, DELETE]
*   $params - array() parameters to send
*/
function getDataApi($model, $method, $params = array(), $decoding = 'json')
{
    // api url
    $url = 'http://localhost/takeoneServer/index.php/api/'.$model;

    //open connection
    $ch = curl_init();
    // pr($params);

    // send header
    $header = array("X_ASCCPE_USERNAME: demo", "X_ASCCPE_PASSWORD: demo");
    curl_setopt ( $ch , CURLOPT_HTTPHEADER, $header );

    switch ($method) {
        case 'GET':
            $url = $url.'?'.http_build_query($params);
            break;

        case 'POST':
            // Send request as POST
            curl_setopt($ch, CURLOPT_POST, count($params));

            // Array of data to POST in request
            curl_setopt($ch, CURLOPT_POSTFIELDS, $params);
            break;

        case 'PUT':

            // Send request as POST
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'PUT');

            // Array of data to POST in request
            curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($params));
            break;

        case 'DELETE':
            # code...
            break;

        case 'FUNC':

            // Send request as POST
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'FUNC');

            // Array of data to POST in request
            curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($params));

            break;
        
        default:
            # code...
            break;
    }

    // URL to send request to
    curl_setopt($ch,CURLOPT_URL,$url);


    // Return the response as a string instead of outputting it to the screen
    curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);

    // Number of seconds to spend attempting to connect
    curl_setopt($ch,CURLOPT_CONNECTTIMEOUT, 4);

    //execute post
    $result = curl_exec($ch);

    // if error show it
    if(!$result) {
        echo curl_error($ch);
    }

    //close connection
    curl_close($ch);

    if ($decoding=='json') {
        return json_decode($result);
    }

}

/*
*   function for getting result from ems post
*/
function getEmsApi($url)
{

    //open connection
    $ch = curl_init();

    // $url = $url.'?'.http_build_query($params);

    // URL to send request to
    curl_setopt($ch,CURLOPT_URL,$url);

    // Return the response as a string instead of outputting it to the screen
    curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);

    // Number of seconds to spend attempting to connect
    curl_setopt($ch,CURLOPT_CONNECTTIMEOUT, 4);

    //execute post
    $result = curl_exec($ch);

    // if error show it
    if(!$result) {
        echo curl_error($ch);
    }

    //close connection
    curl_close($ch);

    // return json_decode($result);
    return $result;
}

// download file from url
function file_download_http($url, $name) {

    header("Content-Description: File Transfer"); 
    header("Content-Type: application/octet-stream"); 
    header('Content-Disposition: attachment; filename="' . $name . '"');

    readfile($url);
}

function big_file_download($file)
{
    
    if (!file_exists($file)) {

        echo $file;
        die('Bunday fayl yo`q');
    }

    header('Content-Description: File Transfer');
    header('Content-Type: application/octet-stream');
    header('Content-Disposition: attachment; filename='.basename($file));
    header('Expires: 0');
    header('Cache-Control: must-revalidate');
    header('Pragma: public');
    header('Content-Length: ' . filesize($file));
    ob_clean();
    flush();
    readfile($file);
    exit;
}

// convert date like 18.01.1982 to unix timestamp
function convertDate($date, $dot = '.')
{
    $k = 0;
    $new_date[0] = '';  // day
    $new_date[1] = '';  // month
    $new_date[2] = '';  // year
    for($i=0; $i<=strlen($date); $i++) {
        $m = substr($date,$i,1);
        if ($m==$dot) {
            $k++;
        } else {
            $new_date[$k] .= $m;
        }
    }
    $result = mktime(0, 0, 0, $new_date[1], $new_date[0], $new_date[2]);
    return $result;
}

function groupArray($array, $index)
{
    $result = [];

    foreach ($array as $value) {

        $result[$value[$index]][] = $value;
    }

    return $result;
}

function removeScriptTag($js)
{
    $js = str_replace(array("<script>", "</script>"), "", $js);
    return $js;
}

function getYiiName($str)
{
    $str = strtolower(/*preg_replace('~(?!\A)(?=[A-Z]+)~', '-', */$str);
    $str = str_replace('[', '-', $str);
    $str = str_replace(']', '', $str);

    return $str;
}

function ruslat($textcyr = null, $textlat = null) 
{
    $textcyr = str_replace("'", '`', $textcyr);
    $textlat = str_replace("'", '`', $textlat);

    $cyr = array(
    'ж',  'ч',  'щ',   'ш',  'ю',  'а', 'б', 'в', 'г', 'д', 'е', 'ё', 'з', 'и', 'й', 'к', 'л', 'м', 'н', 'о', 'п', 'р', 'с', 'т', 'у', 'ф', 'х', 'ц', 'ъ', 'ь', 'э', 'я', 'ў', 'қ', 'ғ', 'ҳ',
    'Ж',  'Ч',  'Щ',   'Ш',  'Ю',  'А', 'Б', 'В', 'Г', 'Д', 'Е', 'Ё', 'З', 'И', 'Й', 'К', 'Л', 'М', 'Н', 'О', 'П', 'Р', 'С', 'Т', 'У', 'Ф', 'Х', 'Ц', 'Ъ', 'Ь', 'Э', 'Я', 'Ў', 'Қ', 'Ғ', 'Ҳ');
    $lat = array(
    'j', 'ch', 'sht', 'sh', 'yu', 'a', 'b', 'v', 'g', 'd', 'e', 'yo', 'z', 'i', 'y', 'k', 'l', 'm', 'n', 'o', 'p', 'r', 's', 't', 'u', 'f', 'x', 'ts', '`', '`', 'e', 'ya', 'o`', 'q', 'g`', 'h',
    'J', 'Ch', 'Sht', 'Sh', 'Yu', 'A', 'B', 'V', 'G', 'D', 'E', 'Yo',  'Z', 'I', 'y', 'K', 'L', 'M', 'N', 'O', 'P', 'R', 'S', 'T', 'U', 'F', 'X', 'Ts', '`', '`', 'E', 'Ya', 'O`', 'Q', 'G`', 'H');
    if($textcyr) return str_replace($cyr, $lat, $textcyr);
    else if($textlat) return str_replace($lat, $cyr, $textlat);
    else return null;
}

function num2str($num) {
  $nul='ноль';
  $ten=array(
    array('','один','два','три','четыре','пять','шесть','семь', 'восемь','девять'),
    array('','одна','две','три','четыре','пять','шесть','семь', 'восемь','девять'),
  );
  $a20=array('десять','одиннадцать','двенадцать','тринадцать','четырнадцать' ,'пятнадцать','шестнадцать','семнадцать','восемнадцать','девятнадцать');
  $tens=array(2=>'двадцать','тридцать','сорок','пятьдесят','шестьдесят','семьдесят' ,'восемьдесят','девяносто');
  $hundred=array('','сто','двести','триста','четыреста','пятьсот','шестьсот', 'семьсот','восемьсот','девятьсот');
  $unit=array( // Units
    // array('рубль'   ,'рубля'   ,'рублей'    ,0),
//    array('цент' ,'цент' ,'цент',  1),
    array('тийин' ,'тийин' ,'тийин',  1),
    array('ТЕНГЕ'   ,'ТЕНГЕ'   ,'ТЕНГЕ'    ,0),
    array('тысяча'  ,'тысячи'  ,'тысяч'     ,1),
    array('миллион' ,'миллиона','миллионов' ,0),
    array('миллиард','милиарда','миллиардов',0),
  );
  //
  list($rub,$kop) = explode('.',sprintf("%015.2f", floatval($num)));
  $out = array();
  if (intval($rub)>0) {
    foreach(str_split($rub,3) as $uk=>$v) { // by 3 symbols
      if (!intval($v)) continue;
      $uk = sizeof($unit)-$uk-1; // unit key
      $gender = $unit[$uk][3];
      list($i1,$i2,$i3) = array_map('intval',str_split($v,1));
      // mega-logic
      $out[] = $hundred[$i1]; # 1xx-9xx
      if ($i2>1) $out[]= $tens[$i2].' '.$ten[$gender][$i3]; # 20-99
      else $out[]= $i2>0 ? $a20[$i3] : $ten[$gender][$i3]; # 10-19 | 1-9
      // units without rub & kop
      if ($uk>1) $out[]= morph($v,$unit[$uk][0],$unit[$uk][1],$unit[$uk][2]);
    } //foreach
  }
  else $out[] = $nul;
  $out[] = morph(intval($rub), $unit[1][0],$unit[1][1],$unit[1][2]); // rub
  $out[] = $kop.' '.morph($kop,$unit[0][0],$unit[0][1],$unit[0][2]); // kop
  return trim(preg_replace('/ {2,}/', ' ', join(' ',$out)));
}

function num2str_en($number) {

    $hyphen      = '-';
    $conjunction = ' and ';
    $separator   = ', ';
    $negative    = 'negative ';
    $decimal     = ' point ';
    $dictionary  = array(
        0                   => 'zero',
        1                   => 'one',
        2                   => 'two',
        3                   => 'three',
        4                   => 'four',
        5                   => 'five',
        6                   => 'six',
        7                   => 'seven',
        8                   => 'eight',
        9                   => 'nine',
        10                  => 'ten',
        11                  => 'eleven',
        12                  => 'twelve',
        13                  => 'thirteen',
        14                  => 'fourteen',
        15                  => 'fifteen',
        16                  => 'sixteen',
        17                  => 'seventeen',
        18                  => 'eighteen',
        19                  => 'nineteen',
        20                  => 'twenty',
        30                  => 'thirty',
        40                  => 'fourty',
        50                  => 'fifty',
        60                  => 'sixty',
        70                  => 'seventy',
        80                  => 'eighty',
        90                  => 'ninety',
        100                 => 'hundred',
        1000                => 'thousand',
        1000000             => 'million',
        1000000000          => 'billion',
        1000000000000       => 'trillion',
        1000000000000000    => 'quadrillion',
        1000000000000000000 => 'quintillion'
    );

    if (!is_numeric($number)) {
        return false;
    }

    if (($number >= 0 && (int) $number < 0) || (int) $number < 0 - PHP_INT_MAX) {
        // overflow
        trigger_error(
            'convert_number_to_words only accepts numbers between -' . PHP_INT_MAX . ' and ' . PHP_INT_MAX,
            E_USER_WARNING
        );
        return false;
    }

    if ($number < 0) {
        return $negative . num2str_en(abs($number));
    }

    $string = $fraction = null;

    if (strpos($number, '.') !== false) {
        list($number, $fraction) = explode('.', $number);
    }

    switch (true) {
        case $number < 21:
            $string = $dictionary[$number];
            break;
        case $number < 100:
            $tens   = ((int) ($number / 10)) * 10;
            $units  = $number % 10;
            $string = $dictionary[$tens];
            if ($units) {
                $string .= $hyphen . $dictionary[$units];
            }
            break;
        case $number < 1000:
            $hundreds  = $number / 100;
            $remainder = $number % 100;
            $string = $dictionary[$hundreds] . ' ' . $dictionary[100];
            if ($remainder) {
                $string .= $conjunction . num2str_en($remainder);
            }
            break;
        default:
            $baseUnit = pow(1000, floor(log($number, 1000)));
            $numBaseUnits = (int) ($number / $baseUnit);
            $remainder = $number % $baseUnit;
            $string = num2str_en($numBaseUnits) . ' ' . $dictionary[$baseUnit];
            if ($remainder) {
                $string .= $remainder < 100 ? $conjunction : $separator;
                $string .= num2str_en($remainder);
            }
            break;
    }

    if (null !== $fraction && is_numeric($fraction)) {
        $string .= $decimal;
        $words = array();
        foreach (str_split((string) $fraction) as $number) {
            $words[] = $dictionary[$number];
        }
        $string .= implode(' ', $words);
    }

    return $string;
}

function morph($n, $f1, $f2, $f5) {
  $n = abs(intval($n)) % 100;
  if ($n>10 && $n<20) return $f5;
  $n = $n % 10;
  if ($n>1 && $n<5) return $f2;
  if ($n==1) return $f1;
  return $f5;
}

function correctFilenaName($str)
{
    $str = str_replace('"', '', $str);
    $str = str_replace("'", '', $str);
    $str = str_replace("`", '', $str);
    $str = str_replace(",", '', $str);

    return $str;
}

function amountImage($text,$fileName) {
    $im = @imagecreate(75, 50) or die("Cannot Initialize new GD image stream");
    $background_color = imagecolorallocate($im, 255, 255, 255);
    $text_color = imagecolorallocate($im, 0x00,0x00,0x00);
    $font = 'fonts/times.ttf';
    imagettftext($im, 13, 0, 0, 30, $text_color, $font, $text);
    header('Content-Type: image/png');
     imagepng($im,"pdf/doc/".$fileName.".png");
    imagedestroy($im);
}

function costImage($text,$fileName) {
    $im = @imagecreate(115, 50) or die("Cannot Initialize new GD image stream");
    $background_color = imagecolorallocate($im, 255, 255, 255);
    $text_color = imagecolorallocate($im, 0x00,0x00,0x00);
    $font = 'fonts/times.ttf';
    imagettftext($im, 13, 0, 0, 30, $text_color, $font, $text);
    header('Content-Type: image/png');
     imagepng($im,"pdf/doc/".$fileName.".png");
    imagedestroy($im);
}
function foizImage($text,$fileName) {
    $im = @imagecreate(50, 20) or die("Cannot Initialize new GD image stream");
    $background_color = imagecolorallocate($im, 255, 255, 255);
    $text_color = imagecolorallocate($im, 0x00,0x00,0x00);
    $font = 'fonts/times.ttf';
    header('Content-Type: image/png');
    imagettftext($im, 13, 0, 6, 20, $text_color, $font, $text);
    imagepng($im, "pdf/doc/".$fileName.".png");
    imagedestroy($im);
}

function shortYear($date)
{
    return Yii::$app->formatter->asDate($date, 'php:d.m.y');
}

function getLastYearQuartleMonth()
{   
    $lastMfirstDay = date("Y-m-d", mktime(0, 0, 0, date("m", strtotime("-1 month")), 1, date("Y", strtotime("-1 month"))));
    $lastMlastDay = date('Y-m-t',strtotime('last month'));
    
    $lastYearStart = ((int)date("Y") - 1).'-'.'01'.'-'.'01';
    $lastYearEnd = ((int)date("Y") - 1).'-'.'12'.'-'.'31';
    
    $startQuater = (new DateTime('first day of -' . ((date('n') % 3) + 2) . ' month midnight'))->format('Y-m-d');
    $endQuater = (new DateTime('last day of -' . (date('n') % 3) . ' month midnight'))->format('Y-m-d');

    return array(
            'lastMfirstDay' => $lastMfirstDay,
            'lastMlastDay'  => $lastMlastDay,
            'lastYearStart' => $lastYearStart,
            'lastYearEnd'   => $lastYearEnd,
            'startQuater'   => $startQuater,
            'endQuater'     => $endQuater
    );
}

function checkQuarter($month) {
    switch ($month) {
        case 1: case 2: case 3:
            $quarter = '&#8544';
        break;
        case 4: case 5: case 6:
            $quarter = '&#8545;';
        break;
        case 7: case 8: case 9:
            $quarter = '&#8546;';
        break;
        case 10: case 11: case 12:
            $quarter = '&#8547;';
        break;
    }
    return $quarter;
}

function quarterRim($quarter) {
    switch ($quarter) {
        case 1:
        $quarter = '&#8544';
        break;
        case 2:
        $quarter = '&#8545;';
        break;
        case 3:
        $quarter = '&#8546;';
        break;
        case 4:
        $quarter = '&#8547;';
        break;
    }
    return $quarter;
}

function dateTimeDiff($dt1, $dt2)
{
    $tz = new DateTimeZone('UTC');
    $dt1 = new DateTime($dt1, $tz);
    $dt2 = new DateTime($dt2, $tz);
    $interval = $dt1->diff($dt2)->format('%m oy, %d kun, %h soat, %i minut, %s sekund');
    return $interval;
}

function sql_in($array, $prefix)
{
    $params = [];
    $in = ' in (';
    foreach ($array as $key => $value) {
        $in .= ":${prefix}_${key}, ";
        $params = array_merge($params, [":${prefix}_${key}" => $value]);
    }
    $sql = substr($in, 0, -2) . ') ';
    return array($sql, $params);
}