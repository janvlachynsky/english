
<div class="uk-section uk-section-secondary uk-text-center" style="padding-top:20px;">
	<?php echo validation_errors(); ?>
	
	<form id="form_check" action="" method="post">
	<script> var time_start=$.now()+12000;</script>
	<?php $session_id=$this->session->userdata();
	?>
	<?php if($vocabulary!=0): 

		$vocabs_count=count($vocabulary);
		?>
		<div class="counter  animated slideInUp">
			<span id="currentcount"><?php echo ++$number;?></span> /
			<span id="allcount"><?=$vocabs_count;?></span>
		</div>
		<div class="score animated slideInUp ">score: <span id="score" data-score="0"><?=$this->score;?></span></div>

		<h1 id="h1" class='uk-heading-primary uk-text-uppercase uk-text-center' name="firstWord"><?= $vocabulary[$number][$this->langfrom];?></h1>
		<div class="shadow">
		</div>
		<input id="question" type="hidden" name="question" number="<?= $number ?>" value="<?= $vocabulary[$number]['id']?>" rating="<?= $vocabulary[$number]['rating']?>"" count="0">
		<div class="uk-padding-small animated fadeIn delay-1s">	
			<input style="height:40px; font-size:20pt; text-align: center;" id="answer"  type="text" name="answer" placeholder="Enter your answer..." autofocus autocomplete="off">
		</div>
		<input id="show-result" class="uk-button uk-button-primary" style="display:none;"type="button" name="check" value="Show result">
		<input id="reset" class="uk-button uk-button-secondary animated fadeIn delay-1s" style="display:none;"type="button" name="check" value="Reset">
		<input id="submit" class="uk-button uk-button-primary animated fadeIn delay-1s" type="button" name="check" value="check">
		<input id="next" class="uk-button uk-button-danger animated fadeIn delay-1s" type="button" name="next" value="next">

		<?php else: ?>
			<h1 id="h1" class='uk-heading-primary uk-text-uppercase uk-text-center' name="firstWord">CHYBA, pole slovíček není úplné.</h1>
			<a href="/english2/index.php/vocabs_start" id="refresh" class="uk-button uk-button-danger">Znovu zapnout</a>

		<?php endif; ?>
		</form>
	</div>
	<div id="res" class="uk-padding-small uk-text-center"></div>
	<div class="uk-text-center uk-position-bottom" style="color:#66666680;">
		Try: <i>"ENTER"</i> for submit | <i>"-"</i> for next word	
	</div>
<div id="result-modal">
	<span class="close">X</span>
	<div class="content">
	</div>
</div>
	<script>
 $(document).ready(function() {

      var progress= [];

      var options = {
        useEasing: true, 
        useGrouping: true, 
                    separator: ',', 
      };


      $(window).keypress(function(event) {
        if(event.which == 13 && $('#next').length>0) {
          event.preventDefault();
          $('#submit').click();
        }else if(event.which == 45){
          var data = [];
          event.preventDefault();

          data['word']=$('#answer').val();
          data['id']=$('#question').attr('value');
          data['count']=$('#question').attr('count');
          data['result']="Skiped";
          progress.push(data);
          $('#next').click();
        }
      });

      $('#submit').click(function(){
        console.log("sdgsdvxc");
        var answer_time = time_start - $.now();
        if(answer_time<=100){
          answer_time=100;
        }
        console.log(answer_time+ " ms");
        var vocabulary = <?php echo json_encode($vocabulary)?>;
        var answer = $('#answer').val();


        var score =$('#score').attr('data-score');

        var id = $('#question').attr('value');
        var number = $('#question').attr('number');
        var count = $('#question').attr('count');
        var rating = $('#question').attr('rating');
        var langfrom= "<?=$this->langfrom;?>";
        var langto= "<?=$this->langto;?>";

        $.ajax({
          type:'POST',
          data:{answer: answer, id: id, number: number, vocabulary: vocabulary, count:count, langto:langto,langfrom:langfrom, rating:rating, score:score, answer_time:answer_time},
          url:'/english/index.php/page/check',
          error: function(xhr, error,thrownerr){
            console.log("xhr: "+xhr.status+" error: "+error+" ThrownError: "+thrownerr);
          },
          success: function(result){
           console.log(result);
            var data=JSON.parse(result);

            window.notie.alert({type: data["type"], text: data["result"]});

            $('#answer').focus();
            $('#question').attr('count',data["count"]);
            $('#question').attr('rating',data["rating"]);
            $('#score').attr('data-score',data['score']);


            var scoreAnim = new CountUp('score', score, data['score'],0, 1, options);
            if (!scoreAnim.error) {
              scoreAnim.start();
              $('.score').animateCss('tada');
            } else {
              console.error(scoreAnim.error);
            }



            if(data["booleanresult"]===true){
              
                $('#next').click();
              
              progress.push(data);
            }else{
              $('#h1').animateCss('shake');
              $('#answer').val("");
              if($('#question').attr('count')>=3){
                setTimeout(function(){
                  $('#next').click();
                },0);   
                progress.push(data);



              }
            }

          }
        });
      });
      $('#next').click(function(){
        console.log('slsdflk');
        var vocabulary = <?=json_encode($vocabulary);?>;
        var question = $('#question').attr('number');
        var range = "<?= $this->range;?>";
        var langfrom= "<?=$this->langfrom;?>";
        var langto= "<?=$this->langto;?>";
        console.log(progress);



        $.ajax({
          type:'POST',
          data:{question: question,vocabulary: vocabulary, range:range,  langto:langto,langfrom:langfrom},
          url:"<?php echo base_url('page/next'); ?>",
          error: function(xhr, error,thrownerr){
            console.log("xhr: "+xhr.status+" error: "+error+" ThrownError: "+thrownerr);
          },
          success: function(result){
            var data=JSON.parse(result);
            time_start=$.now()+12000;
            $('#question').attr('number',data["number"]);
            $('#h1').animateCss('slideOutLeft', function(){
              $('#h1').html(data["word"]).animateCss('bounceInRight');  
            });

            $('#question').attr('rating',"<?php echo $vocabulary[$number]['rating']?>");
            $('#question').attr('count',0);
            $('#currentcount').html(data["number"]);

            $('#question').attr('value',data["id"]);
            $('#answer').val("");
            if(data["id"]==0){
              $('#answer').hide();
              $('#submit').prop('disabled',true).hide();
              $('#next').remove();
              $('#show-result').show();
              $('#reset').show();
              console.log('end');
              console.log(progress);

              localStorage.setItem('test', JSON.stringify(progress));

            }

          }
        });
      });


      $('#show-result').click(function(){
        var results = JSON.parse(localStorage.getItem('test'));
        console.log(results[0]['word']);
        console.log($('#result-modal .content table').length + " - modal length");
        $('#result-modal').show();
        $('#result-modal .content').append('<table class="uk-table uk-table-divider   uk-table-small"><thead><th><td>#</td><td>Czech</td><td>English</td><td>Answered</td><td>id</td><td>result</td><attempts</td></th></thead>');

        for(var i=0;results.length > i; i++){
          $('#result-modal .content').append('<tr><td></td><td></td><td>'+i+'</td><td>'+results[i]['word']+'</td><td>'+results[i]['word']+'</td><td>'+results[i]['booleanresult']+'</td><td>'+results[i]['id']+'</td><td>'+results[i]['result']+'</td><td>'+results[i]['count']+'</td></tr>');


        }
        $('#result-modal .content').append('</table>');
        });
      $('.close').click(function(){
        $('#result-modal').hide();
      });
    });

	</script>