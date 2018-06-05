<div class="span12">
	<h2>Test Búsqueda avanzada</h2>
	<?php 
	echo $this->Form->create('Search', array(
		'class' => 'form-inline',
	));
		echo $this->Form->input('artist', array(
			'div' => 'form-group',
			'label' => 'Artista',
			'class' => 'form-control',
		));
		echo $this->Form->input('album', array(
			'div' => 'form-group',
			'label' => 'Álbum',
			'class' => 'form-control'
		));
		echo $this->Form->input('track', array(
			'div' => 'form-group',
			'label' => 'Canción',
			'class' => 'form-control',
		));
		echo $this->Form->submit('Buscar', array('class' => 'btn btn-primary', 'div' => false));
	echo $this->Form->end();
	echo '<div class="clearfix"></div>';
	?>
</div>
<div class="results">
	<div class="span12">
		<?php 
		if(!empty($results) && $type!="") {
			echo "<h2>Resultados</h2>";
			if($results[$type]['total']>0) {
				echo $this->element('Spotify.search_results_'.$type, array('results' => $results[$type]['items']));
			} else {
				echo '<div class="alert alert-danger" role="alert">No se encontraron resultados.</div>';
			}
		}
		?>
	</div>
</div>