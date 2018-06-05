<?php
App::uses('SpotifyAppController', 'Spotify.Controller');
/**
 * Artists Controller
 *
 * @property Artist $Artist
 */
class SearchController extends SpotifyAppController {

	var $use = array('Search');

	public function index() {

	}

	public function advanced_search() {
		$results = [];
		$type="";
		if($this->request->is('post') && !empty($this->request->data)){
			$search_obj = ClassRegistry::init('Spotify.Search', 'Model');
			$results = $search_obj->multiSearch($this->request->data['Search']);
			if(!empty($results)) {
				reset($results);
				$type = key($results);
			}
		}
		$this->set(compact('results', 'type'));
	}
	/**
	Recibe post con texto a buscar
	*/
	public function full_search() {
		$this->autoRender = false;
		$results = [];
		if($this->request->is('post') && !empty($this->request->data)){
			$results = $this->Search->multiSearch($this->request->data['Search']);
			$results['artists'] = $this->processResponse($results['artists'], 'artists');
			$results['albums'] = $this->processResponse($results['albums'], 'albums');
			$results['tracks'] = $this->processResponse($results['tracks'], 'tracks');
		}
		return json_encode($results);
	}

}