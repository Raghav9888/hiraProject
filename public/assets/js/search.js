$(document).ready(function () {
    // Handle form submit (Enter key OR button click)
    $('#searchForm').on('submit', function (e) {
        e.preventDefault();
        performSearch();
    });

    $('#category').on('change', function () {
        performSearch()
    })
});


// Perform search with AJAX
function performSearch() {
    let search = $('#search').val();
    let searchType = $('#practitionerType').val();
    let location = $('#location').val();
    let category = $('#category').val();
    let $rowId = 'practitionerRowDiv';
    let page = 1;
    window.history.pushState(null, null, '?search=' + search + '&searchType=' + searchType + '&location=' + location
        + '&category=' + category + '&page=' + page + '&isPractitioner=true');
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
        },
        error: function (xhr, status, error) {
            console.error('AJAX request failed:', status, error);
        }, complete: function () {
            window.loadingScreen.removeLoading();
        }
    });

}

