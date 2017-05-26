<?php include_once($_SERVER['DOCUMENT_ROOT'].$T['webroot'].'templates/header.tpl.php');?>

<div class="unit">
<h1>Delete Entry</h1>
<div align="right">
 <a href="/lunch">Lunch</a>
</div>

<?php foreach($T['messages'] as $m){ ?>
 <div class="center"><?php echo $m;?></div>
<?php } ?>

<br/>
Are you sure you want to delete this lunch suggestion?

<form method="post" name="lunch_suggestion_delete_form">
<div class="center"><input name="lunch_suggestion_delete" type="submit" value="Delete" /></div>
</form>
</div>

<?php include_once($_SERVER['DOCUMENT_ROOT'].$T['webroot'].'/templates/footer.tpl.php');?>
