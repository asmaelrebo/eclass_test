	<div class="span12">
		<h1>Proyecto para realizar búsquedas al API de Spotify</h1>
		<small>DataSource modificado para que acepte Rest Api como ORM</small>
		<?php 
			echo $this->Form->create('Search', array(
				'class' => 'form-horizontal',
				'url' => array(
					'plugin' => 'spotify',
					'controller' => 'search',
					'action' => 'full_search'
				)
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
<div class="alerts">
</div>
<div class="results" style="display: none;">
	<h2>Resultados búsqueda</h2>
	<div id="resultsTabs">
		<ul class="nav nav-tabs" role="tablist">
			<li role="presentation" class="active"><a href="#artists" aria-controls="artists" role="tab" data-toggle="tab" class="artists_tab">Artistas</a></li>
			<li role="presentation"><a href="#albums" aria-controls="albums" role="tab" data-toggle="tab" class="albums_tab">Albums</a></li>
			<li role="presentation"><a href="#tracks" aria-controls="tracks" role="tab" data-toggle="tab" class="tracks_tab">Canciones</a></li>
		</ul>
		<!-- Tab panes -->
		<div class="tab-content">
			<div role="tabpanel" class="tab-pane active" id="artists"></div>
			<div role="tabpanel" class="tab-pane" id="albums"></div>
			<div role="tabpanel" class="tab-pane" id="tracks">
				<div class="table-responsive table-songs">
					<table class="table">
						<thead>
							<tr>
								<th>Canción</th>
								<!-- <th>Álbum</th> -->
								<th>Artista</th>
								<th>Demo</th>
							</tr>
						</thead>
						<tbody>
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
</div>