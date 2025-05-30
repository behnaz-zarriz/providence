<?php
/* ----------------------------------------------------------------------
 * bundles/ca_representation_annotation_labels_preferred.php : 
 * ----------------------------------------------------------------------
 * CollectiveAccess
 * Open-source collections management software
 * ----------------------------------------------------------------------
 *
 * Software by Whirl-i-Gig (http://www.whirl-i-gig.com)
 * Copyright 2009-2022 Whirl-i-Gig
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
 
	$vs_id_prefix 		= $this->getVar('placement_code').$this->getVar('id_prefix');
	$va_labels 			= $this->getVar('labels');
	$t_label 			= $this->getVar('t_label');
	/** @var BundlableLabelableBaseModelWithAttributes $t_subject */
	$t_subject			= $this->getVar('t_subject');
	$va_initial_values 	= $this->getVar('label_initial_values');
	if (!$va_force_new_labels = $this->getVar('new_labels')) { $va_force_new_labels = array(); }	// list of new labels not saved due to error which we need to for onto the label list as new

	$settings 			= $this->getVar('settings');
	$vs_add_label 		=	$this->getVar('add_label');
	
	$vb_read_only		= ((isset($settings['readonly']) && $settings['readonly'])  || ($this->request->user->getBundleAccessLevel('ca_representation_annotations', 'preferred_labels') == __CA_BUNDLE_ACCESS_READONLY__));
	
	$locale_list		= $this->getVar('locale_list');
	
	$vb_batch			= $this->getVar('batch');

	if ($vb_batch) {
		print caBatchEditorPreferredLabelsModeControl($t_label, $vs_id_prefix);
	} else {
		print caEditorBundleShowHideControl($this->request, $vs_id_prefix.'Labels', $settings, caInitialValuesArrayHasValue($vs_id_prefix.'Labels', $va_initial_values));
	}
	print caEditorBundleMetadataDictionary($this->request, $vs_id_prefix.'Labels', $settings);
?>
<div id="<?= $vs_id_prefix; ?>Labels" <?= $vb_batch ? "class='editorBatchBundleContent'" : ''; ?>>
<?php
	//
	// The bundle template - used to generate each bundle in the form
	//
?>
	<textarea class='caLabelTemplate' style='display: none;'>
		<div id="{fieldNamePrefix}Label_{n}" class="labelInfo">
			<div style="float: right;">
				<a href="#" class="caDeleteLabelButton"><?= caNavIcon(__CA_NAV_ICON_DEL_BUNDLE__, 1); ?></a>
			</div>
			
			<?= $t_label->htmlFormElement('name', "^ELEMENT", array_merge($settings, array('name' => "{fieldNamePrefix}name_{n}", 'id' => "{fieldNamePrefix}name_{n}", "value" => "{{name}}", 'no_tooltips' => true, 'textAreaTagName' => 'textentry', 'readonly' => $vb_read_only))); ?>
			<br/>

			<?php print '<div class="formLabel">'.$locale_list; ?>
			<?php print $t_label->htmlFormElement('type_id', "^LABEL ^ELEMENT", array('classname' => 'labelType', 'id' => "{fieldNamePrefix}type_id_{n}", 'name' => "{fieldNamePrefix}type_id_{n}", "value" => "{type_id}", 'no_tooltips' => true, 'list_code' => $this->request->config->get('ca_representation_annotations_preferred_label_type_list'), 'dont_show_null_value' => true, 'hide_select_if_no_options' => true)).'</div>'; ?>
		</div>
	</textarea>
	
	<div class="bundleContainer">
		<div class="caLabelList">
		
		</div>
		<div class="button labelInfo caAddLabelButton"><a href='#'><?= caNavIcon(__CA_NAV_ICON_ADD__, '15px'); ?> <?= $vs_add_label ? $vs_add_label : _t("Add label"); ?></a></div>
	</div>
</div>
<script type="text/javascript">
	caUI.initLabelBundle('#<?= $vs_id_prefix; ?>Labels', {
		mode: 'nonpreferred',
		fieldNamePrefix: '<?= $vs_id_prefix; ?>',
		templateValues: ['name', 'locale_id', 'type_id'],
		initialValues: <?= json_encode($va_initial_values); ?>,
		forceNewValues: <?= json_encode($va_force_new_labels); ?>,
		labelID: 'Label_',
		localeClassName: 'labelLocale',
		templateClassName: 'caLabelTemplate',
		labelListClassName: 'caLabelList',
		addButtonClassName: 'caAddLabelButton',
		deleteButtonClassName: 'caDeleteLabelButton',
		bundlePreview: <?= caEscapeForBundlePreview($this->getVar('bundle_preview')); ?>,
		readonly: <?= $vb_read_only ? "1" : "0"; ?>,
		defaultLocaleID: <?= ca_locales::getDefaultCataloguingLocaleID(); ?>
	});
</script>
