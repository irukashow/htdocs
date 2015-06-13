<h1>Index Page</h1>
<p>StaffMaster Find View.</p>
<form method="post" action="./find">
  ID:<input type="text" name="id" value="<?=$_POST['id']?>"/>
  <input type="submit" />
</form>
 
<table>
<?php if (isset($data)): ?>
  <tr>
    <td>氏名:</td>
    <td><?php echo $data['StaffMaster']['name_sei'].' '.$data['StaffMaster']['name_mei']; ?></td>
  </tr>
  <tr>
    <td>年齢:</td>
    <td><?php echo $data['StaffMaster']['age']; ?></td>
  </tr>
  <tr>
    <td>性別:</td>
    <td><?php echo $data['StaffMaster']['sex']; ?></td>
  </tr>
<?php endif; ?>
</table>