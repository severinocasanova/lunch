<?php include($_SERVER['DOCUMENT_ROOT'].$T['webroot'].'/templates/header.tpl.php'); ?>

<div class="unit">
<h1><?php echo $T['title'];?></h1>
<div align="right">
 <a href="<?php echo $T['webroot'];?>/delete/lunch-winner/<?php echo $T['lunch_winner']['lunch_winner_id'];?>">Delete</a> |
 <a href="<?php echo $T['webroot'];?>">Lunch</a>
</div>

<?php foreach($T['messages'] as $m){ ?>
 <div class="center"><?php echo $m;?></div>
<?php } ?>

<form action="" method="post">
<table width="100%">
 <tr>
  <td width="130">Winner Location</td>
  <td><input name="lunch_winner_location" size="40" value="<?php echo $T['lunch_winner']['lunch_winner_location'];?>"/></td>
 </tr>
</table> <br/>
<div class="center">
 <input type="submit" value="Update Entry"/>
</div>
</form>

</div>

<?php include($_SERVER['DOCUMENT_ROOT'].$T['webroot'].'/templates/footer.tpl.php'); ?>
