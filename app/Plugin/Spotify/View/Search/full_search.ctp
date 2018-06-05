	<div class="span12">
		<h1>Proyecto para realizar búsquedas al API de Spotify</h1>
		<small>DataSource modificado para que acepte Rest Api como </small>
		<?php 
			echo $this->Form->create('Search', array(
				'class' => 'form-horizontal',
				'url' => '/buscar'
			));
				echo '<div class="input-group">';
					echo $this->Form->input('search_text', array(
						'class' => 'form-control input-sm',
						'div' => false,
						'label' => false,
						'placeholder' => 'Busca artistas, canciones o álbumes'
					));
					echo '<span class="input-group-btn">';
						echo $this->Form->submit('Buscar', array('class' => 'btn btn-sm btn-primary', 'div' => false, 'id' => 'btnSearch'));
					echo '</span>';
				echo '</div>';
			echo $this->Form->end();
		?>
	</div>
	<h2>Resultados búsqueda</h2>
	<div>
		<ul class="nav nav-tabs" role="tablist">
			<li role="presentation" class="active"><a href="#artists" aria-controls="artists" role="tab" data-toggle="tab">Artistas</a></li>
			<li role="presentation"><a href="#albums" aria-controls="albums" role="tab" data-toggle="tab">Albums</a></li>
			<li role="presentation"><a href="#tracks" aria-controls="tracks" role="tab" data-toggle="tab">Canciones</a></li>
		</ul>
		<!-- Tab panes -->
		<div class="tab-content">
			<div role="tabpanel" class="tab-pane active" id="artists"><?php
				if(!empty($results) && isset($results['artists'])) {
					echo $this->element('Spotify.search_results_artists', array('results' => $results['artists']['items']));
				} 
			?></div>
			<div role="tabpanel" class="tab-pane" id="albums"><?php
				if(!empty($results) && isset($results['albums'])) {
					echo $this->element('Spotify.search_results_albums', array('results' => $results['albums']['items']));
				} 
			?></div>
			<div role="tabpanel" class="tab-pane" id="tracks"><?php
				if(!empty($results) && isset($results['tracks'])) {
					echo $this->element('Spotify.search_results_tracks', array('results' => $results['tracks']['items']));
				} 
			?></div>
		</div>
	</div>
