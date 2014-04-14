<?
##############################################################################
# Initial content
##############################################################################

header("Content-Type: application/rss+xml");
echo <<<END
<?xml version="1.0" encoding="UTF-8"?>
<?xml-stylesheet type="text/xsl" media="screen"
  href="/~d/styles/rss2enclosuresfull.xsl"?><?xml-stylesheet type="text/css"
  media="screen"
  href="feed.css"?>
END;
?>

<?
##############################################################################
# Channel (main feed data)
##############################################################################
?>

<rss xmlns:media="http://search.yahoo.com/mrss/"
  xmlns:itunes="http://www.itunes.com/dtds/podcast-1.0.dtd"
  version="2.0">

  <channel>

    <title><?= $feed_title ?></title>
    <link>http://player.fm/home</link>
    <description>It's been said this is the most sublime feed any human has ever beared witness to. Who am I to argue?</description>
    <language>en-us</language>
    <lastBuildDate><?= pubDate(0) ?></lastBuildDate>
    <pubDate><?= pubDate(0) ?></pubDate>
    <ttl>600</ttl>
    <atom10:link xmlns:atom10="http://www.w3.org/2005/Atom" rel="self" type="application/rss+xml" href="<?= self_url() ?>" />
    <media:copyright>(c) Nuvomondo Ltd</media:copyright>
    <media:thumbnail url="<?= image(-1) ?>" />
    <media:keywords><?= keywords(-1) ?></media:keywords>
    <media:category scheme="http://www.itunes.com/dtds/podcast-1.0.dtd">Society &amp; Culture</media:category>
<? if ($feed_img) { ?>
    <img src="<?= image(-1) ?>">
<? } ?>
<? if ($feed_image) { ?>
    <image>
      <url><?= image(-1) ?></url>
    </image>
<? } ?>
<? if ($itunes ) { ?>
    <itunes:author>Stephen J. Dubner and Sooty the Teddy Bear</itunes:author>
    <itunes:explicit>no</itunes:explicit>
    <itunes:image href="<?= image(-1) ?>" />
    <itunes:keywords>comedy, drama, tokyo, politics</itunes:keywords>
    <itunes:subtitle>Really quite an astonishing contribution to humanity and the finer arts</itunes:subtitle>
    <itunes:category text="Society &amp; Culture" /><? } ?>

    <? for ($index = 1; $index <= 5; $index++) { ?>
<?
##############################################################################
# Item
##############################################################################
?>
  <!-- Item <?= $index ?> -->

      <item>
        <title><?= $title_prefix ?><?= ucfirst($title = phrase($index, true)) ?></title>
        <link>http://<?= $_SERVER['HTTP_HOST'] ?>/dynamic/<?= guid($index) ?></link>
        <description><?= $description_prefix ?>Comparing <?= phrase($index) ?> to <?= phrase($index+1) ?></description>
        <pubDate><?= pubDate($index) ?></pubDate>
        <language>en-us</language>
        <guid isPermaLink="false">http://<?= $_SERVER['HTTP_HOST'] ?>/<?= guid($index) ?></guid>
        <dc:creator xmlns:dc="http://purl.org/dc/elements/1.1/">Humphrey B. Bear</dc:creator>
        <media:content url="<?= mp3($index) ?>" type="audio/mpeg" />
        <ttl>600</ttl>
        <enclosure url="<?= mp3($title) ?>" type="audio/mpeg" />
<? if ($itunes ) { ?>
        <itunes:explicit><?= $explicit_string ?></itunes:explicit>
        <itunes:subtitle>My reflections</itunes:subtitle>
        <itunes:author>Humphrey B. Bear</itunes:author>
        <itunes:summary>About <?= $title ?></itunes:summary>
        <itunes:keywords><?= keywords($index) ?></itunes:keywords>
<? } ?>
      </item>
    <? } ?>

    <copyright>(c) Nuvomondo Ltd</copyright>
    <media:credit role="author">Humphrey B. Bear</media:credit>
    <media:rating>nonadult</media:rating>

  </channel>
</rss>
