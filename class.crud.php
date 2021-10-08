<?php
	class crud
	{
		private $db;
		private $charset = "0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ";
		private $url_length = 8;
	    
	    public function __construct($DB_con)
	    {
	        $this->db = $DB_con;
	    }

	    public function originToShorten($url) {
	    	// Check the original url is valid
	    	if (filter_var($url, FILTER_VALIDATE_URL) === FALSE) {
			    return array("error" => "valid",  "content" => "Invalid URL");
			}

			$is_aleady = $this->db->prepare("SELECT * FROM shorten WHERE origin=:origin");
			$is_aleady->bindparam(":origin",$url);
        	$is_aleady->execute();
			if($is_aleady->rowCount() > 0) {
				return array("error" => "valid",  "content" => "URL is already exist");
            }
            else {
            	$shortCode = $this->generateRandomString();

		        $this->insertUrlInDB($url, $shortCode);
		        return array("success" => "valid",  "content" => $shortCode);
            }			
	    }


	    // Generate the random string for shorten url
	    public function generateRandomString(){
	    	$randString = "";
			$charset = str_split($this->charset);
			for($i = 0; $i < $this->url_length; $i++){
			    $randString .= $charset[array_rand($charset)];
			}
			$randString = str_shuffle($randString);
			return $randString;
		}

		// Insert the url to db.
		public function insertUrlInDB($url, $shortCode) {
        	$now = new DateTime();
	        $upload_date = $now->format('Y-m-d H:i:s');
			$addShortenQuery = "INSERT INTO shorten (origin, shorten, created_at) VALUES (:origin, :shorten, :created_at)";
	        $stmt = $this->db->prepare($addShortenQuery);
	        $stmt->bindparam(":origin",$url);
	        $stmt->bindparam(":shorten",$shortCode);
	        $stmt->bindparam(":created_at",$upload_date);
	        $stmt->execute();
		}

		// get the original code from shorten url
		public function shortCodeToUrl($code, $increment = true){
	        if(empty($code)) {
	            throw new Exception("No short code was supplied.");
	        }

	        $urlRow = $this->getUrlFromDB($code);
	        if(empty($urlRow)){
	            echo "shorten code is not exist";
	        }

	        if($increment == true){
	            $this->incrementCounter($urlRow["id"]);
	        }

	        return $urlRow["origin"];
	    }

	    // Increase access whenever shorten is accessed.
	    public function incrementCounter($id){
	        $query = "UPDATE shorten SET access = access + 1 WHERE id = :id";
	        $stmt = $this->db->prepare($query);
	        $stmt->bindparam(":id",$id);
	        $stmt->execute();
	    }


	    // Get original url using shorten code.
	    public function getUrlFromDB($code){
	        $query = "SELECT id, origin FROM shorten WHERE shorten = :shorten LIMIT 1";
	        $stmt = $this->db->prepare($query);
	        $stmt->bindparam(":shorten",$code);
	        $stmt->execute();
	        $result = $stmt->fetch();
	        return (empty($result)) ? false : $result;
	    }

	    // Send the table content for often used url
	    public function getTopUsedUrl() {
	    	$table_string = "";
	    	$query = "SELECT * FROM shorten ORDER BY access DESC LIMIT 100";
	        $stmt = $this->db->prepare($query);
	        $stmt->execute();
	        while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
	            $table_string .= "<tr>";
	            $table_string .= "<td>".$row['origin']."</td>";
	            $table_string .= "<td>".$row['shorten']."</td>";
	            $table_string .= "<td>".$row['access']."</td>";
	            $table_string .= "</tr>";
	        }
	        return $table_string;
	    }

	    // Send the api content for often used url
	    public function getTopUsedUrlApi() {
	    	$api_content = [];
	    	$query = "SELECT * FROM shorten ORDER BY access DESC LIMIT 100";
	        $stmt = $this->db->prepare($query);
	        $stmt->execute();
	        while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
	            $api_content[] = array("origin" => $row['origin'], "shorten" => $row['shorten'], "access" => $row['access']);
	        }
	        return $api_content;
	    }

	}
?>