<?php include_once($_SERVER['DOCUMENT_ROOT'].$T['webroot'].'/templates/header.tpl.php');?>

<div class="unit">
<h1><?php echo $T['title'];?></h1>
<div align="right">
 <a href="<?php echo $T['webroot'];?>">Lunch</a>
</div>

<?php foreach($T['messages'] as $m){ ?>
 <div class="center"><?php echo $m;?></div>
<?php } ?>

<br/>
Are you sure you want to delete this lunch winner?

<form method="post" name="lunch_winner_delete_form">
<div class="center"><input name="lunch_winner_delete" type="submit" value="Delete" /></div>
</form>
</div>

<?php include_once($_SERVER['DOCUMENT_ROOT'].$T['webroot'].'/templates/footer.tpl.php');?>
