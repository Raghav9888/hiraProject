const conversionRates = {
    usd: 0.70, // 1 CAD = 0.70 USD
    cad: 1     // CAD is base
};

function convertAmount(amount, fromCurrency, toCurrency) {
    const fromRate = conversionRates[fromCurrency];
    const toRate = conversionRates[toCurrency];

    if (typeof amount !== 'number' || isNaN(amount) || !fromRate || !toRate) {
        return NaN;
    }

    return (amount * toRate) / fromRate;
}

$(document).on('change', '#currencySelect', function () {
    const selectedCurrency = $(this).val(); // 'usd' or 'cad'
    const currencySymbol = selectedCurrency === 'usd' ? '$' : 'CA$';

    $('.offering_process').each(function () {
        const $btn = $(this);
        let cadPriceRaw = $btn.data('cad-price'); // e.g., "CA$1.0"

        if (typeof cadPriceRaw === 'string') {
            cadPriceRaw = cadPriceRaw.replace(/[^0-9.]/g, ''); // strip CA$ etc.
        }

        const cadPrice = parseFloat(cadPriceRaw);

        const convertedPrice = convertAmount(cadPrice, 'cad', selectedCurrency);

        if (!isNaN(convertedPrice)) {
            $btn.attr('data-price', convertedPrice.toFixed(2));
            $btn.attr('data-currency', selectedCurrency);
            $btn.attr('data-currency-symbol', currencySymbol);

            const $priceElement = $btn.closest('.d-flex').find('.offer-prize');
            $priceElement.text(currencySymbol + convertedPrice.toFixed(2));
        } else {
            console.warn(`Invalid conversion for price:`, cadPriceRaw);
        }
    });
});
