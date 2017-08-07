/**
 * @license Copyright (c) 2003-2017, CKSource - Frederico Knabben. All rights reserved.
 * For licensing, see LICENSE.md or http://ckeditor.com/license
 */

CKEDITOR.editorConfig = function (config) {
	config.toolbarGroups = [
		{ name: 'document', groups: ['mode', 'document', 'doctools'] },
		{ name: 'styles', groups: ['styles'] },
		{ name: 'basicstyles', groups: ['basicstyles', 'cleanup'] },
		{ name: 'paragraph', groups: ['list', 'indent', 'blocks', 'align', 'bidi', 'paragraph'] },
		{ name: 'clipboard', groups: ['undo', 'clipboard'] },
		'/',
		{ name: 'editing', groups: ['find', 'selection', 'spellchecker', 'editing'] },
		{ name: 'forms', groups: ['forms'] },
		{ name: 'links', groups: ['links'] },
		{ name: 'insert', groups: ['insert'] },
		{ name: 'colors', groups: ['colors'] },
		{ name: 'tools', groups: ['tools'] },
		{ name: 'others', groups: ['others'] },
		{ name: 'about', groups: ['about'] }
	];

	config.removeButtons = 'Save,NewPage,Preview,Print,Form,Checkbox,Radio,Templates,TextField,Textarea,Button,ImageButton,HiddenField,Outdent,Indent,CreateDiv,Language,BidiRtl,BidiLtr,Flash,Iframe,Styles,About,Select,PasteFromWord,Font';

	config.extraPlugins = 'uploadimage';
	config.extraPlugins = 'uploadwidget';

	config.filebrowserBrowseUrl = '/kcfinder/browse.php?opener=ckeditor&type=files';
	config.filebrowserImageBrowseUrl = '/kcfinder/browse.php?opener=ckeditor&type=images';
	config.filebrowserImageUploadUrl = '/admin/upload/imageEditor';

	config.language = 'pt-br';
	config.height = 350;
	config.toolbarCanCollapse = true;
};