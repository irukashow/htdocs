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
    <tr><td colspan="3">&nbsp;</td></tr>
    <tr>
        <td style="width:5em;">&nbsp;</td>
    <td style="text-align: center;width:15em;"><b>株式会社ソフトライフ</b></td>
    <td style="width:5em;">&nbsp;</td>
    </tr>

    <?php echo $this->Form->create('User'); ?>
    <tr>
        <td>&nbsp;</td>
        <td>
            名前<br>
            <!-- 名前コンボの値セット START -->
            <?php
                echo $this->Form->input( 'username', array('label' => false,'type' => 'select','style'=>'width: 100%;font-size:120%;', 
                    'options' => $datas, 'empty' => '(あなたのお名前)'));
            ?>
            <!-- 名前コンボの値セット END -->

        </td>
        <td>&nbsp;</td> 
    </tr>

    <tr>
        <td>&nbsp;</td>
        <td>
            パスワード<br>
            <?=$this->Form->input('password', array('label' => false,'type' => 'password','style'=>'width: 95%;',))?>
        </td>
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



