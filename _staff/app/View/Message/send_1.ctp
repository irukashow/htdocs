<?php
    echo $this->Html->script('nicEdit');
    echo $this->Html->script('http://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js');
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
<?php echo $this->Form->create('Message2Staff', array('id' => 'form', 'enctype' => 'multipart/form-data', 'onsubmit' => "selectAll();selectAll2();")); ?>
    <table id="" border="0" width="65%" cellspacing="0" cellpadding="5" bordercolor="#333333" align="center" style="font-size: 90%;margin: 20px 0px 5px 30px;">
        <tr>
            <td width="80px">差出人</td>
            <td>
                <font style="font-size: 110%;"><?=$user_name ?></font>
                <?php echo $this->Form->input('id', array('type' => 'hidden', 'label' => false)); ?>
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
            <td style="vertical-align: middle;">宛先スタッフ</td>
            <td>
                <table>
                    <tr>
                        <td>
                    <?php echo $this->Form->input('recipient_staff', 
                            array('type' => 'select', 'multiple' => true, 'size' => 5, 'id' => 'cart', 'label' => false, 'div' => false, 'options' => $recipient_staff, 'style' => 'float:left;padding: 2px;font-size:90%;width:200px;')); ?>
                        </td>
                        <td align='center' width="100px">
                            <div>
                                <input type="button" id="move_left" value="←追　加">
                            </div>
                            <div style='margin-top: 10px;'>
                                <input type="button" id="move_right" value="削　除→">
                            </div>
                        </td>
                        <td width='250px'>
                            <?php echo $this->Form->input('search_staff_name', array('label' => false, 'div' => false, 'placeholder'=>'検索する氏名を入力してください', 'style' => 'width: 150px;')); ?>
                        <?php echo $this->Form->submit('検索', 
                                array('name' => 'search', 'div' => false, 'id' => 'button-delete', 'style' => 'font-size:110%; padding:0px 15px 0px 15px;')); ?><br>
                    <!--
                            <input type="button" id="search" value="検索">
                    -->
                        <?php echo $this->Form->input('recipient_staff_list', 
                                array('type' => 'select', 'multiple' => true, 'id' => 'showcase', 'label' => false, 'div' => false, 'options' => $staff_array, 'style' => 'margin-top:5px;padding: 2px;font-size:90%;width:200px;')); ?>
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
                <?php echo $this->Form->submit('保存する', array('name' => 'draft', 'div' => false, 'id' => '', 'style' => 'font-size:110%; padding:7px 15px 7px 15px;')); ?>
                &nbsp;&nbsp;
                <a href='<?=ROOTDIR ?>/message/index' id='button-delete'>キャンセル</a>
            </td>
        </tr>
    </table>

<?php echo $this->Form->end(); ?>
    
<script>
jQuery(function ($) {
	// 要素を移動する関数（まだ仮） */
	function moveOption(event) {
		$("#" + event.data.from + " option:selected").each(function () {
			$(this).appendTo($("#" + event.data.to));
			$(this).prop("selected", false);// 選択状態の解除
		});
	}

	// 「←追加」ボタンのクリック時
	$("#move_left").on("click", {from: "showcase", to: "cart"}, moveOption);

	// 「削除→」ボタンのクリック時
	$("#move_right").on("click", {from: "cart", to: "showcase"}, moveOption);

	// 送信時は、「カート」側のオプションを選択状態にする
	$("#form").on("submit", function (event) {
		$("#cart").children().prop("selected", true);
                $("#showcase").children().prop("selected", true);
	});
});
</script>
<script>
var html_editor = new Array();
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