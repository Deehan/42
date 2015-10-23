<html>
	<head>
		<base href="<?=site::_BASEURL?>" />
		<meta charset="utf-8">
		<link rel="stylesheet" type="text/css" href="./view/structure.css" media="screen" />
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
		<script type="text/javascript" src="./view/board.js?rand=<?=rand(1,1000)?>"></script>
	</head>

	<body>

		<h1>Tour 1 : Joueur B</h1>
		<?php $this->playerboard(1); ?>
		<div id="board">
			<?php include(_VIEW_DIR_.'board.php'); ?>
		</div>
		<?php $this->playerboard(2); ?>

		<div class="action one">
			<input type="hidden" id="shipid" value="" />
			<input type="hidden" id="playerid" value="1" />
			<ul class="onglets">
				<li class="pp"><img src="../images/icon_points.png" alt="ajustement des systemes" title="ajustement des systemes"/></li>
				<li class="maneuvers"><img src="../images/icon_moves.png" alt="manoeuvres" title="manoeuvres"/></li>
				<li class="shoots"><img src="../images/icon_shoot.png" alt="tirs" title="tirs"/></li>
			</ul>
			<p class="title"></p>
			<div class="spec">
				<span class="hp"></span>
				<span class="sp"></span><br/>
				PP disponibles : <span class="pp"></span>/<span class="maxpp"></span>
			</div><img class="ship" />
			
			<div class="onglet pp">
				<p >Attribution des PP</p>
				<div class="attrib">
				<input type="hidden" name="ppool" value="" />
					<ul>
						<li><span>deplacement : </span><input type="button" value="+" class="plus" /> <input type="text" value="0" name="pp[move]" readonly="readonly" /> <input type="button" value="-" class="minus" /></li>
						<li><span>bouclier : </span><input type="button" value="+" class="plus" /> <input type="text" value="0" name="pp[shield]" readonly="readonly" /> <input type="button" value="-" class="minus" /></li>
					</ul>
				</div>
			</div>

			<div class="onglet maneuvers hidden">
				<p >Manoeuvres disponibles</p>		
				<div>		
				<ul class="allmaneuvers">
					<li class="FORW" name="FORW" free="0" compul="0"><span>2</span></li>
					<li class="TLEFT" name="TLEFT" free="0" compul="0"><span>1</span></li>
				</ul>
				</div>
				<p >Manoeuvres en cours</p>
				<div>
				<ul class="moves"></ul>
				</div>
			</div>

			<input type="button" value="annuler" />
		</div>

		<div class="action two">
			<ul class="onglets">
				<li><img src="../images/icon_points.png" alt="ajustement des systemes" title="ajustement des systemes"/></li>
				<li><img src="../images/icon_moves.png" alt="manoeuvres" title="manoeuvres"/></li>
				<li><img src="../images/icon_shoot.png" alt="tirs" title="tirs"/></li>
			</ul>
			<input type="button" value="annuler" />
		</div>
	</body>
</html>