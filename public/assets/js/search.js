$(document).ready(function () {
    $('#searchForm').on('submit', function (e) {
        e.preventDefault();
        performSearch(true);
    });

    $('#category').on('change', function () {
        performSearch(true)
    });

    // Use delegation here
    $(document).on('click', '.loadMore', function (e) {
        e.preventDefault();

        let page = $(this).data('page');
        let isPractitioner = $(this).data('is-practitioner');
        let currentUrl = window.location.href;

        let newUrl = currentUrl;

        // Update or add `page` param
        if (newUrl.includes('page=')) {
            newUrl = newUrl.replace(/([?&])page=\d*/, `$1page=${page}`);
        } else {
            const separator = newUrl.includes('?') ? '&' : '?';
            newUrl += `${separator}page=${page}`;
        }

        // Update or add `isPractitioner` param
        if (newUrl.includes('isPractitioner=')) {
            newUrl = newUrl.replace(/([?&])isPractitioner=\w*/, `$1isPractitioner=${isPractitioner}`);
        } else {
            const separator = newUrl.includes('?') ? '&' : '?';
            newUrl += `${separator}isPractitioner=${isPractitioner}`;
        }

        window.history.pushState(null, null, newUrl);

        $.ajax({
            type: 'GET',
            url: newUrl,
            beforeSend: function () {
                window.loadingScreen.addPageLoading();
            },
            success: function (response) {
                if (response.success && response.html) {
                    $('#practitionerRowDiv').html(response.html);
                }
            },
            error: function (xhr, status, error) {
                console.error('AJAX request failed:', status, error);
            },
            complete: function () {
                window.loadingScreen.removeLoading();
            }
        });
    });
});


// Perform search with AJAX
function performSearch(isPractitioner = false, page = 1) {
    let search = $('#search').val();
    let searchType = $('#practitionerType').val();
    let location = $('#location').val();
    let category = $('#category').val();
    let $rowId = 'practitionerRowDiv';
    window.history.pushState(null, null, '?search=' + search + '&searchType=' + searchType + '&location=' + location
        + '&category=' + category + '&page=' + page + '&isPractitioner=' + isPractitioner);
    let url = window.location.href;
    $.ajax({
        type: 'GET',
        url: url,
        beforeSend: function () {
            window.loadingScreen.addPageLoading();
        },
        success: function (response) {
            if (response.success && response.html) {
                $(`#${$rowId}`).html(response.html);
            }
            $('html, body').animate({scrollTop: $(`#${$rowId}`).offset().top}, 500);
        },
        error: function (xhr, status, error) {
            console.error('AJAX request failed:', status, error);
        }, complete: function () {
            window.loadingScreen.removeLoading();
        }
    });

}

