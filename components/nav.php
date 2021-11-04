<?php
session_start();
$userSignedIn = isset($_SESSION['user_id']) ? true : false;
if ($userSignedIn) {
	$username = $_SESSION['user_name'];
}
$lel = 'nav__signin hidden'
?>


<nav class="nav">
	<a class="nav__logo__container" href="./index.php"> <img class="nav__logo" src='./assets/logoWhite.svg' alt="logo"></a>
	<div class="nav__search__container">
		<input class="nav__search" type="search">
		<button class="nav__search__button"> <i class="fas fa-search"></i>
		</button>
	</div>

	<div class="nav__login">
		<?php
		echo $userSignedIn ?  "Hello, $username" : "Hello, sign in"
		?>
	</div>
	<div class="nav__login__section__container">
		<span class=<?= $userSignedIn ? 'nav__login__section hidden'  : 'nav__login__section' ?>>
			<button class=" signup__button"><a href="./login"> Sign in </a></button>
			<p class="signup"> New customer? <a href="./signup"> start here </a></p>
		</span>
		<?= $userSignedIn ? "<a href='logout' class='nav__signout'>Logout</a>" : '' ?>
	</div>

</nav>