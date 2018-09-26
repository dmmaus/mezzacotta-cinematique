<?php include('../header_pre.php'); ?>
<title>mezzacotta Cinématique</title>
<style type="text/css">
.main
{
    width: 800px;
    padding-top: 0px;
    margin-left: auto;
    margin-right: auto;
    text-align: left;
    font-family: Arial;
}

.marquee
{
    margin-top: 5px;
    margin-bottom: 5px;
    text-align: center;
}

.title
{
	width:600px;
    margin-top: 15px;
    margin-bottom: 15px;
    font-size: 20pt;
    font-style: bold;
    color:white
}

.cast
{
	width:600px;
    margin-top: 15px;
    margin-bottom: 5px;
    font-size: 11pt;
    font-style: bold;
    color:#FAFAD2
}

.rating
{
    margin-top: 15px;
    margin-bottom: 15px;
    font-size: 8pt;
    color:indianred
}

.tagline
{
	width:600px;
    margin-top: 15px;
    margin-bottom: 15px;
    font-size: 12pt;
    font-style: italic;
    color:white
}

.epilogue
{
    margin-top: 40px;
    color:white
    font-size: 11pt;
}

.leftside
{
    float:left
    width:100px;
    margin-right:10px;
    background-color:#FF00FF
}

.break
{
    font-size: 20pt;
    font-style: normal;
}
</style>
<link rel="shortcut icon" href="http://www.mezzacotta.net/wp/wp-content/themes/mezzacotta/favicon.ico" />
<link rel="stylesheet" href="http://www.mezzacotta.net/wp/wp-content/themes/mezzacotta/style.css" type="text/css" media="screen" />

<style type="text/css" media="screen">
	#page { background: #000000; border: none; }
</style>
</head>

<body>
<div id="page">

<div class="leftside">
</div>

<br class="clear" />

<div class="marquee">
<a href="/cinematique/"><img src="./Graphics/marquee_cinematique.png" width="451" height="281" border="0" alt="Mezzacotta Cinematique"></a>
</div>

<div class="main">
<?php
require_once('mezzaplex.php');

for ($i = 0; $i < 5; ++$i)
{
    if ($i != 0)
    {
        ?>
        <div class="marquee"><img src="./Graphics/separator.png"></div>
        <?php
    }
    ?>
    <div class="title"><?= Title(); ?></div>
    <div class="cast"><?= Cast(); ?></div>
    <div class="rating"><?= Rating(); ?></div>
    <div class="tagline"><?= Tagline(); ?></div>
    <?php
}
?>
<div class="marquee">
<a href="/cinematique/"><img src="./Graphics/coming_soon.png" width="387" height="85" border="0" alt="Coming Soon"></a>
</div>

<div class="epilogue">
Bought to you by <a href="/">mezzacotta</a><br>
<a rel="license" href="http://creativecommons.org/licenses/by-nc-sa/3.0/"><img alt="Creative Commons License" style="border-width:0" src="http://i.creativecommons.org/l/by-nc-sa/3.0/80x15.png" width="80" height="15" /></a><br />This work is licensed under a <a rel="license" href="http://creativecommons.org/licenses/by-nc-sa/3.0/">Creative Commons Attribution-Noncommercial-Share Alike 3.0 Unported Licence</a> by The Comic Irregulars. <i>d&#109;m&#64;d&#97;nger&#109;o&#117;se&#46;n&#101;t</i><br />
<i>Hosted by: <a href="http://www.dreamhost.com/rewards.cgi?dmmaus">DreamHost</a></i>
</div>

</div> <!-- id=main -->
<br class="clear">
</div> <!-- id=page -->

</body>
</html>
