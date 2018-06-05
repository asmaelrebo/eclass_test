<?php
Configure::write('Spotify.url', 'api.spotify.com/v1/');
Configure::write('Spotify.url_token', 'https://accounts.spotify.com/api/token');
Configure::write('Spotify.client_id', getenv('SPOTIFY_CLIENT_ID'));
Configure::write('Spotify.client_secret', getenv('SPOTIFY_CLIENT_SECRET'));