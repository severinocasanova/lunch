<?php include($_SERVER['DOCUMENT_ROOT'].$T['webroot'].'/templates/header.tpl.php'); ?>

<div class="unit">
<h1><?php echo $T['title'];?></h1>
<div align="right">
 <a href="<?php echo $T['webroot'];?>/delete/lunch-suggestions">Delete Suggestions</a> |
 <a href="<?php echo $T['webroot'];?>">Lunch</a>
</div>

<?php foreach($T['messages'] as $m){ ?>
 <div class="center"><?php echo $m;?></div>
<?php } ?>

<div class="unit">
<form action="" method="post">
<table width="100%">
 <tr>
  <td width="130">Stop Time</td>
  <td><input name="stop_time" value="<?php echo $T['config']['stop_time'];?>"/></td>
 </tr>
</table> <br/>
<div class="center">
 <input type="submit" value="Update"/>
</div>
</form>
</div>


</div>

<?php include($_SERVER['DOCUMENT_ROOT'].$T['webroot'].'/templates/footer.tpl.php'); ?>
