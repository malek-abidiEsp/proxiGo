// External file (CSP blocks inline JS). Asks confirmation before submitting
// any form having a data-confirm attribute.
document.addEventListener('submit', function (e) {
  var msg = e.target.getAttribute('data-confirm');
  if (msg && !window.confirm(msg)) {
    e.preventDefault();
  }
});
