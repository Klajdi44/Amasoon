const _USERNAME_MIN_LEN = 1;
const _USERNAME_MAX_LEN = 50;
const _USER_LAST_NAME_MIN_LEN = 1;
const _USER_LAST_NAME_MAX_LEN = 50;
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
function _testEmail(email) {
  if (/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/.test(email)) return true;
  else return false;
}

function _renderProducts(products, outputElement, isPartnerProduct = false) {
  products.forEach(product => {
    const bluePrint = `
<article class="product__item"> 
<a href='./product-overview.php?id=${product.id}' >
<img class='product__img' src=${
      isPartnerProduct
        ? `https://coderspage.com/2021-F-Web-Dev-Images/${product.image}`
        : `./assets/${product.image}.jpeg`
    } alt="product">
<div class="product__body">
  <h2 class="product__title">${product.title}</h2>
  <h3 class="product__price">Kr.${product.price}</h3>
</div>
</a>
</article>
`;
    outputElement.insertAdjacentHTML("beforeend", bluePrint);
  });
}

function _renderCategories(categories, outputElement) {
  categories.forEach(({ category }) => {
    const bluePrint = `
		<article class="category">
			<a href=./products.php?category=${category}>
				<h2>${category}</h2>
				<img class="category__image" src="./assets/${category}.png" alt="Electronics">
			</a>
		</article>
`;
    outputElement.insertAdjacentHTML("beforeend", bluePrint);
  });
}

function _renderProductOverview(
  product,
  outputElement,
  isPartnerProduct = false
) {
  const bluePrint = `
  <section class="product__overview">
		<img class='product__overview__img'  src=${
      isPartnerProduct
        ? `https://coderspage.com/2021-F-Web-Dev-Images/${product.image}`
        : `./assets/${product.image}.jpeg`
    } alt="">
		<article class="product__overview__content">
			<div class="product__overview__body">
				<h2 class="product__overview__title">${product.title}</h2>
				<h3 class="product__overview__price">Kr.${product.price}</h3>
			</div>
			<p class="product__overview__description">${product.description}</p>
		</article>
	</section>`;

  outputElement.insertAdjacentHTML("beforeend", bluePrint);
}

function _validateName(form) {
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

function _validateLastName(form) {
  if (form.user_last_name.value.trim().length < _USER_LAST_NAME_MIN_LEN) {
    return {
      fieldOk: false,
      info: `Last name must be at least ${_USER_LAST_NAME_MIN_LEN} characters long`,
      element: form.user_last_name,
    };
  }

  if (form.user_last_name.value.trim().length > _USER_LAST_NAME_MAX_LEN) {
    focus(form.user_last_name);
    return {
      fieldOk: false,
      info: `Last name cannot be more than ${_USER_LAST_NAME_MAX_LEN} characters long`,
      element: form.user_last_name,
    };
  }

  if (containsNumber(form.user_last_name.value.trim())) {
    return {
      fieldOk: false,
      info: "Last name cannot contain numbers",
      element: form.user_last_name,
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

  if (!_testEmail(form.user_email.value.trim())) {
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
    if (!form.confirm_user_password.value.trim().length) {
      return {
        fieldOk: false,
        info: "Confirm password field required!",
        element: form.confirm_user_password,
      };
    }

    if (
      form.user_password.value.trim() != form.confirm_user_password.value.trim()
    ) {
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
  //user name
  if (!_validateName(form).fieldOk) {
    return _validateName(form);
  }
  //user last name
  if (!_validateLastName(form).fieldOk) {
    return _validateLastName(form);
  }

  //email
  if (!_validateEmail(form).fieldOk) {
    return _validateEmail(form);
  }

  //phone number
  if (!_validatePhone(form).fieldOk) {
    return _validatePhone(form);
  }

  //password
  if (!skipPassword) {
    if (!_validatePassword(form).fieldOk) {
      return _validatePassword(form);
    }
  }

  return {
    fieldOk: true,
  };
}
