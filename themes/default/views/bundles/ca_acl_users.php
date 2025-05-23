<?php
/* ----------------------------------------------------------------------
 * bundles/ca_acl_users.php : 
 * ----------------------------------------------------------------------
 * CollectiveAccess
 * Open-source collections management software
 * ----------------------------------------------------------------------
 *
 * Software by Whirl-i-Gig (http://www.whirl-i-gig.com)
 * Copyright 2012-2014 Whirl-i-Gig
 *
 * For more information visit http://www.CollectiveAccess.org
 *
 * This program is free software; you may redistribute it and/or modify it under
 * the terms of the provided license as published by Whirl-i-Gig
 *
 * CollectiveAccess is distributed in the hope that it will be useful, but
 * WITHOUT ANY WARRANTIES whatsoever, including any implied warranty of 
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  
 *
 * This source code is free and modifiable under the terms of 
 * GNU General Public License. (http://www.gnu.org/copyleft/gpl.html). See
 * the "license.txt" file for details, or visit the CollectiveAccess web site at
 * http://www.CollectiveAccess.org
 *
 * ----------------------------------------------------------------------
 */
$vs_id_prefix 		= $this->getVar('id_prefix').'_user';
$t_instance 		= $this->getVar('t_instance');
$t_item 			= $this->getVar('t_user');				// user
$t_subject 			= $this->getVar('t_subject');		
$settings 			= $this->getVar('settings');
$vs_add_label 		= $this->getVar('add_label');
$t_acl = new ca_acl();

//$vb_read_only		=	((isset($settings['readonly']) && $settings['readonly'])  || ($this->request->user->getBundleAccessLevel($t_instance->tableName(), 'ca_users') == __CA_BUNDLE_ACCESS_READONLY__));
$vb_read_only = false;

$va_initial_values = $this->getVar('initialValues');
if (!is_array($va_initial_values)) { $va_initial_values = array(); }	
?>
<div id="<?= $vs_id_prefix.$t_item->tableNum().'_rel'; ?>">
<?php
	//
	// The bundle template - used to generate each bundle in the form
	//
?>
	<textarea class='caItemTemplate' style='display: none;'>
		<div id="<?= $vs_id_prefix; ?>Item_{n}" class="labelInfo">
			<table class="caListItem">
				<tr>
					<td class="formLabel">
						<?= _t('User'); ?>
						<input type="text" size="60" name="<?= $vs_id_prefix; ?>_autocomplete{n}" value="{{label}}" id="<?= $vs_id_prefix; ?>_autocomplete{n}" class="lookupBg"/>
						<?= $t_acl->htmlFormElement('access', '^ELEMENT', array('name' => $vs_id_prefix.'_access_{n}', 'id' => $vs_id_prefix.'_access_{n}', 'value' => '{{access}}', 'no_tooltips' => true)); ?>
						<input type="hidden" name="<?= $vs_id_prefix; ?>_id{n}" id="<?= $vs_id_prefix; ?>_id{n}" value="{id}"/>
					</td>
					<td>
<?php
	if (!$vb_read_only) {
?>	
						<a href="#" class="caDeleteItemButton"><?= caNavIcon(__CA_NAV_ICON_DEL_BUNDLE__, 1); ?></a>
<?php
	}
?>
					</td>
				</tr>
			</table>
		</div>
	</textarea>
	
	<div class="bundleContainer">
		<div class="caItemList">
		
		</div>
<?php
	if (!$vb_read_only) {
?>	
		<div class='button labelInfo caAddItemButton'><a href='#'><?= caNavIcon(__CA_NAV_ICON_ADD__, '15px'); ?> <?= $vs_add_label ? $vs_add_label : _t("Add user access"); ?></a></div>
<?php
	}
?>
	</div>
</div>
			
<script type="text/javascript">
	jQuery(document).ready(function() {
		caUI.initRelationBundle('#<?= $vs_id_prefix.$t_item->tableNum().'_rel'; ?>', {
			fieldNamePrefix: '<?= $vs_id_prefix; ?>_',
			templateValues: ['label', 'effective_date', 'access', 'id'],
			initialValues: <?= json_encode($va_initial_values); ?>,
			itemID: '<?= $vs_id_prefix; ?>Item_',
			templateClassName: 'caItemTemplate',
			itemListClassName: 'caItemList',
			addButtonClassName: 'caAddItemButton',
			deleteButtonClassName: 'caDeleteItemButton',
			showEmptyFormsOnLoad: 0,
			readonly: <?= $vb_read_only ? "true" : "false"; ?>,
			autocompleteUrl: '<?= caNavUrl($this->request, 'lookup', 'User', 'Get', array()); ?>'
		});
	});
</script>
