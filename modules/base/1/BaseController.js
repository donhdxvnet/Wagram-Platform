$("#create").click
(
	function()
	{
		//alert("create " + $("#id").val());
		var params = {			 
			'mod' : 'base',
			'action': 'create',
			'id': $("#id").val()
		};
		Helper.post(null, params, false, function(data)
		{
			//alert("request create");
		});
	}
)