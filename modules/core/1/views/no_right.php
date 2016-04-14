<?php

Security::checkClientByPass();
?>
<div class="content_data_header"></div>
<div class="content_data_content" id="client_content">
	<div class="table_title">
		<?=BackendTexts::get('core_module_denied_acces')?>
	</div>
	<div class="table_content_text"><?=BackendTexts::get('core_no_right_for_module')?></div>
</div>
