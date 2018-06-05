<?php
App::uses('SpotifyAppController', 'Spotify.Controller');
/**
 * Artists Controller
 *
 * @property Artist $Artist
 */
class AlbumsController extends SpotifyAppController {

	public function get_tracks($id) {
		$this->autoRender = false;
		$results = [];
		$results = $this->Album->getTracksByAlbumId($id);
		if(!empty($results)){
			$results = $this->processResponse($results, "tracks");
		}
		return json_encode($results);
	}
}