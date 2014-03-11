<h1>表現</h1>
<?
if(isset($src)){
?>
	<iframe width="723" height="756" src="<?php echo $src;?>"></iframe>
<?}?>

<h1>メディアファイル</h1>
<?php
	foreach ($sources as $source) {
			if($source['type']=='video/x-flv'){
				$name = $source['filename'];
				?>
					<h1>Media<?echo $source['id'];?></h1>
					<object classid="" codebase=" " width="352" height=" 308" align="middle">
				    <param name="FlashVars" value="">
				    <param name="movie" value="">
				    <param name="quality" value="high">
				    <param name="allowScriptAccess" value="always"><param name="wmode" value="transparent"><param name="base" value="http://d.violet.vn/plugins/flash/">
				    <embed src="http://localhost/ITJ/app/webroot/files/flvPlayer.swf" quality="high" width="352" height="308"align="middle" type="application/x-shockwave-flash" allowscriptaccess="always" wmode="transparent" base=""  flashvars="file=http://localhost/ITJ/app/webroot/uploads/<?echo $source['filename'];?>">
					</object>
				<?php
			}elseif(in_array($source['type'], array('image/gif','image/png','image/jpg','image/jpeg'))){
				?>
					<h2>Image <? echo $source['id'];?></h2>
					<img src="http://localhost/ITJ/app/webroot/uploads/<?echo $source['filename'];?>">
				<?
			}
		}
?>
