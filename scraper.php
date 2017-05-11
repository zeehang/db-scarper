<!--<!DOCTYPE html>
<html>
    <head>
        <link rel="stylesheet" href="scraper.css" type="text/css"/>
        <link href="https://fonts.googleapis.com/css?family=Karla|Montserrat:400,600,700" rel="stylesheet">
        <script
        src="https://code.jquery.com/jquery-3.2.1.min.js"
        integrity="sha256-hwg4gsxgFZhOsEEamdOYGBf13FyQuiTwlAQgxVSNgt4="
        crossorigin="anonymous"></script>
    </head>
    <body>-->
<?php
    //setting empty variable values
    $author = $position = $imgsrc = $caption = $photocredit = $content = $urltodisplay = $email = $twitter = $tagline = $lastnae = "";
    $URL = $_REQUEST["URL"];
    $html = file_get_contents($URL);
    
    $start = strpos($html, 'rel="author">') + 13;
    $end = strpos($html, '</a></h4>');
    $difference = $end - $start;
    $author = 'BY '.substr($html, $start, $difference);
    $start = strrpos($author, ' ');
    $lastname = substr($author, $start);
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
    $content = str_replace("</p>", "<br>", $content);
    $content = strip_tags($content, '<em></em><br>');
    $content = preg_replace("#\s*\[.+\]<br>\s*#U", "", $content);
    $content = str_replace("<br />", "", $content);
    //Get lastname for tagline - as well as email or twitter
    $start = strpos($html, '<a class="author-email-inside" href="mailto:');
    if($start == false)
    {
        $email = 'PLACEHOLDER@dailybruin.com';
    }
    else
    {
        $start = $start + 44;
        $end = strpos($html, '"', $start);
        $email = substr($html, $start, ($end - $start));
    }
    $start = strpos($html, '<a class="twitter-follow-button" data-show-count="false');
    if($start == false)
    {
        $twitter = '@PLACEHOLDER';
    }
    else
    {
        $end = strpos($html, "</a>", $start);
        $twitter = substr($html, $start, ($end-$start));
        $twitter = strip_tags($twitter);
        $twitter = trim($twitter);
       // $twitter = $twitter.'.';
    }
// $isolatehtml = preg_replace('#\s*/\(<DOCTYPE).*\(')
//echo $difference;
    $todisplay = <<<EOD

    <div id="post-text">
        <p>
            $author
            <br>
            $position
            <br>
            $content
            Email $lastname at $email or tweet $twitter.
        </p>
    </div>
    <div id="post-caption">
        <img id="post-image" $imgsrc/>
        <div class="caption-credit-wrapper">
            $photocredit
            <br>
            $caption
        </div>
    </div>


EOD;
    echo $todisplay;
?>
        <!--<div class="header-container">
            <h1 id="title">Scraper</h1>
            <form  method="post" id="submission" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
                <input type="text" id="field1" name="URL" placeholder="Daily Bruin URL" value="<?php $urltodisplay ?>">
                <input type="submit" id="submit-button" value="Scrape!">
                <script src="scraper.js"></script>
            </form>
        </div>
        <h1 style="color: black">Output:</h1>
        <?php
        echo $urltodisplay;
        echo $author;
        echo $content;
        ?>
    </body>
</html>-->