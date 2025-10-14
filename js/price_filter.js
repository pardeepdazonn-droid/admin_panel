  document.addEventListener("DOMContentLoaded", () => {
    const rangeInput = document.getElementById('priceRange');
    const selectedPrice = document.getElementById('selectedPrice');
    let currentValue = parseInt(rangeInput.value);
    let targetValue = currentValue;
    let animationFrame;
    function animate() {
      const diff = targetValue - currentValue;
      if (Math.abs(diff) < 0.5) {
        currentValue = targetValue;
        selectedPrice.textContent = Math.round(currentValue).toLocaleString();
        return;
      }
      currentValue += diff * 0.2;
      selectedPrice.textContent = Math.round(currentValue).toLocaleString();
      animationFrame = requestAnimationFrame(animate);
    }
    rangeInput.addEventListener('input', function() {
      targetValue = parseInt(this.value);
      cancelAnimationFrame(animationFrame);
      animationFrame = requestAnimationFrame(animate);
    });
  });