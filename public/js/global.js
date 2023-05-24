$( document ).ready(function() 
{
	if( $('.form-verify') )
	{
		$('.form-verify').click(function(evt) {

			let message = $(this).attr('data-message');

			if(message == null) 
				message = 'Are you sure you want to continue this proccess , irreversible process ';


			if(!confirm(message))
				evt.preventDefault();
		});
	}


	if( $('.copy-to-clip-board') )
	{

		$('.copy-to-clip-board').click( function() {
			let value = $(this).data('value');

			alert("Copied to Clipboard");
			copyStringToClipBoard(value);
		});
		
	}

	if( $('.flash-alert') )
	{
		setTimeout( function()
		{
			$('.flash-alert').hide();
		} , 4000);
	}

	function copyStringToClipBoard(text)
	{
		var $temp = $("<input>");

		$("body").append($temp);

		$temp.val(text).select();

		document.execCommand("copy");

		$temp.remove();
	}
	function copyToClipboard(element) 
	{
		var $temp = $("<input>");

		$("body").append($temp);

		$temp.val($(element).text()).select();
		document.execCommand("copy");
		$temp.remove();
	}
});

function dateDifferenceInMinutes(start , end = null) 
	{
		let date1 = new Date(start);
		let date2 = new Date(Date.now());

		if(end != null)
			date2   = new Date(end);
			
		var diff =(date1.getTime() - date2.getTime()) / 1000;

		diff /= 60;

		return Math.abs(Math.round(diff));
	}

	function minutesToHours(minutes)
	{
		minutes = parseInt(minutes);

		let hours = Math.floor(minutes / 60);
		let remainingMinutes = minutes % 60;

		return `${hours} Hrs ${remainingMinutes} mins`;
	}

