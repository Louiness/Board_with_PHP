<?php
//세션 : 로그인 정보를 서버에 저장.

// 데이터베이스 연결
$db = mysqli_connect('localhost', 'root', '', 'multi_login');

// variable declaration
$username = "";
$email    = "";
$errors   = array();

// register_btn을 클릭하면(버튼이 값을 가지고 있다) register()함수를 호출
if (isset($_POST['register_btn'])) {
	register();
}

// 유저 등록
function register(){
//global : 전역변수를 함수 내부로 가져와서 유효 범위로 설정(전역변수를 사용 가능하게)하는 키워드
//global 키워드를 사용하지 않은 경우에 함수 내에서 전역변수를 사용하면 함수 내에서 전역변수의 값이
//달라졌다하더라도 값이 변하지 않는다
	global $db, $errors, $username, $email;

	// form에서 입력한 모든 값을 받음. e()함수 호출
	$username    =  e($_POST['username']);
	$email       =  e($_POST['email']);
	$password_1  =  e($_POST['password_1']);
	$password_2  =  e($_POST['password_2']);

	// 변수에 값이 들어 있는지 아닌지
	if (empty($username)) {
		array_push($errors, "Username is required");
	}
	if (empty($email)) {
		array_push($errors, "Email is required");
	}
	if (empty($password_1)) {
		array_push($errors, "Password is required");
	}
	if ($password_1 != $password_2) {
		array_push($errors, "The two passwords do not match");
	}

	// 오류가 없는 경우 사용자 등록
	if (count($errors) == 0) {
		//md5 : 문자열을 16진수 32글자로 된 md5 해시값으로 변환
		$password = md5($password_1); // 데이터베이스에 저장하기 전에 암호를 암호화

			$query = "INSERT INTO users (username, email, user_type, password)
					  VALUES('$username', '$email', 'user', '$password')";
			mysqli_query($db, $query);

			// 생성된 사용자 id를 얻는다. 로그인 실행
			$logged_in_user_id = mysqli_insert_id($db);

			$_SESSION['user'] = getUserById($logged_in_user_id); // 세션에 로그인 한 사용자 넣기
			header('location: ../../index.php'); //header : php문서의 헤더 정보를 보내는 함수
			//index.php 파일로 이동한다.
	}
}

// return user array from their id
function getUserById($id){
	global $db;
	//id를 조건으로 하는 users 테이블의 레코드 출력
	$query = "SELECT * FROM users WHERE id=" . $id;
	$result = mysqli_query($db, $query);

	//mysqli_fetch_assoc : mysqli_query를 통해 얻은 레코드값($result)을 $user에 저장
	$user = mysqli_fetch_assoc($result);
	return $user;
}

// escape string
function e($val){
	global $db;
	return mysqli_real_escape_string($db, trim($val)); //trim : 문자열의 맨 앞과 맨 뒤의 여백을 제거
}

function display_error() {
	global $errors;

	if (count($errors) > 0){
		echo '<div class="error">';
			foreach ($errors as $error){
				echo $error .'<br>';
			}
		echo '</div>';
	}
}
function isLoggedIn()
{
	if (isset($_SESSION['user'])) {
		return true;
	}else{
		return false;
	}
}
// 로그아웃 버튼 클릭시 로그 아웃
if (isset($_GET['logout'])) {
	session_destroy(); //세션에 등록된 모든 데이터 파괴
	unset($_SESSION['user']); //주어진 변수 제거. 함수 안에서 전역 변수를 unset 하면, 로컬 변수만 제거됨. 함수 내에서 변수는 unset을 호출하기 전과 같은 값을 유지해야한다.
	header("location: index.php");
}
// 로그인 함수 호출
if (isset($_POST['login_btn'])) {
	login();
}

// LOGIN USER
function login(){
	global $db, $username, $errors;

	// grap form values
	$username = e($_POST['username']);
	$password = e($_POST['password']);

	// make sure form is filled properly
	if (empty($username)) {
		array_push($errors, "Username is required");
	}
	if (empty($password)) {
		array_push($errors, "Password is required");
	}

	// attempt login if no errors on form
	if (count($errors) == 0) {
		$password = md5($password);

		$query = "SELECT * FROM users WHERE username='$username' AND password='$password' LIMIT 1";
		$results = mysqli_query($db, $query);

		if (mysqli_num_rows($results) == 1) { // user found
			// check if user is admin or user
			$logged_in_user = mysqli_fetch_assoc($results);
				$_SESSION['user'] = $logged_in_user;
				header('location: ../../index.php');
		}else {
			array_push($errors, "Wrong username/password combination");
		}
	}
}
