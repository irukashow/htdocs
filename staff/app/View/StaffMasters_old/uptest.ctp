<form action="upload" method="post" enctype="multipart/form-data">
    <input type="file" name="upfile" size="30" onchange="form.submit();"  style="
        border: 2px dotted #000000;
        font-size: 100%;
        width:300px;
        height: 100px;
        background-color: #ffffcc;
        border-radius: 10px;        /* CSS3草案 */  
        -webkit-border-radius: 10px;    /* Safari,Google Chrome用 */  
        -moz-border-radius: 10px;   /* Firefox用 */
        vertical-align: middle;
       ">
    <?php echo $msg ?>
  <br />
</form>
