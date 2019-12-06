<?php 
class Page extends CI_Controller
{
	public function __construct()
	{
		 parent::__construct();
		 $this->load->library('session');	
		 $this->load->library('encryption');		
		 $this->load->model('vocabulary_model');
		

	}
	public function view($page='home', $offset=FALSE)
	{
		

		//$file_array=$this->loadFile("slovickaPAAO2_test1.txt");

		if (!file_exists(APPPATH.'views/pages/'.$page.".php")) {
			show_404();
		}
		$data['category']=$this->vocabulary_model->get_cat();

		if($page=="vocabs"){
			$this->langfrom=$this->input->post("langfrom");
			$this->langto=$this->input->post("langto");
			$this->range = $this->input->post("range");
			$this->name = $this->input->post("name");
			$this->source = $this->input->post("source");
			$this->score = 0;

			

			$vocabulary = $this->generate($this->source,$this->range);
			
			 $this->session->set_userdata(['vocabs_encoded'=>json_encode($vocabulary)]);
			
			
			$data['vocabulary']=$vocabulary;
			$data['number']=0;
			$data['title']=ucfirst($page);
    		
        	
        	//(empty($this->name)? $this->name = $this->session->get_userdata()['__ci_last_regenerate'] : "");
        	$userdata = array(
				'name'=> $this->name,
				'address'=> $_SERVER['REMOTE_ADDR'],
				'date'=> date("d-m-Y H:i:s"),
				'langfrom'=>$this->langfrom,
				'langto'=>$this->langto,
				'range'=>$this->range,
				'score'=>0
			);
/*			$this->session->set_userdata($userdata);
			ECHO "TEST <BR>";
				print_r($this->session->all_userdata());*/

				$this->load->view('templates/header',$data);
        	$this->load->view('pages/'.$page,$data);
        	$this->load->view('templates/footer',$data);	
    	}else{
    		if($page=="vocabsall"){
    			$allvocabs=$this->vocabulary_model->get_vocabs(FALSE,FALSE,"DESC");
    			$vocabscount=count($allvocabs);
    			
    			$config['base_url'] = base_url('page/vocabsall');
				$config['total_rows'] = $vocabscount;
				$config['uri_segment'] = 3;
				$config['per_page'] = 30;
				$config['first_link'] = true;
    			$config['last_link'] = true;
    			$data['vocabs']=$this->vocabulary_model->get_vocabs($config['per_page'],$offset);

				$this->pagination->initialize($config);
    		}

    		$data['title']=ucfirst($page);
    		$this->load->view('templates/header',$data);
        	$this->load->view('pages/'.$page,$data);
        	$this->load->view('templates/footer',$data);
	}

}


	public function generate($source=FALSE, $limit=FALSE){

		$vocabulary=$this->vocabulary_model->get_vocabs($limit,FALSE,"",$source);
		shuffle($vocabulary);

		return $vocabulary;
	}
	

	public function check(){
		$this->load->helper('text');
		$input=convert_accented_characters(mb_strtolower($this->input->post('answer')));
		$id=$this->input->post('id');
		$number=$this->input->post('number');
		$rating=$this->input->post('rating');
		$count=$this->input->post('count');
		$vocabulary= $this->input->post('vocabulary');
		$langto= $this->input->post('langto');
		$langfrom= $this->input->post('langfrom');
		$score=$this->input->post('score');
		$answer_time = $this->input->post('answer_time');

		$count++;
		$rating++;

		$almost=levenshtein(convert_accented_characters($vocabulary[$number][$langto]), $input);
		$tolerance=ceil(strlen(convert_accented_characters($vocabulary[$number][$langto]))*0.25);
		$check = array("word"=>$vocabulary[$number][$langto],"id"=>$id, "count"=>$count, "rating"=>$rating);
		
		if(!empty($input)){
			$check["booleanresult"]= false;
			if(convert_accented_characters($vocabulary[$number][$langto])==$input){
			
				$check["result"]= "Right!";
				$check["type"]="1";
				$check["booleanresult"]= true;
				
				$score = $score + $answer_time;
				$check["score"]=$score;	
				
			}elseif($almost <= $tolerance){
				$check["result"]= "Almost right!<br>You meant: ".$vocabulary[$number][$langto];
				$check["type"]="2";
				$check["booleanresult"]= true;

				$score = $score + $answer_time/3;
				$check["score"]=$score;	
				
			}else{
					$check["result"]= "Wrong! ".$count." ".$vocabulary[$number]['id'].$number;
					$check["type"]="3";
					$check["score"]=$score;	

				if ($count==3) {
					$check["result"]= "Wrong! ".$count."<br>".$vocabulary[$number][$langto];
					$check["score"]=$score;	
				}
			}	
		}else{
				$check["result"]= "Empty! ".$count;
				if ($count==3) {
					$check["result"]= "Empty! ".$count."<br>".$vocabulary[$number][$langto];
					$check["score"]=$score;	
				}
		}
		//$this->vocabulary_model->set_rating($id,$rating);
	 echo json_encode($check);
	}

	public function next(){
		$number = $this->input->post('question');
		$vocabulary= $this->input->post('vocabulary');
		$range=$this->input->post('range');
		$langto=$this->input->post('langto');
		$langfrom=$this->input->post('langfrom');
		$number++;

		if($range<=$number){
			$word="<span class='uk-padding-small uk-text-danger' >End</span><br>";
			$id=0;
		}else{
			$word=$vocabulary[$number][$langfrom];
			$id=$vocabulary[$number]['id'];			
		}		
		$next = array("number"=>$number,"word"=>$word,"id"=>$id);
		echo json_encode($next);
	}

	public function uploadToDB($array){
		$this->vocabulary_model->upload_vocabs($array);
	}

	public function loadFile($name){
		$this->load->helper('file');
		$myfile = fopen(APPPATH.$name, "r") or die("Unable to open file!");
		$allWords= array();
		$i=0;

		while(!feof($myfile)){
			$progress=fgets($myfile);
			$word=explode("|",$progress);
			$allWords[]=array("id"=>$i, "english"=>trim($word[0]), "czech"=>trim($word[1]));
			$i++;
		}
		fclose($myfile);
		$this->uploadToDB($allWords);
	}
	public function  vocabsadd(){
		print_r("hihi");die();
	}

	public function verify(){
		$verified=array();
		$verified['arr']=array();
		$newword=strtolower($this->input->post('vocab'));
		$vocabarr=$this->vocabulary_model->get_vocabs();
		foreach ($vocabarr as $key => $value) {
			foreach ($value as $k => $v) {
					array_push($verified['arr'], $v);
				if($v==$newword){
					$verified['ver']='wrong';
					break 2;
				}else{
					$verified['ver']="ok";
				}
			}
		}
		echo json_encode($verified);
	}

	public function findVocab($vocab){

	}

	public function result(){
		$result = json_decode(base64_decode($this->input->post('result-data')),true);

		//print_r($result);

		 $vocabs = json_decode($this->session->get_userdata()['vocabs_encoded'],true);
		 //print_r($vocabs);


		 foreach ($vocabs as $key => $value) {
		 
		 	foreach ($result as $k2 => $res){

		 		if(!empty($res) && $value['id']==$res['id']){
		 			$vocabs[$key]['count'] = $res['count'];
		 			$vocabs[$key]['booleanresult'] = $res['booleanresult'];
		 			$vocabs[$key]['score'] = $res['score'];
		 			$vocabs[$key]['result'] = $res['result'];
		 			$vocabs[$key]['answer'] = $res['word'];
		 			continue 2;
		 		}else{
		 			$vocabs[$key]['count'] = 0;
		 			$vocabs[$key]['booleanresult'] = 0;
		 			$vocabs[$key]['score'] =0;
		 			$vocabs[$key]['result'] = "Empty";
		 			$vocabs[$key]['answer'] = "";
		 		}	
		 	}
		 }
		$data = array('vocabs'=>$vocabs);
		 $data['title']='Test results';
			$this->load->view('templates/header',$data);
        $this->load->view('pages/result',$data);	
        	$this->load->view('templates/footer',$data);		

	}
}

