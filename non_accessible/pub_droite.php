<?php
$pub_droite= '<div class="pub"><script type="text/javascript"><!--
google_ad_client = "ca-pub-1565720051377675";
/* Pub droite */
google_ad_slot = "5033095056";
google_ad_width = 120;
google_ad_height = 600;
//-->
</script>
<script type="text/javascript"
src="http://pagead2.googlesyndication.com/pagead/show_ads.js">
</script>';
if(!isset($index) AND !isset($_GET['p']))
{
	echo $pub_droite;
	echo '<br /><center>Publicité</center>';
	echo '</div>';
}
?>
