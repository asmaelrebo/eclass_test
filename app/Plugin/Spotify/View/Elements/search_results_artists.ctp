<div class="equal">
	<?php 
	if(isset($results) && !empty($results)) {
		foreach($results AS $key=>$item) { ?>
			<div class="col-sm-2 text-center">
				<?php
				if(!empty($item['images'])) {
				 	echo $this->Html->image($item['images'][1]['url'], array('class' => 'img-responsive img-circle', 'alt' => 'Imagen Álbum'));
				}
				echo $this->Html->link($item['name'], array('plugin' => 'spotify', 'controller' => 'artists', 'action' => 'view', $item['id']));
				?>
			</div>
		<?php }
	}?>
</div>