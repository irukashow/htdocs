<?php
    echo $this->Html->script('nicEdit');
    echo $this->Html->script( 'tools');
    //echo $this->Html->script('dropzone');
    echo $this->Html->script('jquery-1.9.1');
    echo $this->Html->script('station');
?>

<!-- for Datepicker -->
<link type="text/css" rel="stylesheet"
  href="http://code.jquery.com/ui/1.10.3/themes/cupertino/jquery-ui.min.css" />
<script type="text/javascript"
  src="http://code.jquery.com/jquery-1.10.2.min.js"></script>
<script type="text/javascript"
  src="http://code.jquery.com/ui/1.10.3/jquery-ui.min.js"></script>
<!--1国際化対応のライブラリをインポート-->
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.10.3/i18n/jquery-ui-i18n.min.js"></script>
<script type="text/javascript">
$(function() {
  // 2日本語を有効化
  $.datepicker.setDefaults($.datepicker.regional['ja']);
  // 3日付選択ボックスを生成
  $('.date').datepicker({ dateFormat: 'yy/mm/dd' });
});
</script>

<div style="width:60%;margin-top: 20px;margin-left: auto; margin-right: auto;">
<?php echo $this->Form->create('Admin'); ?>
    <fieldset style="border:none;margin-bottom: 20px;">
        <legend style="font-size: 150%;color: red;"><?php echo __('管理者からのお知らせ入力ページ'); ?></legend>

        <table border='1' cellspacing="0" cellpadding="5" style="width:100%;margin-top: 10px;border-spacing: 0px;">
            <tr>
                <th style='background:#99ccff;text-align: center;'>項目</th>
                <th style='background:#99ccff;text-align: center;'>入力内容</th>
            </tr>
            <tr>
                <td style='background-color: #e8ffff;width:20%;'>対象バージョン</td>
                <td>
                    <?php echo $this->Form->input('version_no',array('label'=>false,'div'=>false,'maxlength'=>'20','style'=>'width:20%;')); ?>
                </td>
            </tr>
            <tr>
                <td style='background-color: #e8ffff;width:20%;'>種別</td>
                <td>
                    <?php  
                        $select1=array(''=>'','1'=>'緊急','2'=>'お知らせ','3'=>'その他');
                        echo $this->Form->input( 'status', array( 'label'=>false,'type' => 'select', 'div'=>false,'legend'=>false,'style' => 'float:none;', 'options' => $select1));
                    ?>
                </td>
            </tr>
            <tr>
                <td style='background-color: #e8ffff;width:20%;'>タイトル</td>
                <td>
                    <?php echo $this->Form->input('title',array('label'=>false,'div'=>false,'style'=>'width:60%;')); ?>
                </td>
            </tr>
            <tr>
                <td style='background-color: #e8ffff;width:20%;'>メッセージの内容</td>
                <td>
                    <?php echo $this->Form->input('remarks',array('type' => 'textarea','label'=>false, 'id' => 'myArea3','div'=>'float:left;','style'=>'width:90%;', 'rows' => '20')); ?>
                    <?php echo $this->Form->input('editor', array('type' => 'checkbox', 'label' => 'エディタ', 'div'=>false, 
                        'onclick' => "toggleHtmlEditor(this.checked,'myArea3','full');")); ?>
                </td>
            </tr>
        </table>


    </fieldset>
    <div style='margin-left: 10px;'>
<?php echo $this->Form->submit('登録する', array('name' => 'submit','div' => false)); ?>
    &nbsp;&nbsp;
<?php print($this->Html->link('キャンセル', './index', array('id'=>'button-delete'))); ?>
    </div>
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
