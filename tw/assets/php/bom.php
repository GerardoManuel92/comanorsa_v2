<?php
 
//Strips BOM from all php files in the current dir and subdirs
$files = stripUtf8BomFromFiles("showbom/Dashboard.php", "*.php");
 
/**
* Remove BOM from a single file
*
* @param string $filename
* @return bool
*/
function stripUtf8BomFromFile($filename) {
    $bom = pack('CCC', 0xEF, 0xBB, 0xBF);
    $file = @fopen($filename, "r");
    $hasBOM = fread($file, 3) === $bom;
    fclose($file);
    if ($hasBOM) {
        $contents = file_get_contents($filename);
        file_put_contents($filename, substr($contents, 3));
    }
    return $hasBOM;
}
/**
* Removes BOM from all matching files in a directory
*
* @param string $path Path to search in
* @param string $exclude Dirs to exclude from search
* @param string $file_pattern File name pattern, e.g. *.php
* @param bool $recursive Whether to do a recursive search
* @param bool $verbose Whether to print fixed files
* @return array Path names of all fixed files
*/
function stripUtf8BomFromFiles($path, $file_pattern = "*", $exclude = ".|..",
$recursive = true, $verbose = true) {
    if (false !== $file_pattern && !function_exists('fnmatch')) {
       die(
            'Required function fnmatch is not available. Please upgrade to ' .
            'PHP >= 5.3.0 on Windows or disable pattern matching by ' .
            'passing in false.'
       );
    }
    $path = rtrim($path, "/")."/";
    $dir = opendir($path);
    $exclude_array = explode("|", $exclude);
    $files = array();
    while (false !== ($filename = readdir($dir))) {
        if (!in_array(strtolower($filename), $exclude_array)) {
            if (is_dir($path.$filename."/") && $recursive) {
                $result[] = stripUtf8BomFromFiles(
                    $path.$filename."/",
                    $file_pattern,
                    $exclude,
                    $recursive,
                    $verbose
                );
            } elseif (false === $file_pattern || fnmatch($file_pattern, $filename)) {
                if (stripUtf8BomFromFile($path.$filename)) {
                    if ($verbose) { printf("fixed %s\n", $path.$filename); }
                    $files[] = $path.$filename;
                }
            }
        }
     }
     return $files;
 
}

echo "actualizado";
?>