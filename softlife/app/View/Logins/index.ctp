<?php
    echo $this->Html->css( 'main');  
?>

<!-- content start -->
<br />
<div style="margin-top: 50px;margin-bottom: 50px;">

<center>
    <table cellspacing="5" cellpadding="5" border="2" align="center" id="staff_master">
 <tr>    
     <td>   
<table cellspacing="10" cellpadding="20" border="0" align="center" style="background-color: #ccffcc;">
    <tr><td nowrap>&nbsp;</td></tr>
    <tr>
        <td style="width:5em;">&nbsp;</td>
    <td style="text-align: center;width:15em;"><b>株式会社ソフトライフ</b></td>
    <td style="width:5em;">&nbsp;</td>
    </tr>
 
    <?php
        echo $this->Form->create('Logins', array('type' => 'post', 'action' => '.'));
    ?>
    
    <tr>
        <td>&nbsp;</td>
        <td>
            <?php
                $list=array(
                "" => '(あなたのお名前)',
                "168" => '菊谷　直哉',
                "237" => '阿部　直人',
                "952" => '横井　政広',
                "394" => '大阪　人材派遣グループ',
                "9999" => 'システム管理者');
                
                echo $this->Form->input('id',
                    array('label' => '名前',
                        'type' => 'select',
                        'options' => $list,
                        'selected' => '')   
                    );
            ?>
        </td>
        <td>&nbsp;</td> 
    </tr>

    <tr>
        <td>&nbsp;</td>
        <td><?=$this->Form->input('passwd', array('label' => 'パスワード','type' => 'password'))?></td>
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



