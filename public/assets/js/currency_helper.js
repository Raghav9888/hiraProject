const conversionRates = {
    usd: 0.70, // fallback in case API fails
    cad: 1     // base currency
};

// Fetch live exchange rate CAD → USD
async function fetchExchangeRate() {
    try {
        const response = await fetch('https://api.exchangerate-api.com/v4/latest/CAD');
        const data = await response.json();

        const usdRate = data?.rates?.USD;
        if (!usdRate) {
            console.error('USD rate not found in API response', data);
            return null;
        }

        // Set the live rate in your global object
        conversionRates.usd = usdRate;
        console.log(`Live CAD to USD rate: ${usdRate}`);
        return usdRate;
    } catch (error) {
        console.error('Error fetching exchange rate:', error);
        return null;
    }
}

// Convert currency based on fetched rates
function convertAmount(amount, fromCurrency, toCurrency) {
    const fromRate = conversionRates[fromCurrency.toLowerCase()];
    const toRate = conversionRates[toCurrency.toLowerCase()];

    if (typeof amount !== 'number' || isNaN(amount) || !fromRate || !toRate) {
        return NaN;
    }

    return (amount * toRate) / fromRate;
}

// Format price with commas
function formatPrice(number) {
    return number.toLocaleString(); // Adds comma like 3,170
}

// Update all offering prices
function updatePrices(selectedCurrency) {
    const currencySymbol = selectedCurrency === 'usd' ? '$' : 'CA$';

    $('.offering_process').each(function () {
        const $btn = $(this);
        let cadPriceRaw = $btn.data('cad-price'); // e.g. "CA$4,500"

        if (typeof cadPriceRaw === 'string') {
            cadPriceRaw = cadPriceRaw.replace(/[^\d.]/g, ''); // Remove CA$ and commas
        }

        cadPriceRaw = parseFloat(cadPriceRaw);

        const convertedPrice = convertAmount(cadPriceRaw, 'cad', selectedCurrency);

        if (!isNaN(convertedPrice)) {
            const roundedPrice = Math.round(convertedPrice); // Round to nearest dollar
            const formattedPrice = formatPrice(roundedPrice);

            $btn.attr('data-price', roundedPrice);
            $btn.attr('data-currency', selectedCurrency);
            $btn.attr('data-currency-symbol', currencySymbol);

            const $priceElement = $btn.closest('.d-flex').find('.offer-prize');
            $priceElement.text(currencySymbol + formattedPrice);
        } else {
            console.warn('Invalid price conversion:', cadPriceRaw);
        }
    });
}

// On currency dropdown change
$(document).on('change', '#currencySelect', async function () {
    const selectedCurrency = $(this).val(); // 'usd' or 'cad'

    if (selectedCurrency === 'usd') {
        const rate = await fetchExchangeRate(); // Fetch real-time USD rate
        if (rate !== null) {
            updatePrices('usd');
        } else {
            console.warn('Using fallback rate (0.70)');
            updatePrices('usd');
        }
    } else {
        updatePrices('cad');
    }
});
