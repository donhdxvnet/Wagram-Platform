<?php

Security::checkAdminByPass();
?>
<script type="text/javascript">
    jQuery('#bt_retriev').click(function(){
        Helper.post('lostpwd_form', {'action': 'retrievepassword'}, true, function(data){
	});
    });

    jQuery('#bt_back').click(function(){
        Helper.load('content',{'action':'updatelogin'});
    });
</script>
<form id="lostpwd_form">
<table border="0" cellspacing="0" cellpadding="0" align="center"  width="986" height="298" style=" margin-top:-24px;	background-image:url(assets/images/back_login.jpg); background-repeat:no-repeat" >
<tr align="center">
	<td>
	<table border="0" cellspacing="0" cellpadding="0" align="center">
		<tr>
		  <td  class="color_blue" style="font-weight:bold; font-align:center"><?=BackendTexts::get('lostpwd_text1')?></td>
	    </tr>
		<tr>
	        <td align="center">
		<table>
        <tr>
			<td align="right" style="padding-right:4px;" class="color_white"><strong><?=BackendTexts::get('lostpwd_username')?></strong>&nbsp;</td>
			<td style="padding:12px;"><input type="text" name="in_username" /></td>
		</tr>
		<tr>
		  <td align="center">&nbsp;</td>
		  <td align="center"><input type="button" id="bt_retriev" class="button_login" value="<?=BackendTexts::get('lostpwd_button')?>"/></td>
	    </tr>
		<tr>
        	<td align="center" style="padding-top:4px;">&nbsp;</td>
        	<td align="center" style="padding-top:4px;"><a href="#" id="bt_back" class="color_white">
        	  <?=BackendTexts::get('lostpwd_backlink')?>
        	</a></td>
        </tr>
        </table>
        	</td>
        </tr>
	</table>
    </td>
  </tr>
    </table>
</form>
