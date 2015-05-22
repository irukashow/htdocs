<?php
    echo $this->Html->css( 'main');  
?>

<!-- content start -->
<br />
<div style="margin-top: 50px;margin-bottom: 50px;">

<center>
    <table cellspacing="5" cellpadding="5" border="2" align="center" id="stuff_master">
 <tr>    
     <td>   
<table cellspacing="10" cellpadding="20" border="0" align="center" style="background-color: #ccffcc;">
    <tr><td nowrap>&nbsp;</td></tr>
    <tr>
        <td style="width:5em;">&nbsp;</td>
    <td style="text-align: center;width:15em;"><b>株式会社ソフトライフ</b></td>
    <td style="width:5em;">&nbsp;</td>
    </tr>

    <?php echo $this->Form->create('User'); ?>
    
    <tr>
        <td>&nbsp;</td>
        <td>
            <!-- 名前コンボの値セット START -->
            <div class="input select required">
                <label for="UserUsername">名前</label><br>
                <select name="data[User][username]" id="UserUsername" required="required" style="font-size: 120%;">
                    <option value="">(あなたのお名前)</option>      
            <?php foreach ($datas as $data): ?>
                    <option value="<?= $data['User']['username'] ?>"><?=$data['User']['name_sei'] ?> <?=$data['User']['name_mei'] ?></option> 
            <?php endforeach; ?>
                </select>
            </div>
            <!-- 名前コンボの値セット END -->

        </td>
        <td>&nbsp;</td> 
    </tr>

    <tr>
        <td>&nbsp;</td>
        <td><?=$this->Form->input('password', array('label' => 'パスワード','type' => 'password'))?></td>
        <td>&nbsp;</td>
    </tr>
    
    <tr>
        <td>&nbsp;</td>
        <td style="text-align: center;">
            <?=$this->Form->end(array('label' => 'ログイン','div' => false));?>
        <td>&nbsp;</td>
    </tr>
    <tr><td nowrap>&nbsp;</td></tr>
    </table>
    </td>
    </tr>
    </form>
    </table>
</td>
</tr>
</table>
</center>
<!-- content end -->
                </td>
            </tr>
        </table>

</form>
</div>



