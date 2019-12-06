<section class="uk-section">
	<div class="uk-grid uk-child-width-1-2@m uk-child-width-1-1">
		<div class="uk-card uk-card-primary uk-padding">
			<h3>Manual</h3>
			<form method="post" action="page/vocabsadd">
				<div class="uk-margin">
					<label class="uk-form-label" for="form-horizontal-text">To file</label>
					<div class="uk-form-controls  uk-child-width-1-1" uk-grid>
						<div class="uk-form-select">
							<select class="uk-select" id="form-horizontal-select" name="source" required>
								<option>
					<?php

					foreach($category as $k => $cat){
						echo "<option status='from' value='".$cat['source']."' >".ucfirst($cat['source'])."</option>";
					}

					?>
					<option status='from' value='new_file'>New file</option>
				</select>
						</div>
					</div>
				</div><div id="newfile" class="uk-margin uk-hidden" >
					<label class="uk-form-label" for="form-horizontal-text">New file name</label>
					<div class="uk-form-controls  uk-child-width-1-1" uk-grid>
						<div>
							<input class="uk-input uk-width-1-1" type="text" name="new_file_name" autofocus="" >
							<div id="res" style="min-height:25px;"></div>
						</div>
					</div>
				</div>
				<div class="uk-margin">
					<label class="uk-form-label" for="form-horizontal-text">Czech</label>
					<div class="uk-form-controls  uk-child-width-1-1" uk-grid>
						<div>
							<input class="uk-input uk-width-1-1" type="text" name="czech" autofocus="" >
							<div id="res" style="min-height:25px;"></div>
						</div>
					</div>
				</div>
				<div class="uk-margin">
					<label class="uk-form-label" for="form-horizontal-text">English</label>
					<div class="uk-form-controls  uk-child-width-1-1" uk-grid>
						<div>
							<input class="uk-input" type="text" name="english"  >
							<div id="res" style="min-height:25px;"></div>
						</div>
					</div>
				</div>
				<div class="uk-margin">
					<div class="uk-form-controls uk-form-controls-text uk-text-center">
						<input id="start" class="uk-button uk-button-danger "type="submit" value="ADD">
					</div>
				</div>
			</form>
		</div>
		<div class="uk-card uk-card-secondary uk-padding">
			<h3>File</h3>
			<div id="test"></div>
			

			<?php echo form_open_multipart('upload/do_upload');?>

				<input type="file" name="userfile" size="20" />

			<br /><br />

<input type="submit" value="upload" />

</form>
		</div>
	</div>
</section>

<script type="text/javascript">
	$('select').on('change',function(){
		console.log($(this).find(':selected').val());
		if($(this).find(':selected').val() == "new_file"){
			$('#newfile').toggleClass('uk-hidden');
		}else{

			$('#newfile').toggleClass('uk-hidden');
			$('#newfile').find('input').html();
		}
	});
	$('input[type=text]').on('keyup',function(){
		//alert($(this).val());
		var vocab = $(this).val();
		var target = $(this);
		$.ajax({
			type:'POST',
			data:{vocab: vocab},
			url:'<?php echo base_url('page/verify'); ?>',
			error:function(xhr, error,thrownerr){
        		console.log("xhr: "+xhr.status+" error: "+error+" ThrownError: "+thrownerr);
 			},
 			success: function(result){
 				console.log(result);
 				var data=JSON.parse(result);
 				if(data["ver"]=="wrong"){
 					target.siblings('div').html('Word is already added!');

 					$('input[type=submit]').attr('disabled',true).attr('src',target.attr('name'));;
 				}else{
 					var src = $('input[type=submit]').attr('src');
 					if(src==target.attr('name')){
 						$('input[type=submit]').attr('disabled',false);
 						$('input[name='+src+' + div').html("");
 					}
 				}
 				
 			},

		});
	});

</script>