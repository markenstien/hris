$( document ).ready( function() 
{
	const USER_TYPE = $("select[name='user_type']");

	if( USER_TYPE.is(':checked') ){
		let target = USER_TYPE.data('target');
		$(`${target}`).show();
	}


	$("select[name='user_type']").change( function(e) 
	{
		let value = $(this).val();
		let target = $(this).data('target');
		
		if( value == 'doctor') 
		{
			$(`${target}`).show();
		}else{
			$(`${target}`).hide();
		}
	});

});