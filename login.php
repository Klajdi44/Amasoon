<?php
session_start();
if (isset($_SESSION['user_id'])) {
  header('Location: index');
}

$_documentTitle = 'sign in';
require_once(__DIR__ . '/components/top.php');
?>
<div class="auth__container">
  <?php require_once(__DIR__ . '/components/logo.php') ?>
  <div class="auth__wrapper">
    <form onsubmit="return false" class="auth__form">
      <h1 class="auth__form__title">Sign-in</h1>
      <p class="auth__form__error"></p>
      <legend>
        <label for="user_email">Email</label>
        <small>e.g John@doe.com</small>
        <input id="user_email" class="user_email" name="user_email" type="text" placeholder=" ">
      </legend>
      <legend>
        <label for="user_password">Password</label>
        <small>At least 8 characters</small>
        <input id="user_password" class="user_password" name="user_password" type="password" placeholder=" ">
      </legend>
      <legend class="form__btn__container">
        <button class="auth__button  primary__btn" onclick="login()">Continue</button>
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

<script>
  async function login() {
    const form = event.target.form
    try {
      let conn = await fetch("api/api-login", {
        method: "POST",
        body: new FormData(form)
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