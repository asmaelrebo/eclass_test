<?php
App::uses('SpotifyAppModel', 'Spotify.Model');
/**
 * Search Model
 *
 * @property Search $Search
 */
class Search extends AppModel {
	public $useDbConfig = 'externalApi';

	var $name="Search";
	var $remoteResource = 'search';

	/**
	Buscar por artist|album|track en api de spotify a través de RestSource
	*/
	public function multiSearch($data) {
		if(!$data) {
			return false;
		}
		$query = [];
		$type=array();
		if(!empty($data)) {
			if(!isset($data['search_text'])) {
				if($data['artist'] != "") {
					$query['type'] = 'artist';
					array_push($type, "artist:".$data['artist']);
				}
				if($data['album'] != "") {
					$query['type'] = 'album';
					array_push($type, "album:".$data['album']);
				}
				if($data['track'] != "") {
					$query['type'] = 'track';
					array_push($type, "track:".$data['track']);
				}
				$query['q'] = implode(' ',$type);
			}else {
				$query['q'] = $data['search_text'];
				$query['type'] = "artist,album,track";
			}
		}
		if($query['q']==""){
			return false;
		}
		// Request necesario para utilizar ORM con HttpRequest
		$this->request = array(
			'uri' => array(
				'scheme' => 'https',
				'host' => Configure::read('Spotify.url').'search',
			)
		);

		// Acepta limit y query
		return $this->find('all', array(
			'limit' => 10,
			'conditions' => $query
		));
	}
}