<?php
$_documentTitle = 'Amasoon Registration';
require_once('./components/top.php');
?>

<div class="signup__container">

  <div class="signup__wrapper">
    <img class="signup__logo" src="" alt="">

    <form onsubmit="return false" class="form signup__form">
      <div>
        <label for="user_name">Your name</label>
        <small>e.g John Doe</small>
        <input id="user_name" class="user_name" name="user_name" type="text" placeholder=" ">
      </div>
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
      <legend class="signup__form__btn__container">
        <button class="signup__button" onclick="signup()">Create your Amasoon account</button>
      </legend>
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