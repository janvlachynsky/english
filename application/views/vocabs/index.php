<div class="uk-section uk-section-secondary uk-text-center">
	

	<?php echo form_open('vocabs/check');?>
	<h1 class='uk-heading-primary uk-text-uppercase uk-text-center' name="firstWord"><?= $vocabulary[$number]['english'];?></h1>
	<input type="hidden" name="question" value="<?= $vocabulary[$number]['id']?>">

	<div class="uk-padding-small">	
	<input style="height:40px; font-size:20pt; text-align: center;"  type="text" name="answer">
	</div>
	
	<input class="uk-button uk-button-primary" type="submit" name="check" value="check">
	<button class="uk-button uk-button-danger" name="next">Next</button>
	
</div>