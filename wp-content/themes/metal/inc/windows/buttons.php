<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js?ver=3.4.1"></script>  
<script type="text/javascript" src="/wp-includes/js/tinymce/tiny_mce_popup.js"></script>
<script>
	jQuery('.btn').live('click', function() {
		var s=prompt("Button", "Link:");
	    tinyMCEPopup.editor.execCommand('mceInsertContent', false, '<a class=\''+jQuery(this).attr('class')+'\' href=\''+s+'\'>text</a>' ) ;
	    tinyMCEPopup.close();
	});
</script>
<style>
	table {
		width:100%;
	}
	table td{
		text-align:center;
	}
	table tr {
		height:40px;
	}
	.btn {
		-webkit-border-radius: 4px;
-moz-border-radius: 4px;
border-radius: 4px; 
		cursor: pointer;
		display: inline-block !important;
		font-size: 14px;
		text-decoration: none;
		-moz-border-bottom-colors: none;
		-moz-border-image: none;
		-moz-border-left-colors: none;
		-moz-border-right-colors: none;
		-moz-border-top-colors: none;
		border-style: solid;
		border-width: 1px;
		text-shadow: 0 1px 0 #ECCF94;
	}
	.btn.small {
		padding: 2px 15px;
	}
	.btn.medium {
		padding: 5px 18px;
	}
	.btn.big {
		padding: 10px 22px;
	}
	.btn.orange {
		background: rgb(254,0,0); /* Old browsers */
		background: -moz-linear-gradient(top, rgba(254,193,35,1) 0%, rgba(232,120,1,1) 100%); /* FF3.6+ */
		background: -webkit-gradient(linear, left top, left bottom, color-stop(0%,rgba(254,193,35,1)), color-stop(100%,rgba(232,120,1,1))); /* Chrome,Safari4+ */
		background: -webkit-linear-gradient(top, rgba(254,193,35,1) 0%,rgba(232,120,1,1) 100%); /* Chrome10+,Safari5.1+ */
		background: -o-linear-gradient(top, rgba(254,193,35,1) 0%,rgba(232,120,1,1) 100%); /* Opera11.10+ */
		background: -ms-linear-gradient(top, rgba(254,193,35,1) 0%,rgba(232,120,1,1) 100%); /* IE10+ */
		background: linear-gradient(top, rgba(254,193,35,1) 0%,rgba(232,120,1,1) 100%); /* W3C */
		filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#fec123', endColorstr='#e87801',GradientType=0 ); /* IE6-9 */
		box-shadow: 0 1px 2px #D1D1D1, 0 1px 0 #FEE09D inset;
		border-color: #FEB304 #E47A13 #C1780F;
		color: #773101 !important;
	}
	.btn.orange:hover {
		background: rgb(232,120,1); /* Old browsers */
		background: -moz-linear-gradient(top, rgba(232,120,1,1) 0%, rgba(254,193,35,1) 100%); /* FF3.6+ */
		background: -webkit-gradient(linear, left top, left bottom, color-stop(0%,rgba(232,120,1,1)), color-stop(100%,rgba(254,193,35,1))); /* Chrome,Safari4+ */
		background: -webkit-linear-gradient(top, rgba(232,120,1,1) 0%,rgba(254,193,35,1) 100%); /* Chrome10+,Safari5.1+ */
		background: -o-linear-gradient(top, rgba(232,120,1,1) 0%,rgba(254,193,35,1) 100%); /* Opera11.10+ */
		background: -ms-linear-gradient(top, rgba(232,120,1,1) 0%,rgba(254,193,35,1) 100%); /* IE10+ */
		background: linear-gradient(top, rgba(232,120,1,1) 0%,rgba(254,193,35,1) 100%); /* W3C */
		filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#e87801', endColorstr='#fec123',GradientType=0 ); /* IE6-9 */
		border-color: #FEB304 #E47A13 #C1780F;
	}
	.btn.green {
		background: rgb(254,0,0); /* Old browsers */
		background: -moz-linear-gradient(top, rgba(154,254,35,1) 0%, rgba(126,166,17,1) 100%); /* FF3.6+ */
		background: -webkit-gradient(linear, left top, left bottom, color-stop(0%,rgba(154,254,35,1)), color-stop(100%,rgba(126,166,17,1))); /* Chrome,Safari4+ */
		background: -webkit-linear-gradient(top, rgba(154,254,35,1) 0%,rgba(126,166,17,1) 100%); /* Chrome10+,Safari5.1+ */
		background: -o-linear-gradient(top, rgba(154,254,35,1) 0%,rgba(126,166,17,1) 100%); /* Opera11.10+ */
		background: -ms-linear-gradient(top, rgba(154,254,35,1) 0%,rgba(126,166,17,1) 100%); /* IE10+ */
		background: linear-gradient(top, rgba(154,254,35,1) 0%,rgba(126,166,17,1) 100%); /* W3C */
		filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#9afe23', endColorstr='#7ea611',GradientType=0 ); /* IE6-9 */
		box-shadow: 0 1px 2px #D1D1D1, 0 1px 0 #d0fc9d inset;
		border-color: #89fc05 #82e312 #6fc210;
		color: #2c5300 !important;
	}
	.btn.green:hover {
		background: rgb(254,0,0); /* Old browsers */
		background: -moz-linear-gradient(top, rgba(126,166,17,1) 0%, rgba(154,254,35,1) 100%); /* FF3.6+ */
		background: -webkit-gradient(linear, left top, left bottom, color-stop(0%,rgba(126,166,17,1)), color-stop(100%,rgba(154,254,35,1))); /* Chrome,Safari4+ */
		background: -webkit-linear-gradient(top, rgba(126,166,17,1) 0%,rgba(154,254,35,1) 100%); /* Chrome10+,Safari5.1+ */
		background: -o-linear-gradient(top, rgba(126,166,17,1) 0%,rgba(154,254,35,1) 100%); /* Opera11.10+ */
		background: -ms-linear-gradient(top, rgba(126,166,17,1) 0%,rgba(154,254,35,1) 100%); /* IE10+ */
		background: linear-gradient(top, rgba(126,166,17,1) 0%,rgba(154,254,35,1) 100%); /* W3C */
		filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#7ea611', endColorstr='#9afe23',GradientType=0 ); /* IE6-9 */
	}
	.btn.blue {
		background: rgb(254,0,0); /* Old browsers */
		background: -moz-linear-gradient(top, rgba(98,187,255,1) 0%, rgba(17,101,166,1) 100%); /* FF3.6+ */
		background: -webkit-gradient(linear, left top, left bottom, color-stop(0%,rgba(98,187,255,1)), color-stop(100%,rgba(17,101,166,1))); /* Chrome,Safari4+ */
		background: -webkit-linear-gradient(top, rgba(98,187,255,1) 0%,rgba(17,101,166,1) 100%); /* Chrome10+,Safari5.1+ */
		background: -o-linear-gradient(top, rgba(98,187,255,1) 0%,rgba(17,101,166,1) 100%); /* Opera11.10+ */
		background: -ms-linear-gradient(top, rgba(98,187,255,1) 0%,rgba(17,101,166,1) 100%); /* IE10+ */
		background: linear-gradient(top, rgba(98,187,255,1) 0%,rgba(17,101,166,1) 100%); /* W3C */
		filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#62bbff', endColorstr='#1165a6',GradientType=0 ); /* IE6-9 */
		box-shadow: 0 1px 2px #D1D1D1, 0 1px 0 #9dd3fc inset;
		border-color: #84c9fe #4ea3e5 #1075c2;
		color: #003054 !important;
	}
	.btn.blue:hover {
		background: rgb(254,0,0); /* Old browsers */
		background: -moz-linear-gradient(top, rgba(17,101,166,1) 0%, rgba(35,159,254,1) 100%); /* FF3.6+ */
		background: -webkit-gradient(linear, left top, left bottom, color-stop(0%,rgba(17,101,166,1)), color-stop(100%,rgba(35,159,254,1))); /* Chrome,Safari4+ */
		background: -webkit-linear-gradient(top, rgba(17,101,166,1) 0%,rgba(35,159,254,1) 100%); /* Chrome10+,Safari5.1+ */
		background: -o-linear-gradient(top, rgba(17,101,166,1) 0%,rgba(35,159,254,1) 100%); /* Opera11.10+ */
		background: -ms-linear-gradient(top, rgba(17,101,166,1) 0%,rgba(35,159,254,1) 100%); /* IE10+ */
		background: linear-gradient(top, rgba(17,101,166,1) 0%,rgba(35,159,254,1) 100%); /* W3C */
		filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#1165a6', endColorstr='#239ffe',GradientType=0 ); /* IE6-9 */
		
	}
	.btn.white {
		background: rgb(254,0,0); /* Old browsers */
		background: -moz-linear-gradient(top, rgba(252,252,252,1) 0%, rgba(166,166,166,1) 100%); /* FF3.6+ */
		background: -webkit-gradient(linear, left top, left bottom, color-stop(0%,rgba(252,252,252,1)), color-stop(100%,rgba(166,166,166,1))); /* Chrome,Safari4+ */
		background: -webkit-linear-gradient(top, rgba(252,252,252,1) 0%,rgba(166,166,166,1) 100%); /* Chrome10+,Safari5.1+ */
		background: -o-linear-gradient(top, rgba(252,252,252,1) 0%,rgba(166,166,166,1) 100%); /* Opera11.10+ */
		background: -ms-linear-gradient(top, rgba(252,252,252,1) 0%,rgba(166,166,166,1) 100%); /* IE10+ */
		background: linear-gradient(top, rgba(252,252,252,1) 0%,rgba(166,166,166,1) 100%); /* W3C */
		filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#fcfcfc', endColorstr='#a6a6a6',GradientType=0 ); /* IE6-9 */
		box-shadow: 0 1px 2px #D1D1D1, 0 1px 0 #ffffff inset;
		border-color: #fcfcfc #e5e5e5 #c2c2c2;
		color: #003054 !important;
	}
	.btn.white:hover {
		background: rgb(254,0,0); /* Old browsers */
		background: -moz-linear-gradient(top, rgba(166,166,166,1) 0%, rgba(252,252,252,1) 100%); /* FF3.6+ */
		background: -webkit-gradient(linear, left top, left bottom, color-stop(0%,rgba(166,166,166,1)), color-stop(100%,rgba(252,252,252,1))); /* Chrome,Safari4+ */
		background: -webkit-linear-gradient(top, rgba(166,166,166,1) 0%,rgba(252,252,252,1) 100%); /* Chrome10+,Safari5.1+ */
		background: -o-linear-gradient(top, rgba(166,166,166,1) 0%,rgba(252,252,252,1) 100%); /* Opera11.10+ */
		background: -ms-linear-gradient(top, rgba(166,166,166,1) 0%,rgba(252,252,252,1) 100%); /* IE10+ */
		background: linear-gradient(top, rgba(166,166,166,1) 0%,rgba(252,252,252,1) 100%); /* W3C */
		filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#a6a6a6', endColorstr='#fcfcfc',GradientType=0 ); /* IE6-9 */
	}
	.btn.black {
		background: rgb(254,0,0); /* Old browsers */
		background: -moz-linear-gradient(top, rgba(173,173,173,1) 0%, rgba(87,87,87,1) 100%); /* FF3.6+ */
		background: -webkit-gradient(linear, left top, left bottom, color-stop(0%,rgba(173,173,173,1)), color-stop(100%,rgba(87,87,87,1))); /* Chrome,Safari4+ */
		background: -webkit-linear-gradient(top, rgba(173,173,173,1) 0%,rgba(87,87,87,1) 100%); /* Chrome10+,Safari5.1+ */
		background: -o-linear-gradient(top, rgba(173,173,173,1) 0%,rgba(87,87,87,1) 100%); /* Opera11.10+ */
		background: -ms-linear-gradient(top, rgba(173,173,173,1) 0%,rgba(87,87,87,1) 100%); /* IE10+ */
		background: linear-gradient(top, rgba(173,173,173,1) 0%,rgba(87,87,87,1) 100%); /* W3C */
		filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#adadad', endColorstr='#565656',GradientType=0 ); /* IE6-9 */
		box-shadow: 0 1px 2px #D1D1D1, 0 1px 0 #a8a8a8 inset;
		border-color: #a6a6a6 #8f8f8f #6b6b6b;
		text-shadow: 0 1px 0 #474747;
		color: #e9e9e9 !important;
	}
	.btn.black:hover {
		background: rgb(254,0,0); /* Old browsers */
		background: -moz-linear-gradient(top, rgba(87,87,87,1) 0%, rgba(173,173,173,1) 100%); /* FF3.6+ */
		background: -webkit-gradient(linear, left top, left bottom, color-stop(0%,rgba(166,166,166,1)), color-stop(100%,rgba(252,252,252,1))); /* Chrome,Safari4+ */
		background: -webkit-linear-gradient(top, rgba(166,166,166,1) 0%,rgba(252,252,252,1) 100%); /* Chrome10+,Safari5.1+ */
		background: -o-linear-gradient(top, rgba(166,166,166,1) 0%,rgba(252,252,252,1) 100%); /* Opera11.10+ */
		background: -ms-linear-gradient(top, rgba(166,166,166,1) 0%,rgba(252,252,252,1) 100%); /* IE10+ */
		background: linear-gradient(top, rgba(166,166,166,1) 0%,rgba(252,252,252,1) 100%); /* W3C */
		filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#a6a6a6', endColorstr='#fcfcfc',GradientType=0 ); /* IE6-9 */
	}
</style>
<table>
<tr>
	<td><a class='btn orange small'>text</a></td>
	<td><a class='btn green small'>text</a></td>
	<td><a class='btn blue small'>text</a></td>
	<td><a class='btn white small'>text</a></td>
	<td><a class='btn black small'>text</a></td>
</tr>
<tr>
	<td><a class='btn orange medium'>text</a></td>
	<td><a class='btn green medium'>text</a></td>
	<td><a class='btn blue medium'>text</a></td>
	<td><a class='btn white medium'>text</a></td>
	<td><a class='btn black medium'>text</a></td>
</tr>
<tr>
	<td><a class='btn orange big'>text</a></td>
	<td><a class='btn green big'>text</a></td>
	<td><a class='btn blue big'>text</a></td>
	<td><a class='btn white big'>text</a></td>
	<td><a class='btn black big'>text</a></td>
</tr>
</table>