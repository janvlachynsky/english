<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Vocabulary_model extends CI_Model{
	
	public function __construct(){
		parent:: __construct();
		$this->load->database();
	}
	
	public function get_vocabs($limit=FALSE, $offset=FALSE,$order="",$source=FALSE)
	{
		
		$this->db->from('vocabulary');
		if(isset($source)){
			if($source == "all"){
			
			}else{
				$this->db->where('source',$source);
			}
		}
		if(isset($order)){
			$this->db->order_by('czech',$order);
		}
		if($limit){
			$this->db->limit($limit,$offset);
		}
		$query = $this->db->get();
		/*print_r($query->result_array());die();*/
		return $query->result_array();
	}

	public function get_cat(){
		$this->db
			->select('source')
			->from('vocabulary')
			->group_by('source');
		$query = $this->db->get();
		return $query->result_array();
	}

	public function ss()
	{
		$query=$this->db->get('vocabulary');
		print_r($query->result_array());
		die();
		return $query->result_array();
	}

	public function addVocab($vocabArray){

	 $this->db->insert('vocabulary',$vocabArray);
		return true;
	}

	

	/*$file= APPPATH."slovickaPAAO2_test1.txt";
	$data['vocabulary']=file_get_contents($file);
*/
}
?>