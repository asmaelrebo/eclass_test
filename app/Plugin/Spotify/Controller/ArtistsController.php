<?php
App::uses('SpotifyAppController', 'Spotify.Controller');
/**
 * Artists Controller
 *
 * @property Artist $Artist
 */
class ArtistsController extends SpotifyAppController {

	public function get_albums($id) {
		$this->autoRender = false;
		$results = [];
		$results = $this->Artist->getAlbumsByArtist($id);
		if(!empty($results)){
			$results = $this->processResponse($results, "albums");
		}
		return json_encode($results);
	}
}