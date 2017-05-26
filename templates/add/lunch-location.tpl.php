<?php include($_SERVER['DOCUMENT_ROOT'].$T['webroot'].'templates/header.tpl.php'); ?>

<div class="unit">
<h1>Add Location</h1>
<div align="right">
 <a href="/lunch">Lunch</a>
</div>

<?php foreach($T['messages'] as $m){ ?>
 <div class="center"><?php echo $m;?></div>
<?php } ?>

<div class="unit">
<form action="" method="post">
<table width="100%">
 <tr>
  <td width="130">Name</td>
  <td><input name="lunch_location_name" value=""/></td>
 </tr>
</table> <br/>
<div class="center">
 <input type="submit" value="Add Entry"/>
</div>
</form>
</div>


</div>

<?php include($_SERVER['DOCUMENT_ROOT'].$T['webroot'].'templates/footer.tpl.php'); ?>
