<?php
    $q = $_REQUEST["q"];
    if(strpos($q, "dailybruin.com")==false)
    {
        echo "Please enter a Daily Bruin URL";
    }
    else{
        $html = file_get_contents($q);
        //Get author name
        $start = strpos($html, 'rel="author">') + 13;
        $end = strpos($html, '</a></h4>');
        $difference = $end - $start;
        $author = 'BY '.substr($html, $start, $difference);
        //Get author position
        $start = strpos($html, '<div class="author-position">');
        if($start == false)
        {
            $position = "No position found";
        }
        else
        {
            $start = $start + 30;
            $end = strpos($html, '</div>', $start);
            $difference = $end - $start;
            $position = substr($html, $start, $difference);
        }
        //Get image URL
        $start = strpos($html, 'src="http://dailybruin.com/images');
        $end = strpos($html, '"', $start + 5) +1;
         $difference = $end - $start;
        $imgsrc = substr($html, $start, $difference);
        $author = strtoupper($author);
        //Get image caption
        $start = strpos($html, '<p class="db-image-caption text-left">') + 38;
        $end = strpos($html, '</p>', $start);
        $difference = $end - $start;
        $caption = substr($html, $start, $difference);
        $captionlen = strlen($caption);
        $start = strpos($caption, '(');
        $photocredit = substr($caption, $start, $captionlen-$start);
        $photocredit = strtr($photocredit, array('(' => '', ')' => ''));
        $caption = preg_replace("/\([^)]+\)/","",$caption);
        //Get post content
        $start = strpos($html, '<div class="db-post-content">') + 29;
        $end = strpos($html, '<!-- Simple Share Buttons');
        $difference = $end - $start;
        $content = substr($html, $start, $difference);
        
    // $isolatehtml = preg_replace('#\s*/\(<DOCTYPE).*\(')
    //echo $difference;
        echo $author.$position.'<img '.$imgsrc.'/>'.$caption.$photocredit.$content;
    }
?>