<?php
App::uses('SpotifyAppModel', 'Spotify.Model');
/**
 * Artist Model
 *
 * @property Artist $Artist
 */
class Artist extends AppModel {
	public $useDbConfig = 'externalApi';

	var $name="Artist";
	var $remoteResource = 'album';

	public function getAlbumsByArtist($id) {
		if(!$id) {
			return false;
		}
		$this->request = array(
			'uri' => array(
				'scheme' => 'https',
				'host' => Configure::read('Spotify.url').'artists/'.$id.'/albums',
			)
		);
		return $this->find('all');
	}
}