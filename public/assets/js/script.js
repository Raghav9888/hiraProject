console.log('script.js')


$(document).on('click', '[data-action="bootbox"]', function (e) {
    e.preventDefault();
    let url = $(this).attr('href');

    $.ajax({
        type: 'GET',
        url: url,
        success: function (response) {
            bootbox.dialog({
                title: "Modal Title",
                message: response,
                size: 'large',
                buttons: {
                    ok: {
                        label: 'OK',
                        className: 'btn-success',
                        callback: function () {
                            console.log('OK button clicked');
                        }
                    },
                    cancel: {
                        label: 'Cancel',
                        className: 'btn-danger',
                        callback: function () {
                            console.log('Cancel button clicked');
                        }
                    }
                }
            });
        },
        error: function () {
            bootbox.alert('An error occurred during the request.');
        }
    });
});


/*========== Use for bootbox form submit start ===========*/
$(document).on('click', '[data-action="bootbox_form"]', function (event) {

    event.preventDefault();

    const $panelButton = $(this.submitTarget);
    const url = $panelButton.attr('href');
    const title = $panelButton.data('title');
    const submit = $panelButton.data('submit');
    const size = $panelButton.data('size');
    const tableId = $panelButton.data('table');

    $.ajax({
        type: 'GET',
        url: url,
        beforeSend: function () {
            // window.loadingScreen.addPageLoading();
        },
        success: function (response) {
            bootbox.dialog({
                title: title,
                size: size || 'extra-large',
                centerVertical: true,
                message: response,
                buttons: {
                    cancel: {
                        label: 'Close',
                        className: 'btn-primary',
                    },
                    submit: {
                        label: submit || 'Submit',
                        className: 'btn-success',
                        callback: function () {
                            const $form = $(this).find('form');

                            $form.find('[required]').on('input', function () {
                                if ($(this).val()) {
                                    if ($(this).attr('type') === 'email' && !isValidEmail($(this).val())) {
                                        $(this).removeClass('is-valid').addClass('is-invalid');
                                    } else {
                                        $(this).removeClass('is-invalid').addClass('is-valid');
                                    }
                                } else {
                                    $(this).removeClass('is-valid').addClass('is-invalid');
                                }
                            });

                            function isValidEmail(email) {
                                const emailPattern = /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/;
                                return emailPattern.test(email);
                            }

                            let hasEmptyFields = false;
                            $form.find('[required]').each(function () {
                                if (!$(this).val()) {
                                    hasEmptyFields = true;
                                    $(this).addClass('is-invalid');
                                } else {
                                    $(this).addClass('is-valid');
                                }
                            });

                            if (hasEmptyFields) {
                                alertify.warning('Please fill all required fields');
                                return false;
                            }


                            const formData = new FormData($form[0]);
                            $.ajax({
                                type: 'POST',
                                processData: false,
                                contentType: false,
                                cache: false,
                                url: url,
                                data: formData,
                                enctype: 'multipart/form-data',
                                beforeSend: function () {
                                    // window.loadingScreen.addPageLoading();
                                },
                                success: function (response) {
                                    window.location.reload();
                                },
                                error: function (xhr, error, status) {
                                    alertify.error(xhr.responseJSON.message);
                                },
                                complete: function () {
                                    // window.loadingScreen.removeLoading();
                                }
                            });
                        },
                    },
                },
            });
        },
        complete: function () {
            // window.loadingScreen.removeLoading();
        }
    });
});


/*========== Use for bootbox form submit end ===========*/


$(document).ready(function () {
    if ($('.location-select2').length > 0) {
        $('.location-select2').select2({
            placeholder: "Select options", // Placeholder text
            allowClear: true // Enables clear button
        });
    }

    if ($('.category-select2').length > 0) {
        $('.category-select2').select2({
            placeholder: "Select options", // Placeholder text
            allowClear: true, // Enables clear button
            maximumSelectionLength: 3
        });
    }
})
$(document).on('change', '#type', function () {
    let targetElement = $('#location');
    $(elm).val() !== 'in-person' ? targetElement.addClass('d-none') : targetElement.removeClass('d-none');
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
    var termType = $(this).data('type'); // Get the data-type attribute value
    var name = $('.' + termType + '_term').val();
    $.ajax({
        url: '/term/save', // Change this to your server-side script
        type: 'POST',
        data: {
            type: termType,
            name: name,
            _token: $('meta[name="csrf-token"]').attr('content')
        },
        dataType: 'json',
        success: function (response) {
            if (response.success) {
                var selectElement = $("#" + termType);

                // Append the new option
                var newOption = `<option value="${response.term.id}" selected>${response.term.name}</option>`;
                selectElement.append(newOption);

                // Get previously selected values and add the new one
                var selectedValues = selectElement.val() || [];
                selectedValues.push(response.term.id);

                // Reapply selected values
                selectElement.val(selectedValues).trigger('change');
                alert('Term added successfully');
            } else {
                alert('Error: ' + response.message);
            }
            $('#' + termType + '-container').html('');
        },
        /*  success: function (response) {
             if (response.success) {
                 $('#' + termType + '-container').html('');
                 var newOption = `<option value="${response.term.id}" selected>${response.term.name}</option>`;
                 $("#" + termType).append(newOption).trigger('change');
                 alert('term add sucessfully');

             } else {
                 alert('Error: ' + response.message);
             }
         }, */
        error: function (xhr, status, error) {
            console.error('AJAX Error:', error);
        }
    });
});
if (document.getElementById('bio')) {
    document.getElementById('bio').addEventListener('input', function () {
        let words = this.value.match(/\b\w+\b/g) || [];
        let wordCount = words.length;
        let maxWords = 500;

        document.getElementById('word-count').textContent = wordCount + ' / ' + maxWords + ' words';

        if (wordCount > maxWords) {
            alert('You can only enter up to 500 words.');
            this.value = words.slice(0, maxWords).join(' '); // Trim excess words
            document.getElementById('word-count').textContent = maxWords + ' / ' + maxWords + ' words';
        }
    });
}

document.addEventListener("DOMContentLoaded", function () {
    const checkboxes = document.querySelectorAll(".amentities-checkbox");

    checkboxes.forEach((checkbox) => {
        checkbox.addEventListener("change", function () {
            const checkedCount = document.querySelectorAll(".amentities-checkbox:checked").length;
            if (checkedCount > 3) {
                this.checked = false; // Prevent selecting more than 3
                alert("You can select up to 3 amenities only.");
            }
        });
    });
});

/*** media upload */
if (document.getElementById('media-upload')) {
    document.getElementById('media-upload').addEventListener('change', function (event) {
        const container = document.getElementById('media-container');
        const files = event.target.files;
        if (this.files.length > 7) {
            alert('You can only upload up to 7 images.');
            this.value = ''; // Clear the selected files
        }
        for (let file of files) {
            const reader = new FileReader();

            reader.onload = function (e) {
                const div = document.createElement('div');
                div.classList.add('media-item');

                const img = document.createElement('img');
                img.src = e.target.result;
                img.style.width = "100px";
                img.style.height = "100px";
                img.style.objectFit = "cover";
                img.style.display = "block";

                const removeBtn = document.createElement('i');
                removeBtn.classList.add('fas', 'fa-times');
                removeBtn.style.cursor = "pointer";

                removeBtn.addEventListener('click', function () {
                    div.remove();
                });

                div.appendChild(img);
                div.appendChild(removeBtn);
                container.appendChild(div);
            };

            reader.readAsDataURL(file);
        }
    });
}

function removeImage(element) {
    const imageName = $(element).data('image');
    const userId = $(element).data('user-id');
    const profileImage = $(element).data('profile-image');

    $.ajax({
        url: '/delete/image',
        type: 'POST',
        data: {
            image: imageName,
            user_id: userId,
            _token: $('meta[name="csrf-token"]').attr('content') // Fetch CSRF token dynamically
        },
        success: function (response) {
            console.log('Image removed successfully', response);

            if (profileImage) {
                // Remove the existing image preview
                $('#imagePreview').remove();

                // Add the new label for image upload
                const uploadLabel = `
                    <label onclick="document.getElementById('fileInput').click();" class="image-preview" id="imagePreview" style="border-radius: 50%;">
                        <span>+</span>
                    </label>
                `;

                $('#imageDiv').append(uploadLabel);
            } else {
                $(element).parent().remove();
            }
        },
        error: function (xhr, status, error) {
            console.error('Error removing image:', error);
        }
    });
}

// Event listener for availability type change
$(document).on('change', '#availability_type', function () {
    let targetElement = $('#custom_hours');
    targetElement.toggleClass('d-none d-flex', $(this).val() !== 'custom');
});


