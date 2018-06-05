<?php
	Router::connect('/spotify/buscar', array('plugin'=>'spotify', 'controller' => 'search', 'action' => 'index'));
	Router::connect('/spotify/resultado-busqueda', array('plugin' => 'spotify','controller' => 'search', 'action' => 'full_search'));

	Router::connect('/spotify/busqueda-avanzada', array('plugin' => 'spotify','controller' => 'search', 'action' => 'advanced_search'));
    Router::connect('/spotify/artistas/*', array('plugin'=>'spotify', 'controller' => 'artists', 'action' => 'get_albums'));
    Router::connect('/spotify/albums/*', array('plugin'=>'spotify', 'controller' => 'albums', 'action' => 'get_tracks'));
?>