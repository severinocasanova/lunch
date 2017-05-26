<?php include($_SERVER['DOCUMENT_ROOT'].$T['webroot'].'/templates/header.tpl.php'); ?>

<div class="unit">
<h1>Over-Engineered Unbiased Lunch Selector</h1>
<div align="right">
  <a href="">Refresh</a>
</div>

<?php foreach($T['messages'] as $m){ ?>
 <div class="center message"><?php echo $m;?></div>
<?php } ?>

<span>Please make TWO suggestions. They can both be the same if you really want to go there. <br/><br/></span>

<div class="unit half" style="overflow:hidden;">
<strong>Add Suggestion</strong>
<div align="right">
 <a href="/<?php echo $T['webroot'];?>add/lunch-location">Add Location</a>
</div>
<form action="" method="post">
<table width="100%">
 <tr>
  <td width="130">Name</td>
  <td>
<select name="lunch_suggestion_name">
 <option value="">--Select Name--</option>
<?php foreach($T['people'] as $i){ ?>
 <option value="<?php echo $i;?>"><?php echo $i;?></option>
<?php } ?>
</select>
  </td>
 </tr>
 <tr>
  <td>Suggestion</td>
  <td>
<select name="lunch_suggestion_location">
 <option value="">--Select Location--</option>
<?php foreach($T['lunch_locations'] as $i){ ?>
 <option value="<?php echo $i['lunch_location_name'];?>"><?php echo $i['lunch_location_name'];?></option>
<?php } ?>
</select>
  </td>
 </tr>
</table> <br/>
<div class="center">
 <input type="submit" value="Submit"/>
</div>
</form>
</div>

<div class="unit half">
<strong>Suggestions</strong> <br/>
<!--<script type="text/javascript" src="//code.jquery.com/jquery-1.8.3.min.js"></script>-->
<script type='text/javascript'>
            jQuery(function() {
                jQuery('#hideShow').click(function() {
                    jQuery('#suggestions').toggle();
                    return false;
                });
            });
</script>
<div align="right">
 <a href="#" id="hideShow">Show Suggestions</a>
</div>
<div id="suggestions" style="display:none;">
<?php foreach($T['lunch_suggestions'] as $i){ ?>
 <?php $this_md5 = htmlspecialchars_decode($i['lunch_suggestion_location'],ENT_QUOTES);?>
 <?php #$this_md5 = md5($this_md5);?>
 <?php echo $i['lunch_suggestion_name'];?> => <?php echo $i['lunch_suggestion_location'];?>:<?php echo number_format((float)$T['lunch_suggestions_count'][$this_md5]['percentage'], 2, '.', '');?>% : <?php if($_SERVER['REMOTE_ADDR'] == $i['lunch_suggestion_ip_address']){?><a href="/lunch/delete/lunch-suggestion/<?php echo $i['lunch_suggestion_id'];?>">[delete]</a><?php }?><br/>
<?php } ?> <br/>
<strong>People Percentages</strong> <br/>
<?php foreach($T['people_percentage'] as $k => $v){?>
 <?php echo $k.' => '.$v.'%';?> <br/>
<?php } ?>
</div>
</div>
<div style="clear:both;"></div>

<div class="unit">
<strong>Potential Winner</strong> <br/>

Below, you will see the Winner Generator. This tool will randomly select a name out of the hat every minute. <u>The final winner will be decided when the randomizer stops at 11:30AM on Friday (<?php echo $T['stop_time'];?>)</u>. Good Luck! <br/><br/>
<div style="text-align:center;">
<h2 style="font-size:2em;">Winner Generator</h2>
Server Time: <?php echo $T['current_time'];?> <br/>
<?php if($T['current_time'] < $T['stop_time']){ ?>
<span style="font-style:italic;font-weight:bold;"><i>Potential winner: <?php echo $T['potential_winner'];?></i></span> <br/><br/>
<?php }else{ ?>
<br/><span style="color:green;font-size:3em;font-style:italic;font-weight:bold;"><i>Winner: <?php echo $T['potential_winner'];?></i></span> <br/><br/>
<?php } ?>
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

<?php include($_SERVER['DOCUMENT_ROOT'].$T['webroot'].'/templates/footer.tpl.php'); ?>
