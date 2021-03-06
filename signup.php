<?php
session_start();
if (isset($_SESSION['user_id'])) {
  header('Location: index');
}

$_documentTitle = 'Registration';
require_once(__DIR__ . '/components/top.php');
?>

<main class="signup__container auth__container  page-width">
  <?php require_once(__DIR__ . '/components/logo.php') ?>
  <div class="signup__wrapper auth__wrapper">
    <form onsubmit="return false" class="auth__form signup__form">
      <h1 class="auth__form__title">Create account</h1>
      <p class="auth__form__error error"></p>
      <legend>
        <label for="user_name">Your name</label>
        <small>e.g John</small>
        <input id="user_name" class="user_name input" name="user_name" type="text" placeholder=" ">
      </legend>
      <legend>
        <label for="user_last_name">Your last name</label>
        <small>e.g Doe</small>
        <input id="user_last_name" class="user_last_name input" name="user_last_name" type="text" placeholder=" ">
      </legend>
      <legend>
        <label for="user_email">Email</label>
        <small>e.g John@doe.com</small>
        <input id="user_email" class="user_email input" name="user_email" type="text" placeholder=" ">
      </legend>
      <legend>
        <label for="user_phone_number">Phone number</label>
        <small>Only Danish numbers e.g 40636096</small>
        <input id="user_phone_number" class="user_phone_number input" name="user_phone_number" type="tel" placeholder=" ">
      </legend>
      <legend>
        <label for="user_password">Password</label>
        <small>At least 8 characters</small>
        <input id="user_password" class="user_password input" name="user_password" type="password" placeholder=" ">
      </legend>
      <legend>
        <label for="confirm_user_password">Confirm password</label>
        <small>Must match password above</small>
        <input id="confirm_user_password" class="confirm_user_password input" name="confirm_user_password" type="password" placeholder=" ">
      </legend>
      <legend class="form__btn__container">
        <button class="signup__button auth__button">Create your amasoon account <span class="loader hidden">
            <i class="fas fa-circle-notch fa-spin"></i>
          </span></button>
      </legend>
      <div class="divider"></div>
      <p>Already have an account? <a href="login"> Sign in </a></p>
    </form>

  </div>
</main>

<script type='module'>
  _dqs('.signup__button').onclick = signup;
  async function signup() {
    const loader = _dqs('.loader ');
    const btn = _dqs('.signup__button');
    const form = event.target.form
    const infoElement = _dqs('.auth__form__error');

    //**validation */
    const {
      fieldOk,
      info,
      element
    } = _validateFields(form);

    if (!fieldOk) {
      _focus(element);
      return infoElement.textContent = info;
    }


    loader.classList.remove("hidden");
    btn.disabled = true;
    try {
      const request = await fetch("api/api_signup", {
        method: "POST",
        body: new FormData(form)
      })

      const response = await request.json();
      infoElement.textContent = response?.info;
      if (request.ok) {
        location.href = "index";
      }
      btn.disabled = false;
      loader.classList.add("hidden");
    } catch (error) {
      console.error(error.message);
      btn.disabled = false;
      loader.classList.add("hidden");
    }
  }
</script>

<?php
require_once(__DIR__ . '/components/bottom.php');
?>