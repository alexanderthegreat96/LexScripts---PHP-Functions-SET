<?php

/**
 * @author alexanderdth
 * @copyright 2019
 * LexSystems Framework Functions Set
 * Syntax PHP 7.2
 */

//Mysql connection params
//a great number of functions utilize the $con variable as a global
//to connect to a specific database
//and execute operations

$con = mysqli_connect("host","user","pass","db_name");


if(!$con)
{
    die("Unable to connect to mysql server. There is something wrong with the credetials provided".mysqli_error($con));
}
//Simple but very effective pagination script
//usage index.php?get=mypage
//define $path = 'somewhere/something';
//DO NOT ADD a trailing slash
//define $_GET variable as in ?get=something
//this case $get="get";
function get_page($path,$get)
{
    global $con;

    
    if (!isset($_GET["$get"]) && empty($_GET["$get"])) {
   
    
        include "$path/default.php";


    } 
    else {
         $page = $_GET["$get"];
         
        if (file_exists($path."/".$page.".php")) {
            include $path."/".$page.".php";
        } else {
            echo "<div class='card'><div class='card-body'><center><h3>404: Not found inside system!</h3></center></div></div>";
        }
    }
}
//cleans up string and removes any unwanted chars
function clean($string)
{
    $string = str_replace(' ', '', $string); // Replaces all spaces with hyphens.

    return preg_replace('/[^A-Za-z0-9\-]/', '', $string); // Removes special chars.
}

//reverses date for european time and date format
function reverse_date($input)
{

    $date = date_create_from_format('Y-m-d', $input);
    return date_format($date, 'd m Y');
}
//redirects user to url
function redirect($url)
{
    if (!headers_sent()) {
        header('Location: ' . $url);
        exit;
    } else {
        echo '<script type="text/javascript">';
        echo 'window.location.href="' . $url . '";';
        echo '</script>';
        echo '<noscript>';
        echo '<meta http-equiv="refresh" content="0;url=' . $url . '" />';
        echo '</noscript>';
        exit;
    }
}

//formating bytes to mb to gb and so on
    function formatSizeUnits($bytes)
    {
        if ($bytes >= 1073741824)
        {
            $bytes = number_format($bytes / 1073741824, 2) . ' GB';
        }
        elseif ($bytes >= 1048576)
        {
            $bytes = number_format($bytes / 1048576, 2) . ' MB';
        }
        elseif ($bytes >= 1024)
        {
            $bytes = number_format($bytes / 1024, 2) . ' KB';
        }
        elseif ($bytes > 1)
        {
            $bytes = $bytes . ' bytes';
        }
        elseif ($bytes == 1)
        {
            $bytes = $bytes . ' byte';
        }
        else
        {
            $bytes = '0 bytes';
        }

        return $bytes;
}
//groups array by given key.
//manages by arrays into sub arrays
function group_by($key, $array) {
    $result = array();

    foreach($array as $val) {
        if(array_key_exists($key, $val)){
            $result[$val[$key]][] = $val;
        }else{
            $result[""][] = $val;
        }
    }

    return $result;
}
//generate slug for seo - used for products and cats

function slug($text)
{
  // replace non letter or digits by -
  $text = preg_replace('~[^\pL\d]+~u', '-', $text);

  // transliterate
  $text = iconv('utf-8', 'us-ascii//TRANSLIT', $text);

  // remove unwanted characters
  $text = preg_replace('~[^-\w]+~', '', $text);

  // trim
  $text = trim($text, '-');

  // remove duplicate -
  $text = preg_replace('~-+~', '-', $text);

  // lowercase
  $text = strtolower($text);

  if (empty($text)) {
    return 'n-a';
  }

  return remove_accents($text);
}

//remove diacritics
//and other nifty characters
function remove_accents( $string ) {
    if ( !preg_match('/[\x80-\xff]/', $string) )
        return $string;

    if (seems_utf8($string)) {
        $chars = array(
            // Decompositions for Latin-1 Supplement
            chr(194).chr(170) => 'a', chr(194).chr(186) => 'o',
            chr(195).chr(128) => 'A', chr(195).chr(129) => 'A',
            chr(195).chr(130) => 'A', chr(195).chr(131) => 'A',
            chr(195).chr(132) => 'A', chr(195).chr(133) => 'A',
            chr(195).chr(134) => 'AE',chr(195).chr(135) => 'C',
            chr(195).chr(136) => 'E', chr(195).chr(137) => 'E',
            chr(195).chr(138) => 'E', chr(195).chr(139) => 'E',
            chr(195).chr(140) => 'I', chr(195).chr(141) => 'I',
            chr(195).chr(142) => 'I', chr(195).chr(143) => 'I',
            chr(195).chr(144) => 'D', chr(195).chr(145) => 'N',
            chr(195).chr(146) => 'O', chr(195).chr(147) => 'O',
            chr(195).chr(148) => 'O', chr(195).chr(149) => 'O',
            chr(195).chr(150) => 'O', chr(195).chr(153) => 'U',
            chr(195).chr(154) => 'U', chr(195).chr(155) => 'U',
            chr(195).chr(156) => 'U', chr(195).chr(157) => 'Y',
            chr(195).chr(158) => 'TH',chr(195).chr(159) => 's',
            chr(195).chr(160) => 'a', chr(195).chr(161) => 'a',
            chr(195).chr(162) => 'a', chr(195).chr(163) => 'a',
            chr(195).chr(164) => 'a', chr(195).chr(165) => 'a',
            chr(195).chr(166) => 'ae',chr(195).chr(167) => 'c',
            chr(195).chr(168) => 'e', chr(195).chr(169) => 'e',
            chr(195).chr(170) => 'e', chr(195).chr(171) => 'e',
            chr(195).chr(172) => 'i', chr(195).chr(173) => 'i',
            chr(195).chr(174) => 'i', chr(195).chr(175) => 'i',
            chr(195).chr(176) => 'd', chr(195).chr(177) => 'n',
            chr(195).chr(178) => 'o', chr(195).chr(179) => 'o',
            chr(195).chr(180) => 'o', chr(195).chr(181) => 'o',
            chr(195).chr(182) => 'o', chr(195).chr(184) => 'o',
            chr(195).chr(185) => 'u', chr(195).chr(186) => 'u',
            chr(195).chr(187) => 'u', chr(195).chr(188) => 'u',
            chr(195).chr(189) => 'y', chr(195).chr(190) => 'th',
            chr(195).chr(191) => 'y', chr(195).chr(152) => 'O',
            // Decompositions for Latin Extended-A
            chr(196).chr(128) => 'A', chr(196).chr(129) => 'a',
            chr(196).chr(130) => 'A', chr(196).chr(131) => 'a',
            chr(196).chr(132) => 'A', chr(196).chr(133) => 'a',
            chr(196).chr(134) => 'C', chr(196).chr(135) => 'c',
            chr(196).chr(136) => 'C', chr(196).chr(137) => 'c',
            chr(196).chr(138) => 'C', chr(196).chr(139) => 'c',
            chr(196).chr(140) => 'C', chr(196).chr(141) => 'c',
            chr(196).chr(142) => 'D', chr(196).chr(143) => 'd',
            chr(196).chr(144) => 'D', chr(196).chr(145) => 'd',
            chr(196).chr(146) => 'E', chr(196).chr(147) => 'e',
            chr(196).chr(148) => 'E', chr(196).chr(149) => 'e',
            chr(196).chr(150) => 'E', chr(196).chr(151) => 'e',
            chr(196).chr(152) => 'E', chr(196).chr(153) => 'e',
            chr(196).chr(154) => 'E', chr(196).chr(155) => 'e',
            chr(196).chr(156) => 'G', chr(196).chr(157) => 'g',
            chr(196).chr(158) => 'G', chr(196).chr(159) => 'g',
            chr(196).chr(160) => 'G', chr(196).chr(161) => 'g',
            chr(196).chr(162) => 'G', chr(196).chr(163) => 'g',
            chr(196).chr(164) => 'H', chr(196).chr(165) => 'h',
            chr(196).chr(166) => 'H', chr(196).chr(167) => 'h',
            chr(196).chr(168) => 'I', chr(196).chr(169) => 'i',
            chr(196).chr(170) => 'I', chr(196).chr(171) => 'i',
            chr(196).chr(172) => 'I', chr(196).chr(173) => 'i',
            chr(196).chr(174) => 'I', chr(196).chr(175) => 'i',
            chr(196).chr(176) => 'I', chr(196).chr(177) => 'i',
            chr(196).chr(178) => 'IJ',chr(196).chr(179) => 'ij',
            chr(196).chr(180) => 'J', chr(196).chr(181) => 'j',
            chr(196).chr(182) => 'K', chr(196).chr(183) => 'k',
            chr(196).chr(184) => 'k', chr(196).chr(185) => 'L',
            chr(196).chr(186) => 'l', chr(196).chr(187) => 'L',
            chr(196).chr(188) => 'l', chr(196).chr(189) => 'L',
            chr(196).chr(190) => 'l', chr(196).chr(191) => 'L',
            chr(197).chr(128) => 'l', chr(197).chr(129) => 'L',
            chr(197).chr(130) => 'l', chr(197).chr(131) => 'N',
            chr(197).chr(132) => 'n', chr(197).chr(133) => 'N',
            chr(197).chr(134) => 'n', chr(197).chr(135) => 'N',
            chr(197).chr(136) => 'n', chr(197).chr(137) => 'N',
            chr(197).chr(138) => 'n', chr(197).chr(139) => 'N',
            chr(197).chr(140) => 'O', chr(197).chr(141) => 'o',
            chr(197).chr(142) => 'O', chr(197).chr(143) => 'o',
            chr(197).chr(144) => 'O', chr(197).chr(145) => 'o',
            chr(197).chr(146) => 'OE',chr(197).chr(147) => 'oe',
            chr(197).chr(148) => 'R',chr(197).chr(149) => 'r',
            chr(197).chr(150) => 'R',chr(197).chr(151) => 'r',
            chr(197).chr(152) => 'R',chr(197).chr(153) => 'r',
            chr(197).chr(154) => 'S',chr(197).chr(155) => 's',
            chr(197).chr(156) => 'S',chr(197).chr(157) => 's',
            chr(197).chr(158) => 'S',chr(197).chr(159) => 's',
            chr(197).chr(160) => 'S', chr(197).chr(161) => 's',
            chr(197).chr(162) => 'T', chr(197).chr(163) => 't',
            chr(197).chr(164) => 'T', chr(197).chr(165) => 't',
            chr(197).chr(166) => 'T', chr(197).chr(167) => 't',
            chr(197).chr(168) => 'U', chr(197).chr(169) => 'u',
            chr(197).chr(170) => 'U', chr(197).chr(171) => 'u',
            chr(197).chr(172) => 'U', chr(197).chr(173) => 'u',
            chr(197).chr(174) => 'U', chr(197).chr(175) => 'u',
            chr(197).chr(176) => 'U', chr(197).chr(177) => 'u',
            chr(197).chr(178) => 'U', chr(197).chr(179) => 'u',
            chr(197).chr(180) => 'W', chr(197).chr(181) => 'w',
            chr(197).chr(182) => 'Y', chr(197).chr(183) => 'y',
            chr(197).chr(184) => 'Y', chr(197).chr(185) => 'Z',
            chr(197).chr(186) => 'z', chr(197).chr(187) => 'Z',
            chr(197).chr(188) => 'z', chr(197).chr(189) => 'Z',
            chr(197).chr(190) => 'z', chr(197).chr(191) => 's',
            // Decompositions for Latin Extended-B
            chr(200).chr(152) => 'S', chr(200).chr(153) => 's',
            chr(200).chr(154) => 'T', chr(200).chr(155) => 't',
            // Euro Sign
            chr(226).chr(130).chr(172) => 'E',
            // GBP (Pound) Sign
            chr(194).chr(163) => '',
            // Vowels with diacritic (Vietnamese)
            // unmarked
            chr(198).chr(160) => 'O', chr(198).chr(161) => 'o',
            chr(198).chr(175) => 'U', chr(198).chr(176) => 'u',
            // grave accent
            chr(225).chr(186).chr(166) => 'A', chr(225).chr(186).chr(167) => 'a',
            chr(225).chr(186).chr(176) => 'A', chr(225).chr(186).chr(177) => 'a',
            chr(225).chr(187).chr(128) => 'E', chr(225).chr(187).chr(129) => 'e',
            chr(225).chr(187).chr(146) => 'O', chr(225).chr(187).chr(147) => 'o',
            chr(225).chr(187).chr(156) => 'O', chr(225).chr(187).chr(157) => 'o',
            chr(225).chr(187).chr(170) => 'U', chr(225).chr(187).chr(171) => 'u',
            chr(225).chr(187).chr(178) => 'Y', chr(225).chr(187).chr(179) => 'y',
            // hook
            chr(225).chr(186).chr(162) => 'A', chr(225).chr(186).chr(163) => 'a',
            chr(225).chr(186).chr(168) => 'A', chr(225).chr(186).chr(169) => 'a',
            chr(225).chr(186).chr(178) => 'A', chr(225).chr(186).chr(179) => 'a',
            chr(225).chr(186).chr(186) => 'E', chr(225).chr(186).chr(187) => 'e',
            chr(225).chr(187).chr(130) => 'E', chr(225).chr(187).chr(131) => 'e',
            chr(225).chr(187).chr(136) => 'I', chr(225).chr(187).chr(137) => 'i',
            chr(225).chr(187).chr(142) => 'O', chr(225).chr(187).chr(143) => 'o',
            chr(225).chr(187).chr(148) => 'O', chr(225).chr(187).chr(149) => 'o',
            chr(225).chr(187).chr(158) => 'O', chr(225).chr(187).chr(159) => 'o',
            chr(225).chr(187).chr(166) => 'U', chr(225).chr(187).chr(167) => 'u',
            chr(225).chr(187).chr(172) => 'U', chr(225).chr(187).chr(173) => 'u',
            chr(225).chr(187).chr(182) => 'Y', chr(225).chr(187).chr(183) => 'y',
            // tilde
            chr(225).chr(186).chr(170) => 'A', chr(225).chr(186).chr(171) => 'a',
            chr(225).chr(186).chr(180) => 'A', chr(225).chr(186).chr(181) => 'a',
            chr(225).chr(186).chr(188) => 'E', chr(225).chr(186).chr(189) => 'e',
            chr(225).chr(187).chr(132) => 'E', chr(225).chr(187).chr(133) => 'e',
            chr(225).chr(187).chr(150) => 'O', chr(225).chr(187).chr(151) => 'o',
            chr(225).chr(187).chr(160) => 'O', chr(225).chr(187).chr(161) => 'o',
            chr(225).chr(187).chr(174) => 'U', chr(225).chr(187).chr(175) => 'u',
            chr(225).chr(187).chr(184) => 'Y', chr(225).chr(187).chr(185) => 'y',
            // acute accent
            chr(225).chr(186).chr(164) => 'A', chr(225).chr(186).chr(165) => 'a',
            chr(225).chr(186).chr(174) => 'A', chr(225).chr(186).chr(175) => 'a',
            chr(225).chr(186).chr(190) => 'E', chr(225).chr(186).chr(191) => 'e',
            chr(225).chr(187).chr(144) => 'O', chr(225).chr(187).chr(145) => 'o',
            chr(225).chr(187).chr(154) => 'O', chr(225).chr(187).chr(155) => 'o',
            chr(225).chr(187).chr(168) => 'U', chr(225).chr(187).chr(169) => 'u',
            // dot below
            chr(225).chr(186).chr(160) => 'A', chr(225).chr(186).chr(161) => 'a',
            chr(225).chr(186).chr(172) => 'A', chr(225).chr(186).chr(173) => 'a',
            chr(225).chr(186).chr(182) => 'A', chr(225).chr(186).chr(183) => 'a',
            chr(225).chr(186).chr(184) => 'E', chr(225).chr(186).chr(185) => 'e',
            chr(225).chr(187).chr(134) => 'E', chr(225).chr(187).chr(135) => 'e',
            chr(225).chr(187).chr(138) => 'I', chr(225).chr(187).chr(139) => 'i',
            chr(225).chr(187).chr(140) => 'O', chr(225).chr(187).chr(141) => 'o',
            chr(225).chr(187).chr(152) => 'O', chr(225).chr(187).chr(153) => 'o',
            chr(225).chr(187).chr(162) => 'O', chr(225).chr(187).chr(163) => 'o',
            chr(225).chr(187).chr(164) => 'U', chr(225).chr(187).chr(165) => 'u',
            chr(225).chr(187).chr(176) => 'U', chr(225).chr(187).chr(177) => 'u',
            chr(225).chr(187).chr(180) => 'Y', chr(225).chr(187).chr(181) => 'y',
            // Vowels with diacritic (Chinese, Hanyu Pinyin)
            chr(201).chr(145) => 'a',
            // macron
            chr(199).chr(149) => 'U', chr(199).chr(150) => 'u',
            // acute accent
            chr(199).chr(151) => 'U', chr(199).chr(152) => 'u',
            // caron
            chr(199).chr(141) => 'A', chr(199).chr(142) => 'a',
            chr(199).chr(143) => 'I', chr(199).chr(144) => 'i',
            chr(199).chr(145) => 'O', chr(199).chr(146) => 'o',
            chr(199).chr(147) => 'U', chr(199).chr(148) => 'u',
            chr(199).chr(153) => 'U', chr(199).chr(154) => 'u',
            // grave accent
            chr(199).chr(155) => 'U', chr(199).chr(156) => 'u',
        );

        $string = strtr($string, $chars);
    } else {
        $chars = array();
        // Assume ISO-8859-1 if not UTF-8
        $chars['in'] = chr(128).chr(131).chr(138).chr(142).chr(154).chr(158)
            .chr(159).chr(162).chr(165).chr(181).chr(192).chr(193).chr(194)
            .chr(195).chr(196).chr(197).chr(199).chr(200).chr(201).chr(202)
            .chr(203).chr(204).chr(205).chr(206).chr(207).chr(209).chr(210)
            .chr(211).chr(212).chr(213).chr(214).chr(216).chr(217).chr(218)
            .chr(219).chr(220).chr(221).chr(224).chr(225).chr(226).chr(227)
            .chr(228).chr(229).chr(231).chr(232).chr(233).chr(234).chr(235)
            .chr(236).chr(237).chr(238).chr(239).chr(241).chr(242).chr(243)
            .chr(244).chr(245).chr(246).chr(248).chr(249).chr(250).chr(251)
            .chr(252).chr(253).chr(255);

        $chars['out'] = "EfSZszYcYuAAAAAACEEEEIIIINOOOOOOUUUUYaaaaaaceeeeiiiinoooooouuuuyy";

        $string = strtr($string, $chars['in'], $chars['out']);
        $double_chars = array();
        $double_chars['in'] = array(chr(140), chr(156), chr(198), chr(208), chr(222), chr(223), chr(230), chr(240), chr(254));
        $double_chars['out'] = array('OE', 'oe', 'AE', 'DH', 'TH', 'ss', 'ae', 'dh', 'th');
        $string = str_replace($double_chars['in'], $double_chars['out'], $string);
    }

    return $string;
}

function mbstring_binary_safe_encoding( $reset = false ) {
    static $encodings = array();
    static $overloaded = null;

    if ( is_null( $overloaded ) )
        $overloaded = function_exists( 'mb_internal_encoding' ) && ( ini_get( 'mbstring.func_overload' ) & 2 );

    if ( false === $overloaded )
        return;

    if ( ! $reset ) {
        $encoding = mb_internal_encoding();
        array_push( $encodings, $encoding );
        mb_internal_encoding( 'ISO-8859-1' );
    }

    if ( $reset && $encodings ) {
        $encoding = array_pop( $encodings );
        mb_internal_encoding( $encoding );
    }
}

function reset_mbstring_encoding() {
    mbstring_binary_safe_encoding( true );
}

function seems_utf8( $str ) {
    mbstring_binary_safe_encoding();
    $length = strlen($str);
    reset_mbstring_encoding();
    for ($i=0; $i < $length; $i++) {
        $c = ord($str[$i]);
        if ($c < 0x80) $n = 0; // 0bbbbbbb
        elseif (($c & 0xE0) == 0xC0) $n=1; // 110bbbbb
        elseif (($c & 0xF0) == 0xE0) $n=2; // 1110bbbb
        elseif (($c & 0xF8) == 0xF0) $n=3; // 11110bbb
        elseif (($c & 0xFC) == 0xF8) $n=4; // 111110bb
        elseif (($c & 0xFE) == 0xFC) $n=5; // 1111110b
        else return false; // Does not match any model
        for ($j=0; $j<$n; $j++) { // n bytes matching 10bbbbbb follow ?
            if ((++$i == $length) || ((ord($str[$i]) & 0xC0) != 0x80))
                return false;
        }
    }
    return true;
}

//generate voucher codes for products
//as well as random strings
function generateCouponCode($length = 8) {
  $chars = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890';
  $ret = '';
  for($i = 0; $i < $length; ++$i) {
    $random = str_shuffle($chars);
    $ret .= $random[0];
  }
  return $ret;
}
//gets file extension
function getExtension($str)
{
         $i = strrpos($str,".");
         if (!$i) { return ""; }
         $l = strlen($str) - $i;
         $ext = substr($str,$i+1,$l);
         return $ext;
}
//shortens title or phrase
function short_title($string)
{
    if (strlen($string) >= 20) {
    return substr($string, 0, 20). " ... " . substr($string, -5);
}
else {
   return $string;
}
}
//Generates random token for authentication puposes
//as well as generating random strins
//confirmation codes for email
//etc
function getToken($length)
{
    $token = "";
    $codeAlphabet = "ABCDEFGHIJKLMNOPQRSTUVWXYZ";
    $codeAlphabet.= "abcdefghijklmnopqrstuvwxyz";
    $codeAlphabet.= "0123456789";
    $max = strlen($codeAlphabet); // edited

    for ($i=0; $i < $length; $i++) {
        $token .= $codeAlphabet[crypto_rand_secure(0, $max-1)];
    }

    return $token;
}
//checks for valid media extentions 
function valid_ext($string)
{
    $ext = array("jpg","jpeg","zip","rar","tar","tar.gz","mp3","mp4","flac","pdf","psd","apk");
    
    if(in_array($string,$ext))
    {
        return true;
    }
    else
    {
        return false;
    }
}

//generate html table from array
//part of dump_array
function html_table($data)
{
	
    $rows = array();
    foreach ($data as $key=>$val) {
		
        $cells = array();
		if(is_array($val))
		{
			
			$val = html_table($val);
		}
		else
			
			{
				$val = $val;
			}
        $cells[] = "<td style='border: 1px solid black;'><b>".ucfirst($key)."</b></td><td style='border: 1px solid black;'>$val</td>";
        $rows[] = "<tr >" . implode('', $cells) . "</tr>";
	
  }
    return "<br><table style='background-color: #f9f9f9;font-size: 14px; width: 50%; border-collapse:collapse; margin: auto;'>" . implode('', $rows) . "</table>
	<hr>
	";
}
//check if the array contains more arrays
function look_for_array(array $test_var) {
  foreach ($test_var as $key => $el) {
    if (is_array($el)) {
      return $key;
    }
  }
  return null;
}

//Dump array
//generates html output from array structures
//for debugging puposes only
function dump_array(array $data)
{
	if(is_null(look_for_array($data)))
	{
		echo "<center><h4>Dataset Dump</h4></center>";
		echo html_table($data);
		
	}
	else
	{
		$i = 1;
		foreach ($data as $res)
		{
			echo "<center><h4>Dataset Dump $i</h4></center>";
			echo html_table($res);
			$i++;
		}
	}
		
}
//Query Generator
//allows for advanced dynamic query generation
//useful for search enginges and data sorting form
//it works with $_GET params
function gen_query($params,$table_name)
{
       
       //defining sort order
       if(isset($params["sort"]))
       {
        
       
       foreach($params["sort"] as $sort)
       {
            $get_field = $sort["GET"];
            $sql_field = $sort["sql_field"];
            $sql_order = $sort["order_sql"];
            
            if(isset($_GET["sort"]))
            {
            if($_GET["sort"] == $get_field)
            {
                $sql_sort = "ORDER by $sql_field $sql_order";
                
            }
            }
            else
            {
                $sql_sort = "";
            }
            
       }
       }
       else
       {
        $sql_sort = null;
       }
       
       //define criteria order as in get criteria from something
       if(isset($params["criteria"]))
       {
        
       
       foreach($params["criteria"] as $c)
       {
        $c_field = $c["GET"];
        $c_sql = $c["sql_field"];
           
           if(array_key_exists($c_field, $_GET))
           {
            $criteria_input = $_GET["$c_field"];
            if($criteria_input !="")
            {
            $criteria[] = "$c_sql = '$criteria_input'";
            }
           }
          
       }
        }
        else
        {
            $criteria[] = null;
        }
        
        //define regexp criteria
        if(isset($params["regexp"]))
        { 
       foreach($params["regexp"] as $r)
       {
            $r_field = $r["GET"];
            $r_sql = $r["sql_field"];
            
           if(array_key_exists($r_field, $_GET))
           {
            $regexp_input = $_GET["$r_field"];
           
            if($regexp_input !="")
            {
               
                $regexp_input = explode(" ",$regexp_input);
                foreach($regexp_input as $rg)
                {
                    $exp[] = clean($rg);
                }
                
                $regexp_input = $exp;
                
                $regexp_input  = array_filter($regexp_input);
              
                if(count($regexp_input) > 1)
                {
                    $regexp_input = implode("|",$regexp_input);
                    echo $regexp_input;
                    //$regexp_input = clean($regexp_input);
                    $regexp_input = rtrim($regexp_input,"|");
                   
                }
                else
                {
                    $regexp_input = $regexp_input[0];
                }
               
              
               
                
            $regexp[] = "$r_sql REGEXP '$regexp_input'";
            }
           }
      }
       }
       else
       {
        $regexp[] = null;
       }
       
       //define between params
       if(isset($params["between"]))
       {
            foreach($params["between"] as $b)
            {
                
                $b_from = $b["GET"];
                $b_to = $b["GET2"];
                $b_sql = $b["sql_field"];
                
                $from = $_GET["$b_from"];
                $to = $_GET["$b_from"];
                
                if(array_key_exists($b_from,$_GET) && array_key_exists($b_to,$_GET))
                {
                    $between[] = "$b_sql BETWEEN '$from' AND '$to'";
                }
            }
            
          
       }
       else
       {
        $between[] = null;
       }
                                             
        //check for empty criteria array
      if(!is_null($criteria))
      {
        $criteria = implode(' AND ', $criteria);
      }
      else
      {
        $criteria = null;
      }
      
      //check for empty regexp array
      if(!is_null($regexp))
      {
         $regexp = implode (' OR ', $regexp);
      }
      else
      {
        $regexp = null;
      }
      
      //check for empty between array
      if(!is_null($between))
      {
         $between = implode(' AND ',$between);
      }
      else
      {
        $between  = null;
      }

        // return data
      $data = array($criteria,$regexp,$between);
      $data = array_filter($data);
      $data = implode(" AND ",$data);
      
      if(!empty($data))
      {
        $sql = "SELECT * FROM $table_name WHERE $data $sql_sort";
      }
      else
      {
        $sql = "SELECT * FROM $table_name ";
      }
      
     
     return $sql;
      
      
}

//insert sql data
//make sure you create array of columns
// make sure you create array of values 
//both arrays must be the same in size and lenght
 function PushData($table, $columns, $values)
{
    //declare con global(conection params))
    global $con;
    
  $column_count = count($columns);
  $overwriteArr = array_fill(0, $column_count, '?');

  for ($i = 0; $i < sizeof($columns); $i++)
  {
    $columns[$i] = trim($columns[$i]);
    $columns[$i] = '`' . $columns[$i] . '`';
  }

  $query = "INSERT INTO {$table} (" . implode(',', $columns) . ") VALUES (" . implode(',', $overwriteArr) . ")";

  foreach ($values as $value)
  {
    $value = trim($value);
    $value = mysqli_real_escape_string($con, $value);
    $value = '"' . $value . '"';
    $query = preg_replace('/\?/', $value, $query, 1);
  }
  $result = mysqli_query($con, $query);
  
  if($result == true)
  {
        return array("result" => "true","query_id" => mysqli_insert_id($con));
  }
  else
  {
        return array("result" => "false","error" => mysqli_error($con));
  }
}

//checks ammount of rows from table
function check_rows($table, $column, $value)
{
    global $con;
    
    $num_rows = mysqli_query($con, "SELECT $column FROM $table WHERE $column='".addslashes($value)."'");
    $num = mysqli_num_rows($num_rows);
    
    return $num;
}
//Mysql Database export tool
//$name = db name
//usage  Export_Database($host,$user,$pass,$name,  $tables=array('users','data'), $backup_name='my_db_backup' , $local=false);
//
function Export_Database($host,$user,$pass,$name,  $tables=false, $backup_name=false , $local=false)
{
        $mysqli = new mysqli($host,$user,$pass,$name); 
        $mysqli->select_db($name); 
        $mysqli->query("SET NAMES 'utf8'");

        $queryTables    = $mysqli->query('SHOW TABLES'); 
        while($row = $queryTables->fetch_row()) 
        { 
            $target_tables[] = $row[0]; 
        }   
        if($tables !== false) 
        { 
            $target_tables = array_intersect( $target_tables, $tables); 
        }
        foreach($target_tables as $table)
        {
            $result         =   $mysqli->query('SELECT * FROM '.$table);  
            $fields_amount  =   $result->field_count;  
            $rows_num=$mysqli->affected_rows;     
            $res            =   $mysqli->query('SHOW CREATE TABLE '.$table); 
            $TableMLine     =   $res->fetch_row();
            $content        = (!isset($content) ?  '' : $content) . "\n\n".$TableMLine[1].";\n\n";

            for ($i = 0, $st_counter = 0; $i < $fields_amount;   $i++, $st_counter=0) 
            {
                while($row = $result->fetch_row())  
                { //when started (and every after 100 command cycle):
                    if ($st_counter%100 == 0 || $st_counter == 0 )  
                    {
                            $content .= "\nINSERT INTO ".$table." VALUES";
                    }
                    $content .= "\n(";
                    for($j=0; $j<$fields_amount; $j++)  
                    { 
                        $row[$j] = str_replace("\n","\\n", addslashes($row[$j]) ); 
                        if (isset($row[$j]))
                        {
                            $content .= '"'.$row[$j].'"' ; 
                        }
                        else 
                        {   
                            $content .= '""';
                        }     
                        if ($j<($fields_amount-1))
                        {
                                $content.= ',';
                        }      
                    }
                    $content .=")";
                    //every after 100 command cycle [or at last line] ....p.s. but should be inserted 1 cycle eariler
                    if ( (($st_counter+1)%100==0 && $st_counter!=0) || $st_counter+1==$rows_num) 
                    {   
                        $content .= ";";
                    } 
                    else 
                    {
                        $content .= ",";
                    } 
                    $st_counter=$st_counter+1;
                }
            } $content .="\n\n\n";
        }
        $backup_name = $backup_name ? $backup_name : $name."___(".date('H-i-s')."_".date('d-m-Y').")__rand".rand(1,11111111).".sql";
        //$backup_name = $backup_name ? $backup_name : $name.".sql";
        if($local == true)
        {
            $my_file = "$backup_name";
            $handle = fopen($my_file, 'w') or die('Cannot open file:  '.$my_file);
            $data = $content;
            $do = fwrite($handle, $data);
            if($do)
            {
                echo "Done exporting the data! <hr><a href='./$my_file'>Download</a>";
            }
        }
        else
        {
        header('Content-Type: application/octet-stream');   
        header("Content-Transfer-Encoding: Binary"); 
        header("Content-disposition: attachment; filename=\"".$backup_name."\"");  
        echo $content; exit;
        }
       
    }
?>