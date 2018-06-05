$(document).ready(function(){
	function clearResults(){
		$('#btnSearch').removeAttr('disabled');
		$('.alerts').html('');
		$('.results #artists').html('');
		$('.results #albums').html('');
		$('.results #tracks tbody').html('');
	}
	function searchCallback(response){
		if(Object.keys(response.artists).length != 0) {
			html='<div class="equal">';
			$.each(response.artists, function(i, val) {
				html+='<div class="col-sm-2 text-center">';
					html+='<img src="'+val.image+'" class="img-circle img-responsive"/>'
					html+='<button href="'+val.url+'" type="button" class="btn btn-xs btn-success get_albums" data-loading-text="Cargando Álbumes">'+val.name+'</button>';
					// html+='<a href="'+val.url+'" class="get_albums">'+val.name+'</a>'
				html+='</div>';
			});
			html+="</div>";
		} else {
			html = '<div class="alert alert-danger" role="alert">No se encontraron artistas.</div>';
		}
		$('.results #artists').html(html);

		if(Object.keys(response.albums).length != 0) {
			html='<div class="equal">';
			$.each(response.albums, function(i, val) {
				html+='<div class="col-sm-2 text-center">';
					html+='<img src="'+val.image+'" class="img-responsive"/>';
					html+='<button href="'+val.url+'" type="button" class="btn btn-xs btn-success get_tracks" data-loading-text="Cargando Canciones">'+val.name+'</button>';
					// html+='<a href="'+val.url+'" class="get_tracks">'+val.name+'</a><br/>';
					if(val.hasOwnProperty('artists') && Object.keys(val.artists).length !== null) {
						$.each(val.artists, function(i, artist) {
							html+='<button href="'+artist.url+'" type="button" class="btn btn-xs btn-success get_albums" data-loading-text="Cargando Álbumes">'+artist.name+'</button>';
							// html+='<a href="'+artist.url+'" class="get_albums">'+artist.name+'</a><br/>';
						});
					}
				html+='</div>';
			});
			html+="</div>"
		} else {
			html = '<div class="alert alert-danger" role="alert">No se encontraron álbumes.</div>';
		}
		$('.results #albums').html(html);

		if(Object.keys(response.tracks).length != 0) {
			html="";
			$.each(response.tracks, function(i, val) {
				html+='<tr>';
					html+='<td>'+val.name+'</td>';
					// html+='<td><button href="'+val.album_url+'" type="button" class="btn btn-xs btn-success get_tracks" data-loading-text="Cargando Canciones">'+val.album_name+'</button></td>';
					html+='<td>';
						if(val.hasOwnProperty('artists') && Object.keys(val.artists).length !== null) {
							$.each(val.artists, function(i, artist) {
								html+='<button href="'+artist.url+'" type="button" class="btn btn-xs btn-success get_albums" data-loading-text="Cargando Álbumes">'+artist.name+'</button>';
								// html+='<a href="'+artist.url+'" class="get_albums">'+artist.name+'</a><br/>';
							});
						}	
					html+='</td>';
					html+='<td><audio controls>'+
							'<source src="'+val.preview_url+'" type="audio/mpeg">'+
								'Your browser does not support the audio element.'+
							'</audio></td>';
				html+='</tr>';

			});
			$('#tracks > .table-responsive > .table > tbody').html(html);
		} else {
			html = '<div class="alert alert-danger" role="alert">No se encontraron canciones.</div>';
			$('#tracks > .table-responsive > .table > tbody').html(html);
		}
		$('.results').show();
	}
	$('#btnSearch').click(function(e){
		e.preventDefault();
		$.ajax({
			method: "POST",
			url: $('#SearchFullSearchForm').attr('action'),
			dataType: 'json',
			data: $('#SearchFullSearchForm').serialize(),
			beforeSend: function(){
				$('.alerts').html('Cargando...');
				$('#btnSearch').attr('disabled', 'disabled');
			},
		})
		.fail(function (jqXHR, textStatus, error) {
			// $('.alerts').html('<div class="alert alert-danger" role="alert">'+$.parseJSON(jqXHR.responseText).error+'</div>');
			$('.alerts').html('<div class="alert alert-danger" role="alert">Hubo un error al realizar la búsqueda, favor intente nuevamente.</div>');
			$('#btnSearch').removeAttr('disabled');
		})
		.done(function( msg ) {
			clearResults();
			searchCallback(msg);
		});
	});

	$(document.body).on('click', '.get_albums', function(e){
		var $btn = $(this).button('loading');
		e.preventDefault();
		$.ajax({
			method: "GET",
			url: $(this).attr('href'),
			dataType: 'json',
			beforeSend: function(){
				$('.alerts').html('Cargando...');
				$('#btnSearch').attr('disabled', 'disabled');
			},
		})
		.fail(function (jqXHR, textStatus, error) {
			$('.alerts').html('<div class="alert alert-danger" role="alert">Hubo un error al realizar la búsqueda, favor intente nuevamente.</div>');
			$('#btnSearch').removeAttr('disabled');
			$btn.button('reset');
		})
		.done(function( response ) {
			// clearResults();
			$btn.button('reset');
			$('#btnSearch').removeAttr('disabled');
			$('.alerts').html('');
			$('.albums_tab').tab('show');
			if(Object.keys(response).length != 0) {
				html='<div class="equal">';
				$.each(response, function(i, val) {
					html+='<div class="col-sm-2 text-center">';
						html+='<img src="'+val.image+'" class="img-responsive"/>';
						html+='<button href="'+val.url+'" type="button" class="btn btn-xs btn-success get_tracks" data-loading-text="Cargando Canciones">'+val.name+'</button><br/>';
						if(val.hasOwnProperty('artists') && Object.keys(val.artists).length !== null) {
							$.each(val.artists, function(i, artist) {
								html+='<button href="'+artist.url+'" type="button" class="btn btn-xs btn-success get_albums" data-loading-text="Cargando Álbumes">'+artist.name+'</button>';
							});
						}
					html+='</div>';
				});
				html+="</div>"
			} else {
				html = '<div class="alert alert-danger" role="alert">No se encontraron álbumes.</div>';
			}
			$('.results #albums').html(html);
		});
	});

	$(document.body).on('click', '.get_tracks', function(e){
		var $btn = $(this).button('loading');
		e.preventDefault();
		$.ajax({
			method: "GET",
			url: $(this).attr('href'),
			dataType: 'json',
			beforeSend: function(){
				$('.alerts').html('Cargando...');
				$('#btnSearch').attr('disabled', 'disabled');
			},
		})
		.fail(function (jqXHR, textStatus, error) {
			$('.alerts').html('<div class="alert alert-danger" role="alert">Hubo un error al realizar la búsqueda, favor intente nuevamente.</div>');
			$('#btnSearch').removeAttr('disabled');
			$btn.button('reset');
		})
		.done(function( response ) {
			$btn.button('reset');
			$('#btnSearch').removeAttr('disabled');
			$('.alerts').html('');
			$('.tracks_tab').tab('show');
			if(Object.keys(response).length != 0) {
				html="";
				$.each(response, function(i, val) {
					html+='<tr>';
						html+='<td>'+val.name+'</td>';
						// html+='<td><button href="'+val.album_url+'" type="button" class="btn btn-xs btn-success get_tracks" data-loading-text="Cargando Canciones">'+val.album_name+'</button></td>';
						html+='<td>';
							if(val.hasOwnProperty('artists') && Object.keys(val.artists).length !== null) {
								$.each(val.artists, function(i, artist) {
									html+='<button href="'+artist.url+'" type="button" class="btn btn-xs btn-success get_albums" data-loading-text="Cargando Álbumes">'+artist.name+'</button>';
								});
							}	
						html+='</td>';
						html+='<td><audio controls>'+
								'<source src="'+val.preview_url+'" type="audio/mpeg">'+
									'Your browser does not support the audio element.'+
								'</audio></td>';
					html+='</tr>';

				});
				$('#tracks > .table-responsive > .table > tbody').html(html);
			} else {
				html = '<div class="alert alert-danger" role="alert">No se encontraron canciones.</div>';
				$('#tracks > .table-responsive > .table > tbody').html(html);
			}
		});
	})
});