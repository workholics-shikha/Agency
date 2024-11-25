<?php
class PRBSL
{

	protected $db_name = 'desiantiques_agency';
	protected $username = 'root';
	protected $password = '';
	protected $host = 'localhost';

	// protected $db_name = 'desiantiques_agency';
	// protected $username = 'desiantiques_agency';
	// protected $password = 'k&nU171j4';
	// protected $host = 'localhost:3306';


	public $conn;
	public $insert_id = 0;
    public $prefix = 'ppt_';

	function __construct()
	{ 
		$this->conn =  mysqli_connect($this->host,$this->username,$this->password,$this->db_name);
		$this->set_charset();
		if($this->conn){
			//echo "Success";die;
		}
	}
	function insert($table_name,$array)
	{
		if(!is_array($array))
			return;
		$array_keys = array_keys($array);
		$conn = $this->conn;
		$values = "";
		foreach($array as $single)
		{
			if($values !=""){$values .= ',';}
			$values .= "'$single'";
		}

		mysqli_query($conn,"INSERT INTO $table_name(".implode(',',$array_keys).") VALUES(".$values.")")or die(mysqli_error($conn));
		$last_id =  mysqli_insert_id($conn);
		$this->insert_id = $last_id;
		return $last_id;
	}
	function update($table,$data,$where, $format = null, $where_format = null )
	{

        $conn = $this->conn;
		if ( ! is_array( $data ) || ! is_array( $where ) )
		return false;
		$bits = $wheres = array();
		foreach ( (array) array_keys( $data ) as $field ) {
				$form = array_shift($data);
			$bits[] = "`$field` = '{$form}'";
		}
		foreach ( (array) array_keys( $where ) as $field ) {
				$form =array_shift($where);
			$wheres[] = "`$field` = '{$form}'";
		}

        $update = "UPDATE `$table` SET " . implode( ', ', $bits ) . ' WHERE ' . implode( ' AND ', $wheres );

        if(mysqli_query($conn,$update)){
			return true;
		}
		else{
			return false;
		}
	}
	function get_var($query)
	{
		$conn = $this->conn;
		$query = mysqli_query($conn,$query)or die(mysqli_error($conn));
		if($query->num_rows <= 0)
			return;
		$singleData = @mysqli_fetch_object($query);
		if(empty($singleData))
			return;
		$values = array_values( get_object_vars( $singleData ) );
		$values = implode(',',$values);
		return $values;
	}
	function get_row($query)
	{

        $single_row = array();
		$conn = $this->conn;
		$get_single_row = mysqli_query($conn,$query);
		$singleData = @mysqli_fetch_object($get_single_row);
		if(!empty($singleData))
		{
			foreach($singleData as $key =>$value){
				$single_row[ $key ] = $value;
			}
		}
		if(!empty($single_row)){
			return $single_row;
		}
		else
		{
			return false;
		}
	}
	function get_results($query)
	{
		$new_array = array();
		$conn = $this->conn;
		$get_user = mysqli_query($conn,$query);
		while($allData = mysqli_fetch_object($get_user)){
			$var_by_ref = get_object_vars( $allData );
				$key = array_shift( $var_by_ref );
				if ( ! isset( $new_array[ $key ] ) )
					$new_array[ $key ] = $allData;
			}
		return $new_array;
	}
	function get_count_row($query)
	{

		$conn = $this->conn;
		$get_user = mysqli_query($conn,$query);
    	$result=mysqli_num_rows($get_user);
		return $result;
	}
	function delete($table,$where, $format = null, $where_format = null )
	{
			if (! is_array( $where ) )
			return false;
			$conn = $this->conn;
			$bits = $wheres = array();
			foreach ( (array) array_keys( $where ) as $field ) {
					$form =array_shift($where);
				$wheres[] = "`$field` = '{$form}'";
			}
			$delete = "DELETE FROM `$table` ".' WHERE ' . implode( ' AND ', $wheres );

			if(mysqli_query($conn,$delete)){
				$return = true;
			}
			else
			{
				$return = false;
			}
			return $return;
	}

	function esc_string($string){
		$conn = $this->conn;
		return mysqli_real_escape_string($conn,$string);
	}
	function set_charset(){
		mysqli_set_charset($this->conn,'utf8');
		mysqli_query($this->conn,'SET character_set_results=utf8');
		mysqli_query($this->conn,'SET names=utf8');
		mysqli_query($this->conn,'SET character_set_client=utf8');
		mysqli_query($this->conn,'SET character_set_connection=utf8');
		mysqli_query($this->conn,'SET collation_connection=utf8_general_ci');
	}
	private function close($conn)
	{
		mysqli_close($conn);
	}
}
global $prbsl;
$prbsl = new PRBSL();
?>
