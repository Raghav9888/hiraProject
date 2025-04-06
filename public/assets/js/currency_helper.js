const conversionRates = {
    usd: 1,
    cad: 1.42308,
};

function convertAmount(amount, fromCurrency, toCurrency) {
    if (fromCurrency === toCurrency) {
        return amount;
    }
    return amount * conversionRates[toCurrency] / conversionRates[fromCurrency];
}

$(document).on('change', '#currencySelect', function () {
    const selectedCurrency = $(this).val(); // 'usd' or 'cad'
    const currencySymbol = selectedCurrency === 'usd' ? '$' : 'CA$';

    $('.offering_process').each(function () {
        const $btn = $(this);

        // Base price is in CAD
        const cadPrice = $btn.data('cad-price') || 0;

        const convertedPrice = convertAmount(cadPrice, 'cad', selectedCurrency);

        $btn.attr('data-price', convertedPrice.toFixed(2));
        $btn.attr('data-currency', selectedCurrency);
        $btn.attr('data-currency-symbol', currencySymbol);

        const $priceElement = $btn.closest('.d-flex').find('.offer-prize');
        $priceElement.text(currencySymbol + convertedPrice.toFixed(2));
    });
});
