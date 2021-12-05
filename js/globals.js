const _USERNAME_MIN_LEN = 1;
const _USERNAME_MAX_LEN = 50;
const _PASSWORD_MIN_LEN = 8;
const _PASSWORD_MAX_LEN = 20;
const _PHONE_LEN = 8;

function dqs(element, selectAll = false) {
  return selectAll
    ? Array.from(document.querySelectorAll(element))
    : document.querySelector(element);
}

function containsString(text) {
  for (let i = 0; i < text.length; i++) {
    const character = text[i];

    if (isNaN(character)) {
      return true;
    }
  }
  return false;
}

function containsNumber(text) {
  for (let i = 0; i < text.length; i++) {
    const character = text[i];

    if (!isNaN(character)) {
      return true;
    }
  }
  return false;
}

function focus(element) {
  element.focus();
}
function testEmail(email) {
  if (/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/.test(email)) return true;
  else return false;
}

function _validateName(form, infoElement) {
  if (form.user_name.value.trim().length < _USERNAME_MIN_LEN) {
    focus(form.user_name);
    infoElement.textContent = `Name must be at least ${_USERNAME_MIN_LEN} characters long`;
    return false;
  }

  if (form.user_name.value.trim().length > _USERNAME_MAX_LEN) {
    focus(form.user_name);
    infoElement.textContent = `Name cannot be more than ${_USERNAME_MAX_LEN} characters long`;
    return false;
  }

  if (containsNumber(form.user_name.value.trim())) {
    focus(form.user_name);
    infoElement.textContent = `Name cannot contain numbers`;
    return false;
  }
  return true;
}

function _validateEmail(form, infoElement) {
  if (!form.user_email.value.trim().length) {
    focus(form.user_email);
    infoElement.textContent = `Email required`;
    return false;
  }

  if (!testEmail(form.user_email.value.trim())) {
    focus(form.user_email);
    infoElement.textContent = `Email is invalid`;
    return false;
  }
  return true;
}

function _validatePhone(form, infoElement) {
  if (!form.user_phone_number.value.trim().length) {
    focus(form.user_phone_number);
    infoElement.textContent = `Phone number required`;
    return false;
  }

  if (
    form.user_phone_number.value.trim().length < _PHONE_LEN ||
    form.user_phone_number.value.trim().length > _PHONE_LEN
  ) {
    focus(form.user_phone_number);
    infoElement.textContent = `Phone number must be ${_PHONE_LEN} characters long`;
    return false;
  }

  if (containsString(form.user_phone_number.value.trim())) {
    focus(form.user_phone_number);
    infoElement.textContent = "Phone number must contain only numbers";
    return false;
  }

  return true;
}

function _validatePassword(form, infoElement, skipConfirmPass = false) {
  if (!form.user_password.value.trim().length) {
    focus(form.user_password);
    infoElement.textContent = "Password field required!";
    return false;
  }

  if (!skipConfirmPass) {
    if (!form.confirm_password.value.trim().length) {
      focus(form.confirm_password);
      infoElement.textContent = "Confirm password field required!";
      return false;
    }

    if (form.user_password.value.trim() != form.confirm_password.value.trim()) {
      focus(form.user_password);
      infoElement.textContent = "Passwords do not match!";
      return false;
    }
  }

  if (form.user_password.value.trim().length < _PASSWORD_MIN_LEN) {
    focus(form.user_password);
    infoElement.textContent = `Password has be at least ${_PASSWORD_MIN_LEN} characters long`;
    return false;
  }

  if (form.user_password.value.trim().length > _PASSWORD_MAX_LEN) {
    focus(form.user_password);
    infoElement.textContent = `Password cannot be more that ${_PASSWORD_MAX_LEN} characters`;
    return false;
  }
  return true;
}

function _validateFields(form, infoElement, skipPassword = false) {
  //username
  if (!_validateName(form, infoElement)) {
    return false;
  }

  //email
  if (!_validateEmail(form, infoElement)) {
    return false;
  }

  //phone number
  if (!_validatePhone(form, infoElement)) {
    return false;
  }

  //password
  if (!skipPassword) {
    if (!_validatePassword(form, infoElement)) {
      return false;
    }
  }

  return true;
}
