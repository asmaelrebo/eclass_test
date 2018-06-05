<?php 
if(isset($results) && !empty($results)) { 
	?>
	<div class="table-responsive">
		<table class="table">
			<thead>
				<tr>
					<th>Canción</th>
					<th>Álbum</th>
					<th>Artista</th>
					<th>Demo</th>
				</tr>
			</thead>
			<tbody>
				<?php foreach($results AS $key=>$item) { ?>
					<tr>
						<td><?php echo $item['name'];?></td>
						<td><?php 
							if(!empty($item['album'])) {
								echo $item['album']['name'];
							} else {
								echo "Álbum no encontrado";
							} 
						?></td>
						<td><?php 
							if(!empty($item['artists'])) {
								foreach ($item['artists'] as $key => $artist) {
									echo $artist['name'];
								}
							} else {
								echo "Artista no encontrado";
							} 
						?></td>
						<td>
							<audio controls>
								<source src="<?=$item['preview_url']?>" type="audio/mpeg">
								Your browser does not support the audio element.
							</audio>
						</td>
					</tr>
				<?php } ?>
			</tbody>
		</table>
	</div>
<?php } ?>