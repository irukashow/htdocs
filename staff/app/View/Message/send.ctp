<?php
    echo $this->Html->script('nicEdit');
    //echo $this->Html->image('nicEditorIcons');
?>
<script type="text/javascript">
	//bkLib.onDomLoaded(function() { nicEditors.allTextAreas() });
</script>
<!-- 見出し -->
<div id='headline'>
    ★ メッセージの送信
</div>

<div id="">
<?php echo $this->Form->create(FALSE, array('name' => 'form')); ?>
    <table id="" border="0" width="40%" cellspacing="0" cellpadding="5" bordercolor="#333333" align="center" style="font-size: 90%;margin: 0px 0px 5px 0px;">
        <tr>
            <td>標題</td>
            <td>
                <?php echo $this->Form->input('title', array('type' => 'textbox', 'label' => false,  'div' => '', 'style' => 'width: 100%;')); ?>
            </td>  
            <td align="left">
                <?php echo $this->Form->input('editor', array('type' => 'checkbox', 'label' => 'エディタ',  'div' => '', 'onclick' => "toggleHtmlEditor(this.checked,'myArea3','full');")); ?>
            </td>
        </tr>
        <tr>
            <td style="vertical-align: -10px;">本文</td>
            <td align="left" colspan="2">
                <?php echo $this->Form->input('content', array('type' => 'textarea', 'label' => false, 'div' => 'float:left;', 'id' => 'myArea3', 'style' => 'width: 500px; height: 200px;margin-left:0px;')); ?>
            </td>
        </tr>
        <tr>
            <td></td>
            <td align="left" colspan="2">
                <?php echo $this->Form->submit('送　信', array('name' => 'send', 'style' => 'font-size:100%; padding:10px 15px 10px 15px;')); ?>
            </td>
        </tr>
    </table>

<?php echo $this->Form->end(); ?>
<script>
var html_editor = new Array();
/**
var html_editor_loaded = false;
function loadHtmlEditor() {
	if (!html_editor_loaded) {
		var scripts = document.getElementsByTagName('script');
		for (var i=0; i<scripts.length; i++) {
			if (scripts[i].src.search(/nicEdit\.js$/) != -1) return true;
		}
		var header = document.getElementsByTagName('head')[0];
		var loader = document.createElement('script');
		loader.setAttribute('type','text/javascript');
		//loader.setAttribute('src','../nicEdit.js');
                loader.setAttribute('src','../../js/nicEdit.js');
		header.appendChild(loader);
		html_editor_loaded = true;
	}
}
**/

function updateHtmlEditor(this_id) {
	if (html_editor[this_id] != null) {
		html_editor[this_id].updateInstance(this_id);
	}
}

function toggleHtmlEditor(open,this_id,panel_type) {
	if (open) {
		if (typeof nicEditor == "undefined") {
			loadHtmlEditor();
			setTimeout(function() { toggleHtmlEditor(open,this_id,panel_type) },500);
		} else {
			if (html_editor[this_id] == null) html_editor[this_id] = new nicEditor({panelType : panel_type}).panelInstance(this_id);
		}
	} else if (html_editor[this_id] != null) {
		html_editor[this_id].removeInstance(this_id);
		html_editor[this_id] = null;
	}
}

</script>	
</div>