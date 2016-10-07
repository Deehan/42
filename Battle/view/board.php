<?php
foreach($p1ships as $k=>$ship) { ?>
	<div class="ship p1" id="<?='p'.$ship['p'].'s'.$k?>" style="width:<?=$ship['w']?>px;height:<?=$ship['h']?>px;top:<?=$ship['y']?>px;left:<?=$ship['x']?>px;"></div>
<?php } ?>


<table cellpadding="0" cellspacing="0">
<?php for($x=0;$x<100;$x++) {	?>
	<tr>
		<?php for($y=0;$y<150;$y++) {	?>
			<td></td>
		<?php } ?>
	</tr>
<?php } ?>
</table>