
var Helper = function(){}

/**
 * url du front controller
 */
Helper._serverUrl = "index.php";

Helper.datepicker = function(params)
{
	var config = {
		numberOfMonths: 1,
		showButtonPanel: true,
		changeMonth: true,
		changeYear: true,
		showOn: "button",
		buttonImage: "assets/images/calendar.gif"	
	};
	config = jQuery.extend(config, params);
	
	jQuery(config.obj).datepicker(config);	
	jQuery.datepicker.setDefaults(jQuery.datepicker.regional[config.lang]);	
};

Helper.timepicker = function(params)
{
	var config = {};
	config = jQuery.extend(config, params);
	
	jQuery(config.obj).timepicker(config);
	jQuery.timepicker.setDefaults(jQuery.timepicker.regional[config.lang]);	
};

Helper.datetimepicker = function(params)
{
	var config = {
		numberOfMonths: 1,
		showButtonPanel: true,
		changeMonth: true,
		changeYear: true,
		showOn: "button",
		buttonImage: "assets/images/calendar.gif"
	}
	config = jQuery.extend(config, params);

	jQuery(config.obj).datetimepicker(config);	
	jQuery.datepicker.setDefaults(jQuery.datepicker.regional[config.lang]);
	jQuery.timepicker.setDefaults(jQuery.timepicker.regional[config.lang]);	
};

Helper.upload = function(params)
{		
	var config = 
	{			
		url:"index.php",		
		maxFileSize:1024*1024*post_max_size,
		maxFileCount:1,	
		fileName:"Filedata",			
		dragDrop:true,
		multiple:false,
		autoSubmit:false,
		showDone:false,			
		onError: function(files, status, errMsg)
		{
			jQuery(params["errFrm"]).text(data.messages[0]);
			jQuery(params["submitBtn"]).attr("disabled", "disabled");
		},
		onSubmit:function(files)
		{
			jQuery(params["submitBtn"]).attr("disabled", "disabled");
		},			
		onSelect:function(files)
		{					
			jQuery(params["submitBtn"]).removeAttr('disabled');
			return true;
		}		
	};		
	config = jQuery.extend(config, params);
			
	var uploadBtn = jQuery(params["uploadBtn"]).uploadFile(config);		
	jQuery(params["submitBtn"]).click(function()
	{
		uploadBtn.startUpload();
	});	
};

/**
 * Effectue une requete ajax post
 * le retour de cette requete ajax et non de la fonction est un objet json
 * ayant le format suivant : data = { code, messages[]}
 * 		code = 0 en cas d'erreur et 1 en cas de succes
 * 		messages est un tableau contenant les messages( erreur ou succes)
 * 
 * @param form_id, 
 * 		l'id du formulaire, permet la serialisation de celui ci
 * 
 * @param params, 
 * 		les parametres supplémentaire ne se trouvant pas dans le formulaire
 * 		format : { "name" : value , ...}
 * 
 * @param show_status,
 * 		utilise le system interne de message en cas d'erreur ou de succes.
 * 
 * @param fn_success,
 * 		En cas de succes cette fonction sera executé.
 * 
 */
 
Helper.secure = function(form_id, params ,show_status, fn_success){

	var p1 = [];
	
	for( var i in params){
		p1.push({name : i, value : params[i] });
	}
		
	if (form_id != null)
	{					
		var fields = jQuery("#" + form_id).serializeArray();
		//SHA-512 : TODO
		/*jQuery.each(fields, function(i, field){						
			var jsSha = new jsSHA(field.value); //SHA-512
			field.value = jsSha.getHash("SHA-512", "HEX");
		});*/		
		jQuery.merge(p1, fields);
	}
	
	Helper.waitOverlay(true);
	jQuery.post(Helper._serverUrl, p1 , function(data){
		Helper.waitOverlay(false);
		if ( data.code == -1){
			window.location.href = 'index.php';
			return;
		}
		if ( show_status ){
			if ( data.code > 0){
				// success
				Helper.showSuccessMessage(data.messages);
				
				if ( fn_success != null)
					fn_success(data);
			}else{
				// error
				Helper.showErrorMessage(data.messages);
				
			}
		}else{
			if ( fn_success != null)
				fn_success(data);
		}
	}, "json");
} 
 
Helper.post = function(form_id, params ,show_status, fn_success){

	var p1 = [];
	
	for( var i in params){
		p1.push({name : i, value : params[i] });
	}
	
	if ( form_id != null)
		jQuery.merge(p1, jQuery("#"+form_id).serializeArray());
	
	Helper.waitOverlay(true);
	jQuery.post(Helper._serverUrl, p1 , function(data){
		Helper.waitOverlay(false);
		if ( data.code == -1){
			window.location.href = 'index.php';
			return;
		}
		if ( show_status ){
			if ( data.code > 0){
				// success
				Helper.showSuccessMessage(data.messages);
				
				if ( fn_success != null)
					fn_success(data);
			}else{
				// error
				Helper.showErrorMessage(data.messages);
				
			}
		}else{
			if ( fn_success != null)
				fn_success(data);
		}
	}, "json");
}

Helper.load = function(dom_id, params, fn_success){
	Helper.waitOverlay(true);
	jQuery('#'+dom_id).load(Helper._serverUrl, params, function(){
		Helper.waitOverlay(false);
		if ( fn_success!= null)
			fn_success();
	});
}

Helper.waitOverlay = function(bVisible){
	var sIdOverlay = "waitOverlay";
	if(bVisible){
		if(jQuery.active == 0){
			jQuery("body").css("cursor", "wait").append('<div id="' + sIdOverlay + '"></div>');
			jQuery("#" + sIdOverlay).width(jQuery(window).width()).height(jQuery(window).height()).hide().fadeTo(400, 0.6);
		}
	} else {
		if(jQuery.active <= 1){
			jQuery("#" + sIdOverlay).stop().fadeOut(function(){
				jQuery("body").css("cursor", "auto");
				jQuery("#" + sIdOverlay).remove();
			});
		}
	}
}

Helper.getContent = function(params, func){
	Helper.waitOverlay(true);
	jQuery.post(Helper._serverUrl, params , function(data){
		Helper.waitOverlay(false);
		func(data);
	});
}

Helper.removeMessage = function(){
	MClose();
}

Helper.showErrorMessage = function(errors){
	var str = '';
	for(var i in errors){
		str += errors[i];
	}
	MAlert(str, 'Erreur');
	jQuery('#m_footer .button').focus();
}

Helper.showSuccessMessage = function(messages){
	MAlert(messages[0], 'Ok');
	setTimeout(function(){ jQuery('#m_footer .button').focus(); });
}

Helper.alert = function (message, title){
	MAlert(message, title);
	jQuery('#m_footer .button').focus();
}

Helper.confirm = function (message, title, func){
	MConfirm(message, title, function(data){
		func(data);
	});
}

Helper.content = function(content, title, func){
	MContent(content, title, function(data){
		if(func)
			func(data);
	});
}