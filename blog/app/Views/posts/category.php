<div class="row">
	<div class="gc7Main">
		<h1><?= $categorie->titre ?></h1>

		<?php
		if ( $articles ) {

			foreach ( $articles as $post ): ?>
				<h2><a href="<?= $post->url; ?>"><?= $post->titre; ?></a></h2>
				<p><?= $post->extrait; ?></p>
			<?php endforeach;
		}
		else echo '<h4>Aucun article dans cette rubrique</h4>';
		?>

	</div>

	<div class="gc7AsideD">
		<?php foreach ( $categories as $categorie ): ?>
			<ul>
				<li>
					<a href=<?= $categorie->url ?>><?= $categorie->titre ?></a>
				</li>
			</ul>
		<?php endforeach; ?>
	</div>
