$("#form_tebak").submit(function(event) {		var url = $('#form_tebak #url_tebak').val();		/* stop form from submitting normally */	event.preventDefault();		/* get some values from elements on the page: */	var data_post = $( this ).serialize();		/* Send the data using post */	var posting = $.post( url, data_post, function(data){		if(data.benar == true)		{					//reset isi form			reset_url_lagu();			$("#form_tebak")[0].reset()			$('#benar')[0].play();			var url_lagu = $('#form_tebak #url_lagu').val();			load_lagu(url_lagu);		}		else if(data.benar == false)		{			$('#salah')[0].play();		}		else if(data.selesai == true)		{			alert('Game selesai!');			stop_tebak();		}		else if(data.waktu_habis == true)		{			alert('Waktu habis!');			stop_tebak();		}		else		{			alert(data.error);		}	}, 'json');  });/*----------------------------------------------	Karena bug di firefox yang selalu pake cache	bahkan ketika header php sudah di set no cache	kita harus reset url lagu*/function reset_url_lagu(){	var base_url = $('#form_tebak #base_url').val();	$('#form_tebak #url_lagu').val(base_url+'?s='+makeid());}function makeid(){    var text = "";    var possible = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789";    for( var i=0; i < 10; i++ )        text += possible.charAt(Math.floor(Math.random() * possible.length));    return text;}