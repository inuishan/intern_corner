<?
/**
* Login class
*/
require_once '../includes/initialize_database.php';
require_once 'User.php';
require_once 'Student.php';
class Login
{	
	var $username;
	var $password;
	var $value = "An error has occurred";
	var $result = array("head" => array(), "body" => array() );
	function __construct($username,$password)
	{
		# code..
		$this->username = $username;
		$this->password = md5($password);
	}
	function validateAndLogin()
	{	
		$xx = array($this->username,$this->password);
		$db = (new Database())->connectToDatabase();
		$username = $this->username;
		$password = $this->password;
		$db->query("SELECT * FROM User WHERE user_name = '$username' AND password='$password'");
		$result = $db->fetch_assoc_all();
		$num_rows = $db->returned_rows;
		if($num_rows==0){
			//no user found with username and passowrd combination, redirect to login page only
			return array('status_code'=>404,'detail'=>'login_page');

		}
		if($num_rows==1){
			//username and password exits and are cool
			$user = new User($result[0]['user_name'],$result[0]['full_name'],$result[0]['email'],$result[0]['account_type'],$result[0]['contact_details']);

			//start session variables
			session_start();
			$_SESSION['user'] = $user;
			//check if student
			if($result[0]['account_type']==2)//student
				{
					
					//extract student's information from student table
					$db->query("SELECT * FROM Student WHERE user_name='$this->username'");
					$result = $db->fetch_assoc_all();
					if($result[0]['profile_complete']==0){
						//user should be redirected to build profile page
						return array('status_code'=>202,'detail'=>'build_profile');

					}
					else{
						//user should be redirected to home screen

						return array('status_code'=>202,'detail'=>'home screen');
					}

				}
			

		}			
	}
	function logout()
	{

		if($this->checkSetAndEmpty($_SESSION['user'])){
			//user logged in?
			//okay
			unset($_SESSION['user']);
			return array('status_code'=>200);

		}
		else{

			return array('status_code'=>400);
		}
	}
	function checkSetAndEmpty($var){
		if(isset($var)&&!empty($var)){
			return true;
		}
		else return false;


	}
}
session_start();
$login = new Login("sen","sen");
$login -> validateAndLogin();
print_r($_SESSION['user']);
// $login -> logout();
// print_r($_SESSION['user']);
?>