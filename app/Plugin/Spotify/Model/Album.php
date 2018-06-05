<?php
App::uses('SpotifyAppModel', 'Spotify.Model');
/**
 * Album Model
 *
 * @property Album $Album
 */
class Album extends AppModel {
	public $useDbConfig = 'externalApi';

	var $name="Album";
	var $remoteResource = 'album';

	public function getTracksByAlbumId($id) {
		if(!$id) {
			return false;
		}
		$this->request = array(
			'uri' => array(
				'scheme' => 'https',
				'host' => Configure::read('Spotify.url').'albums/'.$id.'/tracks',
			)
		);
		return $this->find('all');
	}
}