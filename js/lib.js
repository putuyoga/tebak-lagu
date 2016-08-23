/**==========================
	Tebak Lagu 1.0
=============================**/

/**
	Untuk memuat data table list lagu, artist dll
**/
function list_load(url)
{
	set_loading($('#lists'));
	$("#lists").load(url, function()
	{
		$("#table_list").fadeIn('slow');
	});
}

/**
	Untuk memuat form/html aksi dari url yg ada
**/
function aksi_load(url)
{
	set_loading($('#aksi'));
	$("#aksi").load(url, function()
	{
		$("#table_aksi").fadeIn('slow');
	});
}

/**
	Insert html loading ke elemen yg ditentukan
**/
function set_loading(elemen)
{
	elemen.html('<div id="loadingDiv"><img src="../../images/loading.gif"></div>');
}

/**
	Untuk menghapus item dari suatu table
	yg kemudian melakukan request hapus ke server dari URL
**/
function hapus_item(id_hapus, elemen, url)
{
	//Konfirmasi
	var r=confirm("Yakin ingin menghapus item ini ? Aksi ini tidak bisa kembalikan !");
	if (r==true)
	{
		
		// ket : tombol > td > tr
		$( elemen ).parent().parent().hide('slow');
		
		//Lakukan request GET
		$.get(url+'/'+id_hapus, function(data)
		{
			if(data.sukses == true)
			{
				//jika berhasil, tulis ke konsol
				console.log('berhasil hapus item');
			}
			else
			{
				console.log('error: '+data.error);
				alert("Gagal hapus");
				$( elemen ).parent().parent().show('slow');
			}
		}, 'json')
		.fail(function() { alert("Gagal hapus"); $( elemen ).parent().parent().show('slow'); }); //jika gagal, tampilkan lagi item
	}
}

function hapus_semua(url_hapus, elemen, url_list)
{
	//Konfirmasi
	var r=confirm("Yakin ingin menghapus SEMUA item ini ? Aksi ini tidak bisa kembalikan !");
	if (r==true)
	{
		// tombol > td > tr
		$( elemen ).parent().parent().parent().hide('slow');
		$.get(url_hapus, function(data)
		{
			if(data.sukses == true)
			{
				$( elemen ).parent().parent().parent().show('slow');
				
				//jika berhasil, tulis ke konsol
				list_load(url_list);
				console.log('berhasil hapus semua item');
			}
			else
			{
				console.log('error: '+data.error);
				alert("Gagal hapus");
				$( elemen ).parent().parent().parent().show('slow');
			}
		}, 'json')
		.fail(function() { alert("Gagal hapus"); $( elemen ).parent().parent().show('slow'); });
	}
}


/**
	Dipakai di tombol link halaman / pagination
	ex : 1 / 3 [go]
**/
function toggle_page_button(elemen)
{
	$(elemen).fadeToggle('slow', function()
	{
		$('#kustom_page').fadeToggle('slow');
	});
}

function goto_custom_page(url)
{
	var page = $('#page_num').val();
	
	list_load(url+page);
}

