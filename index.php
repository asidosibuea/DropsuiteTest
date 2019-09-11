<?php

class FileContentIterator
{

    /**
     * Count on how many files inside a path with the SAME content.
     * @param String path --> directory that will be scanned
     * return value : String content and number of content
     * 
     */
    public static function maxDuplicatedContent($path)
    {
        $arrData = self::getArrayFileFromDir($path);

        return array_search(max(self::getDuplicatedItemsNumber(self::iterateToArray($arrData))), self::getDuplicatedItemsNumber(self::iterateToArray($arrData)))
                .' '. max(self::getDuplicatedItemsNumber(self::iterateToArray($arrData)));
    }

    /**
     * List files and directories inside the given path 
     * @param Strind $dir --> directory that will be scanned
     * return value : array of files and directory
     */
    public static function getArrayFileFromDir($dir)
    {
        $data = array();

        $files = array_diff(scandir($dir), array('..','.'));

        foreach ($files as $file) {

            if(is_dir($dir.DIRECTORY_SEPARATOR. $file)){
                array_push($data, self::getArrayFileFromDir($dir. DIRECTORY_SEPARATOR. $file));

            } else{
                if($file !== '.DS_Store' && $file !== 'index.php'){
                    array_push($data, file($dir. DIRECTORY_SEPARATOR. $file));
                }
            }
            
        }

        return $data;
    }


    /**
     * Iterate the list file and directory. Copy the iterator into an array
     * @param array $data --> data that will be iterated
     * return value : array
     */
    public static function iterateToArray(array $data = [])
    {
        $iterator = new RecursiveIteratorIterator(new RecursiveArrayIterator($data));
        $list = iterator_to_array($iterator,false);

        return $list;
    }

    /**
     * Counts all the values of an array
     * @param array $data
     * return value : associative array of values from $data as keys and the count as value.
     */
    public static function getDuplicatedItemsNumber(array $data = [])
    {
        return array_count_values($data);
    }
}


echo FileContentIterator::maxDuplicatedContent('./');
