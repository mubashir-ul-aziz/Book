
document.addEventListener("DOMContentLoaded", function() {
  const headers = document.querySelectorAll(".bk_manager .accordion-header");

  headers.forEach(header => {
    header.addEventListener("click", function() {

      if(event.target.tagName === "SELECT" || event.target.tagName === "INPUT") {
        return; 
      }

      const content = this.nextElementSibling;

      const hasValue = Array.from(content.querySelectorAll("select, input")).some(input => input.value && input.value !== "");

      headers.forEach(h => {
        const c = h.nextElementSibling;
        if(h !== this) {
          const cHasValue = Array.from(c.querySelectorAll("select, input")).some(input => input.value && input.value !== "");
          if(!cHasValue) { // only close if no value selected
            h.classList.remove("active");
            c.classList.remove("active");
          }
        }
      });

      this.classList.toggle("active");
      content.classList.toggle("active");
    });
  });
});




document.addEventListener("DOMContentLoaded", function () {

    const filterForm = document.querySelector('.book-filter-form');
    if (!filterForm) {
        console.log("stop script on single pages");
        return;
    }

    const priceSlider = document.getElementById('priceSlider');
    const priceRangeValue = document.getElementById('priceRangeValue');
    const minPriceInput = document.getElementById('minPrice');
    const maxPriceInput = document.getElementById('maxPrice');

    if (!priceSlider) return;

    // Read dynamic min/max from data attributes
    const minPrice = parseFloat(priceSlider.dataset.min) || 0;
    const maxPrice = parseFloat(priceSlider.dataset.max) || 500;

    noUiSlider.create(priceSlider, {
        start: [minPrice, maxPrice],
        connect: true,
        range: {
            'min': minPrice,
            'max': maxPrice
        },
        step: 10,
        tooltips: [true, true],
        format: {
            to: value => Math.round(value),
            from: value => Number(value)
        }
    });

    priceSlider.noUiSlider.on('update', (values) => {
        const [min, max] = values;
        priceRangeValue.textContent = `${min} - ${max}`;
        minPriceInput.value = min;
        maxPriceInput.value = max;
    });
});


