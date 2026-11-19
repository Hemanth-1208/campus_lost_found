document.addEventListener('DOMContentLoaded', () => {
  // Confirm before leaving the page through any future destructive action.
  document.querySelectorAll('[data-confirm]').forEach((el) => {
    el.addEventListener('click', (event) => {
      if (!window.confirm(el.dataset.confirm || 'Are you sure?')) event.preventDefault();
    });
  });

  // Set date inputs to today when a maximum date is not already specified.
  document.querySelectorAll('input[type="date"]:not([max])').forEach((input) => {
    input.max = new Date().toISOString().slice(0, 10);
  });
});
