$('#category').on('change', function (e) {
    e.preventDefault();
    let search = $('#search').val();
    let location = $('#location').val();
    let practitionerType = $('#practitionerType').val();
    let category = $('#category').val();
    getPractitioners(search, category, location, practitionerType);
});

$(document).on('click', '.loadPractitioner', function (e) {
    e.preventDefault();

    let $rowId = $(this).data('render');
    let search = $('#search').val();
    let location = $('#location').val();
    let practitionerType = $('#practitionerType').val();
    let category = $('#category').val();
    let count = ($(this).data('count') ?? 1) + 1;
    let isPractitioner = $(this).data('is-practitioner') ?? 0;

    getPractitioners(search, category, location, practitionerType, count, $rowId ,isPractitioner);
});

function getPractitioners(search = null, category = null, location = null, practitionerType = null, count = 1, $rowId = null , isPractitioner = 0) {


    $.ajax({
        url: '/search/practitioner',
        type: 'get',
        data: {
            search,
            category,
            location,
            practitionerType,
            count,
            isPractitioner
        },
        beforeSend: function () {
            window.loadingScreen.addPageLoading();
        },
        success: function (response) {
            if (response.success && response.html) {
                // Append new HTML instead of replacing it
                $(`#${$rowId}`).html(response.html);

                // // Scroll to new content if desired
                // $('html, body').animate({
                //     scrollTop: $(`#${$rowId}`).offset().top
                // }, 500);
            }
        },
        complete: function () {
            window.loadingScreen.removeLoading();
        }
    });
}


// function performSearch() {
//     let search = $('#search').val();
//     let location = $('#location').val();
//     let practitionerType = $('#practitionerType').val();
//
//     console.log("Performing search with:", {search, location, practitionerType}); // Debugging
//
//     getPractitioners(search, null, location, practitionerType);
// }
//
// // Prevent form submission and trigger AJAX on Enter key inside the search input
// $('#search').on('keypress', function (e) {
//     if (e.which === 13) { // 13 = Enter key
//         e.preventDefault();
//         performSearch();
//     }
// });
//
// // Prevent form submission and trigger AJAX when clicking the Search button
// $('#searchFilter').on('click', function (e) {
//     e.preventDefault();
//     performSearch();
// });
//
// // Prevent form submission globally on #searchform
// $('#searchform').on('submit', function (e) {
//     e.preventDefault();
//     performSearch();
// });
//
// $(document).on('click', '.loadPractitioner', function (e) {
//     e.preventDefault();
//     let search = $('#search').val();
//     let location = $('#location').val();
//     let practitionerType = $('#practitionerType').val();
//     let category = $('#category').val();
//     let count = ($(this).data('count') ?? 1) + 1;
//
//     getPractitioners(search, category, location, practitionerType, count);
// });
