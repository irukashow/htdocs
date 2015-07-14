<?php
    echo $this->Html->script('nicEdit');
    echo $this->Html->script('http://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js');
    //echo $this->Html->image('nicEditorIcons');
    echo $this->Html->css('message');
?>
<script type="text/javascript">
	//bkLib.onDomLoaded(function() { nicEditors.allTextAreas() });
</script>
<script type="text/javascript">
function addSelectItem() {
    //選択された項目番号
    index = document.getElementById('Message2StaffRecipientStaffList').selectedIndex;
    itemVal = document.getElementById('Message2StaffRecipientStaffList').value;
    itemStr = document.getElementById('Message2StaffRecipientStaffList').options[index].text;
    document.getElementById('Message2StaffRecipientStaffList').removeChild(document.getElementById('Message2StaffRecipientStaffList').options[index]);

    len = document.getElementById('Message2StaffRecipientStaff').options.length;
    document.getElementById('Message2StaffRecipientStaff').options[len] = new Option(itemStr, itemVal);
    return false;
}
function removeSelectItem() {
    //選択された項目番号
    index = document.getElementById('Message2StaffRecipientStaff').selectedIndex;
    itemVal = document.getElementById('Message2StaffRecipientStaff').value;
    itemStr = document.getElementById('Message2StaffRecipientStaff').options[index].text;
    document.getElementById('Message2StaffRecipientStaff').removeChild(document.getElementById('Message2StaffRecipientStaff').options[index]);

    len = document.getElementById('Message2StaffRecipientStaffList').options.length;
    document.getElementById('Message2StaffRecipientStaffList').options[len] = new Option(itemStr, itemVal);
    return false;
}
function selectAll() {
    var select = document.getElementById('Message2StaffRecipientStaff');
    var o = select.options;
    var i, L;
    for (i = 0, L = o.length; i < L; ++i) {
        select.options[i].selected = true;
    }
}
</script>

<!-- 見出し -->
<div id='headline'>
    ★ メッセージの送信
</div>

<div style="border:1px solid black;background-color: #ffffea;padding: 10px 10px 30px 10px;">
<?php echo $this->Form->create('Message2Staff', array('name' => 'form', 'onsubmit' => "selectAll();")); ?>
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
            <td>宛先スタッフ</td>
            <td>
                <table>
                    <tr>
                        <td>
                    <?php echo $this->Form->input('recipient_staff', array('type' => 'select', 'multiple' => true, 'size' => 5, 'label' => false, 'div' => false, 'options' => null, 'style' => 'float:left;padding: 2px;font-size:90%;width:200px;')); ?>
                        </td>
                        <td align='center' width="100px">
                    <?php echo $this->Html->link('←追加', '#', array('name' => 'left', 'id' => 'button-create', 'onclick' => 'addSelectItem()', 'style' => 'font-size:110%; padding:5px 15px 5px 15px;')); ?>
                    <br><br>
                        <?php echo $this->Html->link('削除→', '#', array('name' => 'right', 'id' => 'button-create', 'onclick' => 'removeSelectItem()', 'style' => 'font-size:110%; padding:5px 15px 5px 15px;')); ?>
                        </td>
                        <td>
                    <?php echo $this->Form->input('search_staff_name', array('label' => false, 'div' => false, 'placeholder'=>'検索する氏名を入力してください', 'style' => 'width: 130px;')); ?>
                    <?php echo $this->Form->submit('検索', array('name' => 'search', 'div' => false, 'id' => 'button-delete', 'style' => 'font-size:110%; padding:0px 15px 0px 15px;')); ?><br>
                    <?php echo $this->Form->input('recipient_staff_list', array('type' => 'select', 'multiple' => true, 'label' => false, 'div' => false, 'options' => $staff_array, 'style' => 'float:left;padding: 2px;font-size:90%;width:200px;')); ?>
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

	// 「カートへ→」ボタンのクリック時
	$("#move_right").on("click", {from: "showcase", to: "cart"}, moveOption);

	// 「←棚へ戻す」ボタンのクリック時
	$("#move_left").on("click", {from: "cart", to: "showcase"}, moveOption);

	// 送信時は、「カート」側のオプションを選択状態にする
	$("#form1").on("submit", function (event) {
		$("#cart").children().prop("selected", true);
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