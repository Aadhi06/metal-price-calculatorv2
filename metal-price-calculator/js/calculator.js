document.addEventListener('DOMContentLoaded', () => {
    const pricePerOunce = metalPriceCalculatorData.pricePerOunce; // Get price from localized script data
    const updatedTime = metalPriceCalculatorData.updatedTime;
    const pricePerGram = pricePerOunce / 31.1035;

    document.getElementById('pricePerOunce').textContent = pricePerOunce;
    document.getElementById('updatedtime').textContent = updatedTime;

    const gramsInputs = document.querySelectorAll('.metal-calculator-input');
    const prices = {
        '9k': 9 / 24,
        '10k': 10 / 24,
        '12k': 12 / 24,
        '14k': 14 / 24,
        '15k': 15 / 24,
        '18k': 18 / 24,
        '21k': 21 / 24,
        '22k': 22 / 24,
        '22kc': 22 / 24, // Assuming coins have the same value as 22k gold
        '24k': 24 / 24
    };

    gramsInputs.forEach(input => {
        input.addEventListener('input', updatePrices);
    });

    function updatePrices() {
        let totalAmount = 0;
        for (let key in prices) {
            const grams = parseFloat(document.getElementById('grams' + key).value) || 0;
            if (isNaN(grams) || grams < 0) {
                alert('Please enter a valid number for grams.');
                continue;
            }
            const amount = grams * pricePerGram * prices[key];
            document.getElementById('price' + key).textContent = amount.toFixed(2);
            totalAmount += amount;
        }
        document.getElementById('totalAmount').textContent = totalAmount.toFixed(2);
    }
});
