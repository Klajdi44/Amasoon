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

function validateEmail(email) {
  if (/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/.test(email)) return true;
  else return false;
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
