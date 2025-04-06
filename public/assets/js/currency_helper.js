const conversionRates = {
    usd: 1,
    cad: 1.42308,
}

function convertAmount(amount, fromCurrency, toCurrency) {
    if (fromCurrency === toCurrency) {
        return amount;
    }
    return amount * conversionRates[toCurrency] / conversionRates[fromCurrency];
}

$(document).on('change', '#currencySelect', function () {
    const selectedCurrency = $(this).val(); // 'usd' or 'cad'
    console.log(selectedCurrency)
    const currencySymbol = selectedCurrency === 'usd' ? '$' : 'CA$';

    $('.offering_process').each(function () {
        const $btn = $(this);

        // Always convert from original USD price
        const usdPrice = parseFloat($btn.data('usd-price')) || 0;
        const convertedPrice = convertAmount(usdPrice, 'usd', selectedCurrency);

        $btn.attr('data-price', convertedPrice.toFixed(2));
        $btn.attr('data-currency', selectedCurrency);
        $btn.attr('data-currency-symbol', currencySymbol);

        const $priceElement = $btn.closest('.d-flex').find('.offer-prize');
        $priceElement.text(currencySymbol + convertedPrice.toFixed(2));
    });
});
