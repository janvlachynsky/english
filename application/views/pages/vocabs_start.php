<div class="uk-section uk-section-secondary ">
	<?php $settings = include(APPPATH.'settings.php'); ?>

	<?php echo form_open('page/view/vocabs','class="uk-form-horizontal uk-padding " id="myform"');?>

	
	<div class="uk-margin">
		<label class="uk-form-label" for="form-horizontal-text">Name</label>
		<div class="uk-form-controls  uk-child-width-1-1" uk-grid>
			<div>
				<input class="uk-input" type="text" name="name" autofocus="">
			</div>
		</div>
	</div>
	<!-- <div class="uk-margin">
		<label class="uk-form-label" for="form-horizontal-text">Difficulty</label>
		<div class="uk-form-controls uk-child-width-1-2@m uk-child-width-1-1" uk-grid>
			<div>
				<select class="uk-select">
					<option value="easy">Easy</option>
					<option value="medium">Medium</option>
					<option value="hard">Hard</option>
				</select>
			</div>
		</div>
	</div> -->
	<div class="uk-margin">
		<label class="uk-form-label" for="form-horizontal-text">Choose source<span class="require">*</span></label>
		<div class="uk-form-controls  uk-child-width-1-1" uk-grid>
			<div>
				<select class="uk-select" id="form-horizontal-select" name="source" required>
					<option value"" disabled selected value>Choose... </option>
					<option value="all">All</option>
					<?php

					foreach($category as $k => $cat){
						echo "<option status='from' value='".$cat['source']."' >".ucfirst($cat['source'])."</option>";
					}
					?>
				</select>
			</div>
		</div>
	</div>
	<div class="uk-margin">
		<label class="uk-form-label" for="form-horizontal-text">Choose "from/to" language<span class="require">*</span></label>
		<div class="  uk-form-controls uk-child-width-1-2@m uk-child-width-1-1" uk-grid>
			<div class="lang">
				<select class="uk-select" id="form-horizontal-select" name="langfrom" required>
					<option value"" disabled selected value>Choose from... </option>
					<?php

					foreach($settings['languages'] as $key => $lang){
						echo "<option status='from' value='".$lang."' order='".$key."' >".ucfirst($lang)."</option>";
					}
					?>
				</select>
			</div>
			<div class="lang">
				<select class="uk-select" id="form-horizontal-select" name="langto" required>
					<option value"" disabled selected value>Choose to... </option>
					<?php
					foreach($settings['languages'] as $key => $lang){
						echo "<option status='to' value='".$lang."' order='".$key."'>".ucfirst($lang)."</option>";
					}
					?>
				</select>
			</div>
		</div>
	</div>

	<div class="uk-margin">
		<label class="uk-form-label" for="form-horizontal-select">Number of vocabs<span class="require">*</span> <span id="range-value"></span></label>
		<div class="uk-form-controls">
			<input type="range" min="5" max="50" value="10" class="slider" id="myRange" name="range" step="5">

		</div>
	</div>

	<div class="uk-margin">
		<div class="uk-form-controls uk-form-controls-text uk-text-center">
			<input id="start" class="uk-button uk-button-danger "type="submit" value="Start">
		</div>
	</div>

	<?= form_close();?>
</div>


<script type="text/javascript">

	$(document).ready(function(){
		var number = $('input[type="range"]').attr('value');
		var languagefrom ;
		$('#range-value').html(number);
		$('#myRange').on('input',function(){
			number = this.value;
			$('#range-value').html(number);
		});
		$( "select" ).change(function() {
			$( "select option:selected" ).each(function() {
				languagefrom = $( this ).attr('value');
			});
		});
		var optnumb=-1;
		
		$('.lang select').on('change',function(){
			$(this).children('option').each(function () {
				optnumb++;
			});
			if(optnumb==2){
				if($(this).find('option:selected').attr('order')==0){
					$(this).parent().siblings('div.lang').children('select').val('english');	
				}else if($(this).find('option:selected').attr('order')==1){
					$(this).parent().siblings('div.lang').children('select').val('czech');
				}
				optnumb=-1;

			}

			/* CHOSE lang*/
			//alert(optnumb);  
			//alert($(this).find('option:selected').attr('value')+"kokos");
			/*$("option").each(function(){
   				alert($(this).each.attr('value'));
   			});*/
				//alert($(this).find('option').attr('value'));
				//alert($('option').attr('value'));
				//alert($(this).find('option:selected').attr('value'));
				//alert($(this).find('+select>option').attr('value'));

			});
	});


</script>