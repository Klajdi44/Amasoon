<?php
session_start();
if (isset($_SESSION['user_id'])) {
  header('Location: index');
}

$_documentTitle = 'Amasoon Registration';
require_once(__DIR__ . '/components/top.php');
?>

<div class="signup__container auth__container">
  <?php require_once(__DIR__ . '/components/logo.php') ?>
  <div class="signup__wrapper auth__wrapper">
    <form onsubmit="return false" class="auth__form signup__form">
      <h1 class="auth__form__title">Create account</h1>
      <p class="auth__form__error error"></p>
      <legend>
        <label for="user_name">Your name</label>
        <small>e.g John Doe</small>
        <input id="user_name" class="user_name input" name="user_name" type="text" placeholder=" ">
      </legend>
      <legend>
        <label for="user_email">Email</label>
        <small>e.g John@doe.com</small>
        <input id="user_email" class="user_email input" name="user_email" type="text" placeholder=" ">
      </legend>
      <legend>
        <label for="user_password">Password</label>
        <small>At least 8 characters</small>
        <input id="user_password" class="user_password input" name="user_password" type="password" placeholder=" ">
      </legend>
      <legend>
        <label for="re-enter_user_password">Confirm password</label>
        <small>Must match password above</small>
        <input id="re-enter_user_password input" class="re-enter_user_password input" name="re-enter_user_password" type="password" placeholder=" ">
      </legend>
      <legend class="form__btn__container">
        <button class="signup__button auth__button" onclick="signup()">Create your amasoon account <span class="loader hidden">
            <i class="fas fa-circle-notch fa-spin"></i>
          </span></button>
      </legend>
      <div class="divider"></div>
      <p>Already have an account? <a href="login"> Sign in </a></p>
    </form>

  </div>
</div>

<script>
  async function signup() {
    const loader = document.querySelector('.loader ');
    loader.classList.remove("hidden");
    const form = event.target.form
    try {
      const request = await fetch("api/api-signup", {
        method: "POST",
        body: new FormData(form)
      })

      const response = await request.json();
      console.log(response);
      document.querySelector('.auth__form__error').textContent = response?.info;
      if (request.ok) {
        location.href = "index"
      }
      loader.classList.add("hidden");

    } catch (error) {
      console.error(error.message);
    }

  }
</script>

<?php
require_once(__DIR__ . '/components/bottom.php');
?>