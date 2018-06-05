<?php

App::uses('AppController', 'Controller');

class SpotifyAppController extends AppController {


	public function processResponse($data, $type) {
		$response = array();
		if($type=="artists"){
			foreach ($data['items'] as $key => $item) {
				$response[$item['id']] = array(
					'id' => $item['id'],
					'name' => $item['name'],
					'url' => Router::url(['plugin'=>'spotify', 'controller' => 'artists', 'action' => 'get_albums', $item['id']]),
					'image' => (!empty($item['images'])) ? $item['images'][1]['url']:'http://toursounds.com/wp-content/uploads/2016/12/artist.png'
				);
			}
		} else if($type=="albums"){
			foreach ($data['items'] as $key => $item) {
				$response[$item['id']] = array(
					'id' => $item['id'],
					'name' => $item['name'],
					'url' => Router::url(['plugin'=>'spotify', 'controller' => 'albums', 'action' => 'get_tracks', $item['id']]),
					'image' => (!empty($item['images'])) ? $item['images'][1]['url']:''
				);
				if(!empty($item['artists'])) {
					foreach ($item['artists'] as $key => $artist) {
						$response[$item['id']]['artists'][] = array(
							'name' => $artist['name'],
							'url' => Router::url(['plugin' => 'spotify', 'controller' => 'artists', 'action' => 'get_albums', $artist['id']])
						);
					}
				}
			}
		} else if($type == "tracks"){
			foreach ($data['items'] as $key => $item) {
				$response[$item['id']] = array(
					'id' => $item['id'],
					'name' => $item['name'],
					'preview_url' => (isset($item['preview_url']) && $item['preview_url']!=null)?$item['preview_url']:'',
				);
				if(!empty($item['album'])) {
					$response[$item['id']]['album_name'] = $item['album']['name'];
					$response[$item['id']]['album_url'] = Router::url(['plugin' => 'spotify', 'controller' => 'albums', 'action' => 'get_tracks', $item['album']['id']]);
				}
				if(!empty($item['artists'])) {
					foreach ($item['artists'] as $key => $artist) {
						$response[$item['id']]['artists'][] = array(
							'name' => $artist['name'],
							'url' => Router::url(['plugin' => 'spotify', 'controller' => 'artists', 'action' => 'get_albums', $artist['id']])
						);
					}
				}
			}
		}
		return $response;
	}

}
