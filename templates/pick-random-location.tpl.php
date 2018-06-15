<?php include($_SERVER['DOCUMENT_ROOT'].$T['webroot'].'/templates/header.tpl.php'); ?>

<div class="unit">
<h1><?php echo $T['title'];?></h1>
<div align="right">
 <a href="<?php echo $T['webroot'];?>/">Lunch</a>
</div>

<?php foreach($T['messages'] as $m){ ?>
 <div class="center"><?php echo $m;?></div>
<?php } ?>

<div class="unit">
<div style="text-align:center;">
<h2 style="font-size:2em;">Winner Generator</h2>
<?php /*Server Time: <?php echo $T['current_time'];?>*/?> <br/>
<br/><span style="color:green;font-size:3em;font-style:italic;font-weight:bold;"><i>Winner: <?php echo $T['random_location'];?></i></span> <br/><br/>
</div>
Tip: Hitting F5 on your browser will refresh the page so you can see the Winner Generator randomly picking potential winners. <br/>

</div>
<div style="clear:both;"></div>

<div class="unit">
<strong>Lunch Winners</strong> <br/>
<?php foreach($T['lunch_winners'] as $i){ ?>
 <?php echo $i['lunch_winner_created'];?> => <?php echo $i['lunch_winner_location'];?> <br/>
<?php } ?>
</div>
</div>


</div>

<?php include($_SERVER['DOCUMENT_ROOT'].$T['webroot'].'/templates/footer.tpl.php'); ?>
