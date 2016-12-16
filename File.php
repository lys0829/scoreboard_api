<?php
function file_read($path)
{
    //global $_E;
    $file = fopen($path, 'r');
    if ($file === false) {
        //LOG::msg(Level::Warning, "cannot open the file $path");

        return false;
    } else {
        $data = '';
        //$data=fpassthru($file);
        //echo "<p>".$data;
        while ($buffer = fread($file, 40)) {
            $data = $data.$buffer;
            //echo "<p> buffer=".$buffer." ";
            //echo "     data=".$data;
        }
        fclose($file);

        return $data;
    }
}

function file_create($path, $txt)
{
    //global $_E;
    $file = fopen($path, 'w+');
    if ($file === false) {
        //LOG::msg(Level::Warning, "cannot open the file $path");
        //echo "file creat error! <p>";
        return false;
    } else {
        fwrite($file, $txt);
    }
    fclose($file);
}

function read_csv($path){
    $file = fopen($path,'r');
    $data = [];
    $i=0;
    while($res=fgetcsv($file)){
        $data[$i] = $res;
        //echo $res;
        $i++;
    }
    fclose($file);
    return $data;
}
