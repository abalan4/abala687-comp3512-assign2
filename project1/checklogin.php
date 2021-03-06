<?php
define('DBHOST', '');
define('DBNAME', 'book');
define('DBUSER', 'testuser');
define('DBPASS', 'mypassword');
define('DBCONNSTRING','mysql:dbname=book;charset=utf8mb4;');

session_start();

function getUserSalt(){
    
    $getUser = $_POST["username"];
    $getPass = $_POST["userpass"];
		
		try {
			
			$pdo = new PDO(DBCONNSTRING,DBUSER,DBPASS);
			$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			$sql = "SELECT UserName, Password, Salt from UsersLogin where UserName=?";
			
			$statement = $pdo -> prepare($sql);
			$statement -> bindvalue(1, $getUser);
			$statement -> execute();
			
			while ($row = $statement->fetch()){
			
			$saltedPass = md5($getPass . $row['Salt']);	
			
			if ($saltedPass == $row['Password']){
			    //echo "Login worked!";
			    return $saltedPass;
			    
			}
			}
			
			
			$pdo = null;
			}
			catch (PDOException $e) {
			die( $e->getMessage() );
				}
}

function getUserLogin(){
    $getUser = $_POST["username"];
    $getPass = getUserSalt();
    
		try {
			
			$pdo = new PDO(DBCONNSTRING,DBUSER,DBPASS);
			$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			$sql = "SELECT UserName, Password, Salt, FirstName, LastName, Email from UsersLogin INNER JOIN Users ON UsersLogin.UserID = Users.UserID where UserName=? and Password=?";
			
			$statement = $pdo -> prepare($sql);
			$statement -> bindvalue(1, $getUser);
			$statement -> bindvalue(2, $getPass);
			$statement -> execute();
			
			while ($row = $statement->fetch()){
				
				
				$a = "Login Successful!";
                $_SESSION["myusername"] = $row['UserName'];
                $_SESSION["myFirst"] = $row['FirstName'];
                $_SESSION["myLast"] = $row['LastName'];
                $_SESSION["myEmail"] = $row['Email'];
				
			}
			
			if ($a != "Login Successful!")
			{
			    //$a = "Incorrect Username or Password";
			    $_SESSION["attempt"] = 1;
			    
			}
			$pdo = null;
			}
			catch (PDOException $e) {
			die( $e->getMessage() );
				}

    echo $a;
}

getUserLogin();

//echo $_SESSION["myusername"] . "<br>";
//echo $_SESSION["myFirst"];
//echo $_SESSION["myLast"];
//echo $_SESSION["myEmail"];

//$_SESSION["myuser"] = $_POST["username"];
//$_SESSION["mypass"] = $_POST["userpass"];

header("Location:/project1/login.php");

?>