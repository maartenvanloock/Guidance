<?php  

Class Ervaring_categorie {

	private $m_sTitle;
	private $m_sColor;

	public function __set($p_sProperty, $p_vValue)
	{
		switch($p_sProperty)
		{
			case "Title":
			$this->m_sTitle = $p_vValue;
			break;

			case "Color":
			$this->m_sColor = $p_vValue;
			break;
		}	   
	}

    public function __get($p_sProperty)
	{
		switch($p_sProperty)
		{
			case "Title": 
			return $this->m_sTitle;
			break;

			case "Color": 
			return $this->m_sColor;
			break;
        }
	}

	public function Save()
	{	
		require ("connection.class.php");
		
		$sql = "insert into tbl_categorie_ervaringen(categorie_name, categorie_color) values ('$this->Title', '$this->Color')";
		$db->query($sql);
	}
	
}

?>