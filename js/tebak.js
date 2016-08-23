var interval = 1000; //1s
var waktu = 30; //30s
window.setInterval(function(event) {
		update_timer();
}, interval);

var loading = true;

function set_loading(elemen)
{
	elemen.html('<div id="loadingDiv"><img src="../images/loading.gif"></div>');
	loading = true;
}

function mulai_tebak(url_mulai, url_lagu_statis, url_input)
{
	set_loading( $('#tebak_container') );
	//Lakukan request GET
	$.get(url_mulai, function(data)
	{
		console.log('memulai tebak lagu...');
		load_input(url_input, url_lagu_statis);
	}, 'json')
	.fail(function() { //jika gagal
		alert("Terjadi kesalahan. Silahkan reload");
		console.log('Gagal mulai tebak');
	});
}

function stop_tebak()
{
	set_loading( $('#input_container') );
	
	var url = $("#url_hasil").val();
	$("#input_container").load(url, function()
	{
		$("#hasil").fadeIn('slow');
	});
	console.log('stop tebak lagu');
}

function load_lagu(url_lagu)
{
	loading = false;
	$('#tebak_container').html('<audio id="lagu_player" style="width: 400px;" controls><source id="source_lagu" src="'+url_lagu+'" type="audio/ogg"></audio>');
	$('#lagu_player')[0].play();
	$('#input_tebak').focus();
	reset_timer();
}

function load_input(url_input, url_lagu_statis)
{
	$("#input_container").load(url_input, function()
	{
		load_lagu(url_lagu_statis);
		$("#form_tebak").fadeIn('slow');
	});
}

function update_timer()
{
	if(loading == false)
	{
		if(waktu > 0)
		{
			waktu--;
			$('.timer').val(waktu).trigger('change');
		}
		else
		{
			//redirectstop
			stop_tebak();
			alert('Waktu habis !');
		}
	}
}

function reset_timer()
{
	$('.timer').val(30).trigger('change');
	waktu = 30;
}