<?php
$_documentTitle = 'Amasoon Registration';
require_once('./components/top.php');
?>

<div class="signup__container">

  <img class="signup__logo logo" src="./assets/logo1.svg" alt="logo">

  <div class="signup__wrapper">
    <form onsubmit="return false" class="form signup__form">
      <h1 class="signup__form__title" >Create account</h1>
      <legend>
        <label for="user_name">Your name</label>
        <small>e.g John Doe</small>
        <input id="user_name" class="user_name" name="user_name" type="text" placeholder=" ">
      </legend>
      <legend>
        <label for="user_email">Email</label>
        <small>e.g john@doe.com</small>
        <input id="user_email" class="user_email" name="user_email" type="text" placeholder=" ">
      </legend>
      <legend>
        <label for="user_password">Password</label>
        <small>At least 8 characters</small>
        <input id="user_password" class="user_password" name="user_password" type="password" placeholder=" ">
      </legend>
      <legend>
        <label for="re-enter_user_password">Re-enter password</label>
        <small>Must match password above</small>
        <input id="re-enter_user_password" class="re-enter_user_password" name="re-enter_user_password" type="password" placeholder=" ">
      </legend>
      <legend class="signup__form__btn__container">
        <button class="signup__button" onclick="signup()">Create your Amasoon account</button>
      </legend>
      <div class="divider"></div>
      <p>Already have an account? <a href="login"> Sign in </a></p>
    </form>

  </div>

</div>

<script>
  async function signup() {
    const form = event.target.form

    const request = await fetch("api-signup", {
      method: "POST",
      body: new FormData(form)
    })

    const response = await request.json();
    console.log(response);
    if (request.ok) {
      location.href = "user"
    }
  }
</script>

<?php
require_once('./components/top.php');
?>