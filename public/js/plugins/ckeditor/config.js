/**
 * @license Copyright (c) 2003-2014, CKSource - Frederico Knabben. All rights reserved.
 * For licensing, see LICENSE.md or http://ckeditor.com/license
 */

CKEDITOR.editorConfig = function( config ) {
    config.toolbar =
        [
            { name: 'basicstyles', items : [ 'Bold','Italic','Underline','Strike','Subscript','Superscript','-','RemoveFormat' ] },
            { name: 'paragraph', items : [ 'JustifyLeft','JustifyCenter','JustifyRight','JustifyBlock','-','NumberedList','BulletedList','-','Blockquote','CreateDiv',
                '-','Outdent','Indent' ] },
            { name: 'insert', items : [ 'Image','Flash','oembed','Table','HorizontalRule','SpecialChar','PageBreak' ] },
            { name: 'links', items : [ 'Link','Unlink','Anchor' ] },
            { name: 'clipboard', items : [ 'Cut','Copy','Paste','PasteText','PasteFromWord','-','Undo','Redo' ] },
            { name: 'editing', items : [ 'Find','Replace','-','SelectAll','-' ] },
            '/',
            { name: 'styles', items : [ 'Styles','Format','Font','FontSize' ] },
            { name: 'colors', items : [ 'TextColor','BGColor' ] },
            { name: 'tools', items : [ 'Maximize', 'ShowBlocks' ] },
            { name: 'document', items : [ 'Source' ] },
        ];

    config.extraPlugins = 'flash,widget,lineutils,oembed';

    config.allowedContent = true;
};
