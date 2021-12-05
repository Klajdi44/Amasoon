const _USERNAME_MIN_LEN = 1;
const _USERNAME_MAX_LEN = 50;
const _PASSWORD_MIN_LEN = 8;
const _PASSWORD_MAX_LEN = 20;

function dqs(element, selectAll = false) {
  return selectAll
    ? Array.from(document.querySelectorAll(element))
    : document.querySelector(element);
}
