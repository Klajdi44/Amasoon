<?php
session_start();
if (isset($_SESSION['user_id'])) {
  header('Location: index');
}

$_documentTitle = 'Log in';
require_once(__DIR__ . '/components/top.php');
?>
<div class="auth__container  page-width">
  <?php require_once(__DIR__ . '/components/logo.php') ?>
  <div class="auth__wrapper">
    <form onsubmit="return false" class="auth__form">
      <h1 class="auth__form__title">Sign-in</h1>
      <p class="auth__form__error error"></p>
      <legend>
        <label for="user_email">Email or phone number</label>
        <small>e.g John@doe.com OR 42 34 56 78 (8 characters)</small>
        <input id="user_email" class="user_email input" name="user_email" type="text" placeholder=" ">
        <input id="user_phone_number" class="user_phone_number input" name="user_phone_number" type="hidden" placeholder=" ">
      </legend>
      <legend>
        <label for="user_password">Password</label>
        <small>At least 8 characters</small>
        <input id="user_password" class="user_password input" name="user_password" type="password" placeholder=" ">
      </legend>
      <legend class="form__btn__container">
        <button class="auth__button  primary__btn">Continue</button>
      </legend>

      <details>
        <summary class="auth__need__help">Need help? </summary>
        <a class="auth__forgot__password" href="forgot-password">Forgot password</a>
      </details>

      <small class="new__to__amasoon">New to Amasson?</small>

      <a href="signup"><input type="button" class=" auth__button login__button" value="Create your Amasoon account" /> </a>
    </form>

  </div>

</div>

<script type="module">
  _dqs('.primary__btn').onclick = login;
  async function login() {
    const form = event.target.form
    form.user_phone_number.value = form.user_email.value.trim();
    const formData = new FormData();
    const infoElement = _dqs('.error');

    if (!form.user_email.value.trim().length) {
      _focus(form.user_email);
      return infoElement.textContent = "Email or phone number required"
    }

    if (!_validateEmail(form).fieldOk && !_validatePhone(form).fieldOk) {
      _focus(form.user_email);
      return infoElement.textContent = "Email or phone number not correct"
    }

    if (_validateEmail(form).fieldOk) {
      formData.append('user_email', form.user_email.value.trim());
    }
    if (_validatePhone(form).fieldOk) {
      formData.append('user_phone_number', form.user_phone_number.value);
    }

    //password
    const {
      fieldOk,
      info,
      element
    } = _validatePassword(form, true);
    if (!fieldOk) {
      _focus(element);
      return infoElement.textContent = info;
    }

    formData.append('user_password', form.user_password.value);
    try {
      let conn = await fetch("api/api_login", {
        method: "POST",
        body: formData
      })

      let res = await conn.json();
      console.log(res);
      document.querySelector('.auth__form__error').textContent = res?.info;
      if (conn.ok) {
        location.href = "index"
      }
    } catch (error) {
      console.error(error.message);
    }

  }
</script>

<?php
require_once(__DIR__ . '/components/bottom.php');
?>