<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of util
 *
 * @author nickkaye
 */
class util {

    /**
     * 
     * double explode
     * @param $delimiter
     * @param $data
     */
    public function doubleExplode($delimiter, $data) {
        $_OUT = array();
        foreach (explode($delimiter, $data) as $one) {
            $_OUT[$one] = $one;
        }
    }

    /**
     * 
     * proper list, ala:  One, Two, Three, and Four.
     * @param array $items
     */
    public function properList($items) {
        $out = "";
        for ($i = 0; $i < count($items); $i++) {
            if ($i == 0) {
                // first
                $out .= $items[$i];
            } elseif ($i == count($items) - 1) {
                // last
                $out .= " and " . $items[$i];
            } else {
                // in between
                $out .= ", " . $items[$i];
            }
        }
        return $out;
    }

    /**
     * 
     * complex merge
     * @param array $A
     * @param array $B
     */
    function complexMerge($A, $B) {
        return array_merge_recursive($A, $B);
    }

    /**
     *   isAssoc 
     *   
     * @param array $array
     */
    function isAssoc($array) {
        return (is_array($array) && (0 !== count(array_diff_key($array, array_keys(array_keys($array)))) || count($array) == 0));
    }

    /**
     * 
     * add spaces to beginning until length met
     * @param $src
     * @param $len
     */
    function prespaceToLength($src, $len) {
        $out = $src;
        $add = max(0, ($len - strlen($src)));
        for ($i = 0; $i < $add; $i++) {
            $out = " " . $out;
        }
        return $out;
    }

    /**
     * 
     * safe $_POST[$var] else $_GET[$var] else $default
     * @param $var
     * @param $default
     */
    function requestVar($var, $default = null) {
        return Util::POST($var, Util::GET($var,$default));
    }

    /**
     * 
     * safe $_POST[$var] else $default
     * @param $var
     * @param $default
     */
    function POST($var, $default = null) {
        return isset($_POST[$var]) ? $_POST[$var] : $default;
    }

    /**
     * 
     * safe $_GET[$var] else $default
     * @param $var
     * @param $default
     */
    function GET($var, $default = null) {
        return isset($_GET[$var]) ? $_GET[$var] : $default;
    }

    /** removeIllegalChars
     * 
     * @param $_IN
     */
    function removeIllegalChars($_IN) {
        return preg_replace("/([\x80-\xFF])/", "", $_IN);
    }

    /** convertFancyQuotes
     * 
     * @param $_IN
     */
    function convertFancyQuotes($_IN) {
        return str_replace(array(chr(145), chr(146), chr(147), chr(148), chr(151), chr(130), chr(132), chr(133)), array("'", "'", '"', '"', '-', ",", ",,", "..."), $_IN);
    }

    /**
     * 
     * safe $_FILES[]
     * @param $var
     * @param $default
     */
    function FILES($var, $default = null) {
        return isset($_FILES[$var]) ? $_FILES[$var] : $default;
    }

    /**
     * removeNull
     * @param array
     * @return array without null values or their keys
     */
    function removeNull($_IN) {
        $_OUT = array();
        foreach ($_IN as $key => $value)
            if ($value !== null)
                $_OUT[$key] = $value;
        return $_OUT;
    }

    /**
     * 
     * keys to strings
     * @param object $_IN associative array
     * @return array $_OUT straight array of the keys
     */
    function keysToStrings($_IN) {
        $_OUT = array();
        foreach ($_IN as $key => $value) {
            array_push($_OUT, $key);
        }
        return $_OUT;
    }

    /**
     * 
     * add a value to a csv
     * @param $csv
     * @param $val
     */
    function csv_push(&$csv, $val) {
        if ($csv == null)
            $csv = $val;
        else if (strlen(ltrim(rtrim($csv))) == 0)
            $csv = $val;
        else
            $csv .= "," . $val;
    }

    /**
     *
     * get key within arr if set, else return def
     * @param type $arr
     * @param type $key
     * @param type $def
     * @return type 
     */
    function getIfSet(&$arr, $key, $def=null) {
        return isset($arr[$key]) ? $arr[$key] : $def;
    }

    /**
     *   getIfSetDeep
     * 
     * Used in stacks to test for the deep existence of a variable in an array without throwing errors
     * 
     * @param array $arr
     * @param mixed $val
     */
    function getIfSetDeep($arr, $key, $def=null) {
        if ($arr == null || $key == null || $arr == $def || $key == $def)
            return $def;

        if (is_array($key))
            if (count($key) < 2)
                if (isset($key[0]))
                    $key = $key[0];

        if (is_array($key)) {
            if (isset($arr[$key[0]]))
                return self::getIfSetDeep($arr[array_shift($key)], array_shift($key));
        } else {
            if (isset($arr[$key]))
                return $arr[$key];
            else
                return $def;
        }
    }

    /**
     * download image from url and return it as a standardized image object
     * @param type $url
     * @return type 
     */
    public function downloadImageFromUrl($url) {
        // get bonafide temp file name
        $temp_filename = tempnam(Yii::app()->basePath . "/protected/runtime/", "dl_");
        chmod($temp_filename, 0755);

        // grab cURL
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_BINARYTRANSFER, 1);
        $rawdata = curl_exec($ch);
        curl_close($ch);

        // push raw data to filesystem
        $fp = fopen($temp_filename, 'wb');
        fwrite($fp, $rawdata);
        fclose($fp);

        // check file size
        $file_size = filesize($temp_filename);
        if (!($file_size > 0))
            return false;

        // use imagemagick to get information on downloaded image
        $image = Yii::app()->image->load($temp_filename);

        // return standard image-upload style array:
        return array(
            "name" => "image." . $image->ext,
            "type" => $image->mime,
            "tmp_name" => $temp_filename,
            "error" => "UPLOAD_ERR_OK",
            "size" => $file_size,
        );
    }

    /**
     * URL Linkify with a single REGEX
     * 
     * Credit goes to: Jeff Roberson
     * http://jmrware.com/articles/2010/linkifyurl/linkify.php  
     * 
     * @param string $text
     * @return string all links converted to html A tags 
     */
    public function urlLinkify($text) {
        $url_pattern = '/# Rev:20100913_0900 github.com\/jmrware\/LinkifyURL
# Match http & ftp URL that is not already linkified.
  # Alternative 1: URL delimited by (parentheses).
  (\()                     # $1  "(" start delimiter.
  ((?:ht|f)tps?:\/\/[a-z0-9\-._~!$&\'()*+,;=:\/?#[\]@%]+)  # $2: URL.
  (\))                     # $3: ")" end delimiter.
| # Alternative 2: URL delimited by [square brackets].
  (\[)                     # $4: "[" start delimiter.
  ((?:ht|f)tps?:\/\/[a-z0-9\-._~!$&\'()*+,;=:\/?#[\]@%]+)  # $5: URL.
  (\])                     # $6: "]" end delimiter.
| # Alternative 3: URL delimited by {curly braces}.
  (\{)                     # $7: "{" start delimiter.
  ((?:ht|f)tps?:\/\/[a-z0-9\-._~!$&\'()*+,;=:\/?#[\]@%]+)  # $8: URL.
  (\})                     # $9: "}" end delimiter.
| # Alternative 4: URL delimited by <angle brackets>.
  (<|&(?:lt|\#60|\#x3c);)  # $10: "<" start delimiter (or HTML entity).
  ((?:ht|f)tps?:\/\/[a-z0-9\-._~!$&\'()*+,;=:\/?#[\]@%]+)  # $11: URL.
  (>|&(?:gt|\#62|\#x3e);)  # $12: ">" end delimiter (or HTML entity).
| # Alternative 5: URL not delimited by (), [], {} or <>.
  (                        # $13: Prefix proving URL not already linked.
    (?: ^                  # Can be a beginning of line or string, or
    | [^=\s\'"\]]          # a non-"=", non-quote, non-"]", followed by
    ) \s*[\'"]?            # optional whitespace and optional quote;
  | [^=\s]\s+              # or... a non-equals sign followed by whitespace.
  )                        # End $13. Non-prelinkified-proof prefix.
  ( \b                     # $14: Other non-delimited URL.
    (?:ht|f)tps?:\/\/      # Required literal http, https, ftp or ftps prefix.
    [a-z0-9\-._~!$\'()*+,;=:\/?#[\]@%]+ # All URI chars except "&" (normal*).
    (?:                    # Either on a "&" or at the end of URI.
      (?!                  # Allow a "&" char only if not start of an...
        &(?:gt|\#0*62|\#x0*3e);                  # HTML ">" entity, or
      | &(?:amp|apos|quot|\#0*3[49]|\#x0*2[27]); # a [&\'"] entity if
        [.!&\',:?;]?        # followed by optional punctuation then
        (?:[^a-z0-9\-._~!$&\'()*+,;=:\/?#[\]@%]|$)  # a non-URI char or EOS.
      ) &                  # If neg-assertion true, match "&" (special).
      [a-z0-9\-._~!$\'()*+,;=:\/?#[\]@%]* # More non-& URI chars (normal*).
    )*                     # Unroll-the-loop (special normal*)*.
    [a-z0-9\-_~$()*+=\/#[\]@%]  # Last char can\'t be [.!&\',;:?]
  )                        # End $14. Other non-delimited URL.
/imx';
        $url_replace = '$1$4$7$10$13<a href="$2$5$8$11$14">$2$5$8$11$14</a>$3$6$9$12';
        return preg_replace($url_pattern, $url_replace);
    }

    /**
     * returns the input variable print_r expanded with line breaks and spaces converted for html
     * @param type $var 
     */
    public function debugHtml($var) {
        return str_replace(array("\n", " "), array("<br/>", "&nbsp;"), print_r($var, true));
    }

}

?>
