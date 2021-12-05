const _USERNAME_MIN_LEN = 1;
const _USERNAME_MAX_LEN = 50;
const _PASSWORD_MIN_LEN = 8;
const _PASSWORD_MAX_LEN = 20;
const _PHONE_LEN = 8;

function _dqs(element, selectAll = false) {
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
  text = text.replaceAll(" ", "");
  for (let i = 0; i < text.length; i++) {
    const character = text[i];

    if (!isNaN(character)) {
      return true;
    }
  }
  return false;
}

function _focus(element) {
  element.focus();
}
function testEmail(email) {
  if (/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/.test(email)) return true;
  else return false;
}

function _validateName(form, infoElement) {
  if (form.user_name.value.trim().length < _USERNAME_MIN_LEN) {
    return {
      fieldOk: false,
      info: `Name must be at least ${_USERNAME_MIN_LEN} characters long`,
      element: form.user_name,
    };
  }

  if (form.user_name.value.trim().length > _USERNAME_MAX_LEN) {
    focus(form.user_name);
    return {
      fieldOk: false,
      info: `Name cannot be more than ${_USERNAME_MAX_LEN} characters long`,
      element: form.user_name,
    };
  }

  if (containsNumber(form.user_name.value.trim())) {
    return {
      fieldOk: false,
      info: "Name cannot contain numbers",
      element: form.user_name,
    };
  }
  return {
    fieldOk: true,
    info: "",
    element: "",
  };
}

function _validateEmail(form) {
  if (!form.user_email.value.trim().length) {
    return {
      fieldOk: false,
      info: "Email required",
      element: form.user_email,
    };
  }

  if (!testEmail(form.user_email.value.trim())) {
    return {
      fieldOk: false,
      info: "Email is invalid",
      element: form.user_email,
    };
  }

  return {
    fieldOk: true,
    info: "",
    element: "",
  };
}

function _validatePhone(form) {
  if (!form.user_phone_number.value.trim().length) {
    return {
      fieldOk: false,
      info: "Phone number required",
      element: form.user_phone_number,
    };
  }

  if (
    form.user_phone_number.value.trim().length < _PHONE_LEN ||
    form.user_phone_number.value.trim().length > _PHONE_LEN
  ) {
    return {
      fieldOk: false,
      info: `Phone number must be ${_PHONE_LEN} characters long`,
      element: form.user_phone_number,
    };
  }

  if (containsString(form.user_phone_number.value.trim())) {
    return {
      fieldOk: false,
      info: "Phone number must contain only numbers",
      element: form.user_phone_number,
    };
  }

  return {
    fieldOk: true,
    info: "",
    element: "",
  };
}

function _validatePassword(form, skipConfirmPass = false) {
  if (!form.user_password.value.trim().length) {
    return {
      fieldOk: false,
      info: "Password field required!",
      element: form.user_password,
    };
  }

  if (!skipConfirmPass) {
    if (!form.confirm_password.value.trim().length) {
      return {
        fieldOk: false,
        info: "Confirm password field required!",
        element: form.confirm_password,
      };
    }

    if (form.user_password.value.trim() != form.confirm_password.value.trim()) {
      return {
        fieldOk: false,
        info: "Passwords do not match!",
        element: form.user_password,
      };
    }
  }

  if (form.user_password.value.trim().length < _PASSWORD_MIN_LEN) {
    return {
      fieldOk: false,
      info: `Password has be at least ${_PASSWORD_MIN_LEN} characters long`,
      element: form.user_password,
    };
  }

  if (form.user_password.value.trim().length > _PASSWORD_MAX_LEN) {
    return {
      fieldOk: false,
      info: `Password cannot be more that ${_PASSWORD_MAX_LEN} characters`,
      element: form.user_password,
    };
  }
  return {
    fieldOk: true,
    info: "",
    element: "",
  };
}

function _validateFields(form, skipPassword = false) {
  //username
  if (!_validateName(form).fieldOk) {
    const { fieldOk, info, element } = _validateName(form);
    return {
      fieldOk,
      info,
      element,
    };
  }

  //email
  if (!_validateEmail(form).fieldOk) {
    const { fieldOk, info, element } = _validateEmail(form);
    return {
      fieldOk,
      info,
      element,
    };
  }

  //phone number
  if (!_validatePhone(form).fieldOk) {
    const { fieldOk, info, element } = _validatePhone(form);
    return {
      fieldOk,
      info,
      element,
    };
  }

  //password
  if (!skipPassword) {
    if (!_validatePassword(form).fieldOk) {
      const { fieldOk, info, element } = _validatePassword(form);
      return {
        fieldOk,
        info,
        element,
      };
    }
  }

  return {
    fieldOk: true,
  };
}
