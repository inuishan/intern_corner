<?
require_once 'User.php';
/**
* 
*/
class Student extends User
{
	var $field;
	var $cpi;
	var $batch;
	var $reputation;
	var $profile_complete;
	var $professor_rating_average;
	var $resume;
	var $experience;
	var $areas_of_interest;
	function professorRate(){

	}
	function displayProfile(){
		
	}
	
	function __construct($field,$cpi,$batch,$reputation,$areas_of_interest,$profile_complete,$professor_rating_average,$resume,$experience)
	{
		# code...

	}

}
?>