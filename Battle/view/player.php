<div class="player <?=$num==1 ? 'one' : 'two'?>">
	<ul class="list show">
		<li class="title" style="color:<?=$player->color?>"><?=$player->name?></li>

<?php	foreach($ships as $k=>$ship) { ?>
			<li ship="p<?=$num?>s<?=$k?>">
				<input type="hidden" name="shipid" value="<?=$k?>" />
				<p><?=$ship->name?></p>

				<?php 	if ($num == 1) { ?>
					<div class="infos">
						<span class="hp" style="width:<?=($ship->hp / $ship->hpmax)*80?>px"></span>
						<span class="shield" style="width:<?=($ship->sp / $ship->spmax)*80?>px"></span>
						<span class="pp">PP : <?=$ship->power?></span>
					</div><div class="img">
						<img src="<?=$ship->image?>" alt="deathstar" title="deathstar"/>
						<span class="status on"></span>
					</div>
				<?php } else { ?>
					<div class="img">
						<img src="<?=$ship->image?>" alt="deathstar" title="deathstar"/>
						<span class="status on"></span>
					</div><div class="infos">
						<span class="hp"></span>
						<span class="shield"></span>
						<span class="pp">PP : <?=$ship->power?></span>
					</div>
				<?php } ?>
			</li>
<?php 	} ?>

	</ul>
</div>