<h1>Index Page</h1>
<p>StuffMaster Find View.</p>
<form method="post" action="./find">
  ID:<input type="text" name="id" value="<?=$_POST['id']?>"/>
  <input type="submit" />
</form>
 
<table>
<?php if (isset($data)): ?>
  <tr>
    <td>氏名:</td>
    <td><?php echo $data['StuffMaster']['name_sei'].' '.$data['StuffMaster']['name_mei']; ?></td>
  </tr>
  <tr>
    <td>年齢:</td>
    <td><?php echo $data['StuffMaster']['age']; ?></td>
  </tr>
  <tr>
    <td>性別:</td>
    <td><?php echo $data['StuffMaster']['sex']; ?></td>
  </tr>
<?php endif; ?>
</table>