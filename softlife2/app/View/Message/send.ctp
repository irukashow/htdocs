<?php
    echo $this->Html->script('nicEdit');
    //echo $this->Html->image('nicEditorIcons');
    echo $this->Html->css('message');
?>
<script type="text/javascript">
	//bkLib.onDomLoaded(function() { nicEditors.allTextAreas() });
</script>
<!-- 見出し -->
<div id='headline'>
    ★ メッセージの送信
</div>

<div style="border:1px solid black;background-color: #ffffea;padding: 10px 10px 30px 10px;">
<?php echo $this->Form->create('Message2Staff', array('name' => 'form')); ?>
    <table id="" border="0" width="65%" cellspacing="0" cellpadding="5" bordercolor="#333333" align="center" style="font-size: 90%;margin: 20px 0px 5px 30px;">
        <tr>
            <td width="80px">差出人</td>
            <td>
                <font style="font-size: 110%;"><?=$user_name ?></font>
                <?php echo $this->Form->input('username', array('type' => 'hidden', 'label' => false, 'value' => $username)); ?>
                <?php echo $this->Form->input('name', array('type' => 'hidden', 'label' => false, 'value' => $user_name)); ?>
                <?php echo $this->Form->input('class', array('type' => 'hidden', 'label' => false, 'value' => $selected_class)); ?>
            </td>
        </tr>
        <tr>
            <td>標題</td>
            <td>
                <?php echo $this->Form->input('title', array('label' => false, 'style' => 'width: 100%;')); ?>
            </td>  
            <td align="left">
                <?php echo $this->Form->input('editor', array('type' => 'checkbox', 'label' => 'エディタ',  'div' => '', 'onclick' => "toggleHtmlEditor(this.checked,'myArea3','full');")); ?>
            </td>
        </tr>
        <tr>
            <td style="vertical-align: -10px;">本文</td>
            <td align="left" colspan="2">
                <?php echo $this->Form->input('body', 
                        array('type' => 'textarea', 'label' => false, 'div' => 'float:left;', 'id' => 'myArea3', 'style' => 'width: 700px; height: 200px;margin-left:0px;')); ?>
            </td>
        </tr>
        <tr>
            <td style="vertical-align: middle;">添付ファイル<br><span style="font-size: 90%;">※３つまで</span></td>
            <td>
                <?php echo $this->Form->input(false, array('type' => 'file', 'name' => 'attachment[]', 'label' => false, 'style' => 'width: 100%;')); ?>
                <?php echo $this->Form->input(false, array('type' => 'file', 'name' => 'attachment[]','label' => false, 'style' => 'width: 100%;')); ?>
                <?php echo $this->Form->input(false, array('type' => 'file', 'name' => 'attachment[]','label' => false, 'style' => 'width: 100%;')); ?>
            </td>
        </tr>
        <tr>
            <td>宛先スタッフ</td>
            <td>
                <table>
                    <tr>
                        <td>
                    <?php echo $this->Form->input('recipient_staff', array('type' => 'select', 'multiple' => true, 'size' => 5, 'label' => false, 'div' => false, 'options' => null, 'style' => 'float:left;padding: 2px;width:200px;')); ?>
                        </td>
                        <td width="50px">
                    <?php echo $this->Form->submit('←追加', array('name' => 'search', 'div' => false, 'id' => '', 'style' => 'float: left; font-size:110%; padding:0px 15px 0px 15px;')); ?>
                    <br><br>
                        <?php echo $this->Form->submit('削除→', array('name' => 'search', 'div' => false, 'id' => '', 'style' => 'float: left; font-size:110%; padding:0px 15px 0px 15px;')); ?>
                        </td>
                        <td>
                    <?php echo $this->Form->input('search_staff_name', array('label' => false, 'div' => false, 'placeholder'=>'検索する氏名を入力してください', 'style' => 'width: 130px;')); ?>
                    <?php echo $this->Form->submit('検索', array('name' => 'search', 'div' => false, 'id' => 'button-delete', 'style' => 'font-size:110%; padding:0px 15px 0px 15px;')); ?><br>
                    <?php echo $this->Form->input('recipient_staff', array('type' => 'select', 'multiple' => true, 'label' => false, 'div' => false, 'options' => $staff_array, 'style' => 'float:left;padding: 2px;font-size:90%;width:200px;')); ?>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
        <tr>
            <td></td>
            <td align="left" colspan="2">
                <?php echo $this->Form->submit('送信する', array('name' => 'send', 'div' => false, 'id' => 'button-send', 'style' => 'font-size:110%; padding:10px 15px 10px 15px;')); ?>
                &nbsp;&nbsp;
                <a href='<?=ROOTDIR ?>/message/index' id='button-delete'>キャンセル</a>
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