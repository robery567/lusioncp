<?php

require __DIR__ . '/../../private/lusioncp/start.php';
if (!isset($_SESSION['email']) && empty($_SESSION['email'])) {
	redirect('index.php');
}

?>

<!DOCTYPE html>
<html lang="ro">

<head>
	<?php require __LCP_APP__ . '/app/template/partials/header.php'; ?>
</head>

<body onLoad="input_focus()">
	<div id="wrapper">
		<nav class="navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 0">
			<?php require __LCP_APP__ . '/app/template/partials/navbar.php'; ?>
		</nav>

		<div id="page-wrapper">
			<div class="alert alert-info">
				<p>Există comenzi simplificate, iată o mică listă:</p>
				<ul>
					<li><span class="label label-default">la {folder}</span> - afisează toate fisierele dintr-un director</li>
					<li><span class="label label-default">rf {folder}</span> - sterge un folder</li>
					<li><span class="label label-default">unbz2 {arhiva}</span> - dezarhiveaza o arhiva .tar.bz2 in folderul curent</li>
					<li><span class="label label-default">ungz {arhiva}</span> - dezarhiveaza o arhiva .tar.gz sau .tgz in folderul curent</li>
					<li><span class="label label-default">top</span> - indica procesele active</li>
					<li><span class="label label-success">m2start</span> - porenste un server de Metin2</li>
					<li><span class="label label-success">m2restart</span> - reporneste un server de Metin2</li>
					<li><span class="label label-success">m2stop</span> - opreste un server de Metin2</li>
					<li><span class="label label-success">m2clean</span> - curata log-urile unui server de Metin2</li>
				</ul>
			</div>
			<?php if (!ping($data['ip'])): ?>
			<div class="alert alert-danger">
				<p>Serverul din remote este offline!</p>
			</div>
			<?php endif; ?>
			<div class="embed-responsive embed-responsive-16by9">
				<iframe class="embed-responsive-item" src="//lusioncp.me/lcpdev/shcmd.php"></iframe>
			</div>
		</div>

	</div>
	<?php require __LCP_APP__ . '/app/template/partials/scripts.php' ?>
</body>

</html>
