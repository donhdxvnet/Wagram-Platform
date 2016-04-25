<script type="text/javascript">

	var getModule = function(sModule, sDestinationDiv)
	{
		var params = {
			mod : sModule,
			ajax : true
		};
		Helper.load(sDestinationDiv, params, function(){
			//alert("module load");
		});
	}

</script>


<div style="
	border:1px solid black;
	margin-bottom:10px;
	padding:5px;
">
	<a href="#" onclick="getModule('base', 'content')">
		Base
	</a>	
</div>