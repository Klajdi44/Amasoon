<?php
include_once(__DIR__ . "/../private/globals.php");

$userSignedIn = _is_user_signed_in();
if ($userSignedIn) {
	session_start();
	$username = $_SESSION['user_name'];
}

?>


<nav class="nav">
	<a class="nav__logo__container" href="./index"> <img class="nav__logo" src='./assets/logoWhite.svg' alt="logo"></a>
	<div class="nav__search__container">
		<input class="nav__search" type="search">
		<button class="nav__search__button"> <i class="fas fa-search"></i>
		</button>
	</div>

	<p class="nav__login">
		<?php
		echo $userSignedIn ?  "Hello, $username" : ""
		?>
	</p>

	<div class="nav__login__section__container">
		<div class="nav__dropdown">
			<button class="nav__dropbtn primary__btn"><i class="fas fa-caret-down"></i></button>
			<div class="nav__dropdown__content">
				<?php if ($userSignedIn) { ?>
					<a href='./account' class='nav__link'>Account</a>
					<a href='./upload-product' class='nav__link'>Upload product</a>
					<a href='./bridges/logout' class='nav__signout nav__link'>Logout</a>
				<?php } else { ?>
					<a href="./login" class="nav__login__section nav__link"> Log in</a>
					<a href="./signup" class="signup "> Sign up</p>

					<?php } ?>
			</div>
		</div>
</nav>
</div>
<?php if (!$_SESSION['is_verified'] && !$_SESSION['verified_msg_shown']) { ?>
	<?php $_SESSION['verified_msg_shown'] = true ?>
	<p class='nav__is__verified'> Account verification link has been sent to <?= $_SESSION['user_email'] ?>! </p>
<?php } ?>