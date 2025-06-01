$(document).on('change', '[data-type="change"]', function () {
    let targetOne = $(this).data('target-one');
    let matchOne = $(this).data('match-one');

    let targetTwo = $(this).data('target-two');
    let matchTwo = $(this).data('match-two');

    let classOne = $(this).data('add-one-class') ?? 'd-flex';
    let classTwo = $(this).data('add-two-class') ?? 'd-flex';

    const isCheckbox = $(this).attr('type') === 'checkbox';
    const value = $(this).val();

    // Handle target one
    if (targetOne && matchOne) {
        if (isCheckbox) {
            if ($(this).is(':checked') && value === matchOne) {
                $(`#${targetOne}`).removeClass('d-none').addClass(classOne);
            } else if (value === matchOne) {
                $(`#${targetOne}`).addClass('d-none').removeClass(classOne);
            }
        } else {
            if (value === matchOne) {
                $(`#${targetOne}`).removeClass('d-none').addClass(classOne);
            } else {
                $(`#${targetOne}`).addClass('d-none').removeClass(classOne);
            }
        }
    }

    // Handle target two
    if (targetTwo && matchTwo) {
        if (value === matchTwo) {
            $(`#${targetTwo}`).removeClass('d-none').addClass(classTwo);
        } else {
            $(`#${targetTwo}`).addClass('d-none').removeClass(classTwo);
        }
    }
});


$(document).ready(function () {
    $('[data-type="multiselect"]').each(function () {
        let select2Element = $(this);
        let maxShow = select2Element.data('maxshow');

        let options = {
            placeholder: "Select options",
        };

        if (maxShow !== undefined && maxShow !== null && maxShow !== '') {
            options.maximumSelectionLength = maxShow;
        }

        select2Element.select2(options);

        select2Element.on('change', function () {
            $('#save-button').trigger('click');
        });
    });
});

$('.addterm').on('click', function (e) {
    e.preventDefault();
    var termType = $(this).data('type'); // Get the data-type attribute value

    $.ajax({
        url: '/term/add',
        type: 'POST',
        data: {
            type: termType,
            _token: $('meta[name="csrf-token"]').attr('content')
        },
        dataType: 'json',
        success: function (response) {
            if (response.success) {
                $('#' + termType + '-container').html(response.inputField);
            } else {
                alert('Error: ' + response.message);
            }
        },
        error: function (xhr, status, error) {
            console.error('AJAX Error:', error);
        }
    });
});

$(document).on('click', '.save_term', function (e) {
    e.preventDefault();
    var termType = $(this).data('type');
    var name = $('.' + termType + '_term').val();

    $.ajax({
        url: '/term/save',
        type: 'POST',
        data: {
            type: termType,
            name: name,
            _token: $('meta[name="csrf-token"]').attr('content')
        },
        dataType: 'json',
        success: function (response) {
            var selectElement = $("#" + termType);

            if (response.success) {
                let selectedValues = selectElement.val() || [];

                response.terms.forEach(function (term) {
                    if (selectElement.find(`option[value="${term.id}"]`).length === 0) {
                        var newOption = `<option value="${term.id}" selected>${term.name}</option>`;
                        selectElement.append(newOption);
                    }
                    selectedValues.push(term.id);
                });

                selectElement.val([...new Set(selectedValues)]).trigger('change');
                alert(response.message);

                if (response.duplicates && response.duplicates.length > 0) {
                    alert('These terms already exist: ' + response.duplicates.join(', '));
                }
            } else {
                alert(response.message);
            }

            $('#' + termType + '-container').html('');
        },
        error: function (xhr, status, error) {
            console.error('AJAX Error:', error);
            alert('An unexpected error occurred.');
        }
    });
});

$(document).ready(function () {
    $(document).on('click', '[data-type="hide"]', function () {

        let id = $(this).data('id');
        $(`#${id}`).toggleClass('d-none');
    });
});

function removeImage(element) {
    const imageUrl = $(element).data('image-url');
    const userId = $(element).data('user-id');
    const isProfileImage = $(element).data('profile-image') ?? false;
    const isMediaImage = $(element).data('media-image') ?? false;
    const isOfferImage = $(element).data('offering-image') ?? false;
    const isCertificateImages = $(element).data('certificate-image') ?? false;
    const $renderDiv = $(element).data('html-render') ?? false;
    const imageName = $(element).data('name');

    $.ajax({
        url: '/delete/image',
        type: 'POST',
        data: {
            image: imageName,
            url: imageUrl,
            isProfileImage: isProfileImage,
            isMediaImage: isOfferImage,
            isOfferImage: isOfferImage,
            isCertificateImages: isCertificateImages,
            user_id: userId,
            _token: $('meta[name="csrf-token"]').attr('content')
        },
        success: function (response) {
            console.log('Image removed successfully', response);

            if (isProfileImage || isOfferImage) {
                // Remove the existing image preview
                $('#imagePreview').remove();

                // Add the new label for image upload
                const uploadLabel = `
                    <label onclick="document.getElementById('fileInput').click();" id="imagePreview" class="image-preview rounded-5">
                        <span>+</span>
                    </label>
                `;
                if ($renderDiv) {
                    $(`#{$renderDiv}`).append(uploadLabel);
                } else {
                    $('#imageDiv').append(uploadLabel);

                }
            } else {
                $(element).parent().remove();
            }
        },
        error: function (xhr, status, error) {
            console.error('Error removing image:', error);
        }
    });
}

