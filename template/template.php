<?php
    function loadfile($filename){
        $rand = "worm".time().''.rand(100,999);
        if(!$filename){
            echo 'filename不能是空的;';
            return false;
        }
        if(!file_exists ( $filename )){
            echo ( $filename . '文件不存在，或者载入错误！');
            return false;
        }
        $handle = fopen($filename, "r");
        $contents = fread($handle, filesize($filename));
        fclose($handle);
        
        $style = namecc("style",$contents);
        //去掉空格和换行符
        $style = str_replace(PHP_EOL, '', $style);
        $style = preg_replace("/\}/",'} #'.$rand.' ',$style);

        $template = namecc("template",$contents);

        $style = str_replace("page","#".$rand,$style);
        $template = worm_replace("template","div",$rand,$template);

        echo $style;
        echo $template;
    }
    function namecc($name,$contents){
        preg_match("/<*".$name.".*?>(.*?)<*\/".$name.".*?>/is", $contents, $match1);
        return trim($match1[0]);
    }
    function worm_replace($str,$str1,$rand,$strs){
        $strs = preg_replace("/<*\/".$str.".*?>/",'</'.$str1.'>',$strs);
        return preg_replace("/<*".$str.".*?>/",'<'.$str1.' id="'.$rand.'">',$strs);
    }
?>