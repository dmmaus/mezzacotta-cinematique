<?php

require_once('../md5rand.php');

$atword = "";

function punctuate($line)
{
    $reps = array(
        "   " => " ",
        "  " => " ",
        " ." => ".",
        " ," => ",",
        " '" => "'",
        " !" => "!",
        " ?" => "?",
        " :" => ":",
        "- " => "-",
        " _" => "",
        '>_ ' => '>',
        " a a" => " an a",
        " a e" => " an e",
        " a o" => " an o",
        " a u" => " an u",
        " a i" => " an i",
        " a A" => " an A",
        " a E" => " an E",
        " a O" => " an O",
        " a U" => " an U",
        " a I" => " an I",
        " A A" => " An A",
        " A E" => " An E",
        " A O" => " An O",
        " A U" => " An U",
        " A I" => " An I",
        " a the" => " the",
        " the the " => " the ",
        " The The " => " The ",
        "?." => "?",
        " )" => ")",
        "( " => "(",
        " +" => "-",
        "+ " => "-",
        "+-" => "+ ",
        "<br/> " => "<br/>"
    );
    
    $lowercases = array(
        " A " => " a ",
        " An " => " an ",
        " By " => " by ",
        " In " => " in ",
        " Of " => " of ",
        " On " => " on ",
        " Or " => " or ",
        " To " => " to ",
        " And " => " and ",
        " The " => " the "
    );
    
    foreach ($reps as $search => $replace)
        $line = str_replace($search, $replace, $line);
    
    $line = ltrim($line);
    
    foreach ($lowercases as $search => $replace)
        $line = str_replace($search, $replace, $line);
    
    $sentences = explode(". ", $line);
    foreach ($sentences as &$sentence)
        $sentence = ucfirst($sentence);
    $line = implode(". ", $sentences);
    
    $sentences = explode("? ", $line);
    foreach ($sentences as &$sentence)
        $sentence = ucfirst($sentence);
    $line = implode("? ", $sentences);
    
    $sentences = explode("! ", $line);
    foreach ($sentences as &$sentence)
        $sentence = ucfirst($sentence);
    $line = implode("! ", $sentences);
    
    return $line;
}

function Title($r=null)
{
    if ($r === null)
        $r = new MD5Rand();

    return punctuate(" " . randomline($r, "title", False, False));
}

function Cast($r=null)
{
    if ($r === null)
        $r = new MD5Rand();

    return punctuate(" " . randomline($r, "cast", False, False));
}

function Rating($r=null)
{
    if ($r === null)
        $r = new MD5Rand();

    return punctuate(" " . randomline($r, "rating", False, False)) . ", " . ($r->range(80)+80) . " mins";
}

function Tagline($r=null)
{
    if ($r === null)
        $r = new MD5Rand();

    return punctuate(" " . randomline($r, "basemovie", False, False));
}

function randomline($r, $filename, $plural, $cap)
{
    global $atword;
    $capitalise = False;

    $file_flags = FILE_IGNORE_NEW_LINES + FILE_SKIP_EMPTY_LINES;
    if (file_exists("vocabulary/" . $filename . '.txt'))
        $lines = file("vocabulary/" . $filename . '.txt', $file_flags);
    else
    {
        return "No such file: " . "vocabulary/" . $filename . '.txt';
    }
    
    if (substr($lines[0], 0, 1) == "#")
    {
        # comment, remove first line of $lines
        array_shift($lines);
    }
    
    if ($lines[0] == "&")
    {
        # set capital and remove first line of $lines
        $capitalise = True;
        array_shift($lines);
    }
    
    # pick a random line
    $line = $r->choice($lines);
    
    $story = "";
    $words = explode(" ", $line);
    foreach ($words as $word)
    {
        if ($word == "@")
        {
            $word = $atword;
            $atword = "";
        }
        elseif (strpos($word, "@") !== False)
        {
            $atword = substr($word, 1);
            $word = "";
        }
    
        $pos = strpos($word, "|");
        if ($pos !== False)
        {
            if (!$plural)
                $word = substr($word, 0, $pos);
            else
                $word = substr($word, $pos + 1);
        }
        
        $pos = strpos($word, "$");
        if ($pos !== False)
        {
            if ($pos == 0)
                $chance = 10;
            else
                $chance = substr($word, 0, $pos) + 0;
            if ($chance > $r->next_float()*10)
                #$story .= "(1 " . substr($word, $pos + 1) . ")";
                $story .= randomline($r, substr($word, $pos + 1), False, $capitalise);
        }
        elseif (strpos($word, "*") === 0)
            #$story .= "(2 " . substr($word, 1) . ")";
            $story .= randomline($r, substr($word, 1), True, $capitalise);
        else
        {
            #if ($capitalise)
            #{
            #    echo "<!--pow!-->";
            #    $word = ucfirst($word);
            #}
            $story .= $word . " ";
        }
    }
    
    if ($capitalise)
        $story = ucwords($story);
    
    return $story;
}

?>
