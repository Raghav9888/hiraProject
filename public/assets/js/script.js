console.log('script.js')

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
        beforeSend: function () {
            window.loadingScreen.addPageLoading();
        },
        success: function (response) {
            if (response.success) {
                $('#' + termType + '-container').html(response.inputField);
            } else {
                alert('Error: ' + response.message);
            }
        },
        error: function (xhr, status, error) {
            console.error('AJAX Error:', error);
        },
        complete: function () {
            window.loadingScreen.removeLoading();
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
        beforeSend: function () {
            window.loadingScreen.addPageLoading();
        },
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
        },
        complete: function () {
            window.loadingScreen.removeLoading();
        }
    });
});

// if (document.getElementById('bio')) {
//     document.getElementById('bio').addEventListener('input', function () {
//         let words = this.value.match(/\b\w+\b/g) || [];
//         let wordCount = words.length;
//         let maxWords = 1000;
//
//         document.getElementById('word-count').textContent = wordCount + ' / ' + maxWords + ' words';
//
//         if (wordCount > maxWords) {
//             alert('You can only enter up to 500 words.');
//             this.value = words.slice(0, maxWords).join(' '); // Trim excess words
//             document.getElementById('word-count').textContent = maxWords + ' / ' + maxWords + ' words';
//         }
//     });
// }

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
        beforeSend: function () {
            window.loadingScreen.addPageLoading();
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
        },
        complete: function () {
            window.loadingScreen.removeLoading();
        }
    });
}

// Event listener for availability type change
$(document).on('change', '#availability_type', function () {
    let targetElement = $('#custom_hours');
    targetElement.toggleClass('d-none d-flex', $(this).val() !== 'custom');
});


$(document).on('click', '#sidebar_toogle', function () {
    let targetElement = $('#sidebar');
    targetElement.toggleClass('d-none d-flex', $(this).val() !== 'custom');
})


$(document).ready(function () {
    const CURRENT_VERSION = '1.0';
    const LOCAL_KEY = 'app_version';
    console.log('version check')
    const savedVersion = localStorage.getItem(LOCAL_KEY);

    if (savedVersion !== CURRENT_VERSION) {
        localStorage.setItem(LOCAL_KEY, CURRENT_VERSION);
        location.replace(window.location.href); // works better on mobile
    }
})

$(document).on('change', '#fileUpload', function () {
    const previewContainer = $('#filePreview');
    previewContainer.html(''); // clear previous previews

    const files = this.files;
    if (files.length > 2) {
        alert('You can only upload up to 2 files.');
        $(this).val('');
        return;
    }

    Array.from(files).forEach(file => {
        const fileType = file.type;

        if (fileType.startsWith('image/')) {
            const reader = new FileReader();
            reader.onload = function (e) {
                const img = $('<img>', {
                    src: e.target.result,
                    class: 'img-thumbnail',
                    style: 'max-width: 150px; max-height: 150px;'
                });
                previewContainer.append(img);
            };
            reader.readAsDataURL(file);

        } else if (fileType.startsWith('video/')) {
            const reader = new FileReader();
            reader.onload = function (e) {
                const video = $('<video>', {
                    src: e.target.result,
                    controls: true,
                    class: 'rounded',
                    style: 'max-width: 200px; max-height: 150px;'
                });
                previewContainer.append(video);
            };
            reader.readAsDataURL(file);

        } else {
            const text = $('<p>').text(`Selected file: ${file.name}`);
            previewContainer.append(text);
        }
    });
});


$('#waitlist-form').submit(function (e) {
    e.preventDefault();

    const formData = new FormData(this);
    const password = $('#password').val();
    const passwordConfirmation = $('#password_confirmation').val();

    if (password.length < 8) {
        alert('Password must be at least 8 characters.');
        return;
    }

    if (password !== passwordConfirmation) {
        alert('Passwords do not match.');
        return;
    }

    formData.set('password', password);
    formData.set('password_confirmation', passwordConfirmation);

    var form = $(this); // save form reference

    $.ajax({
        url: '/waitList',
        method: 'POST',
        data: formData,
        processData: false,
        contentType: false,
        beforeSend: function () {
            window.loadingScreen.addPageLoading();
        },
        success: function () {
            alert('Registration and waitlist added successfully!');

            // Change modal size
            $('#registerModal .modal-dialog')
                .removeClass('modal-xl')
                .addClass('modal-lg');

            // Hide the waitlist form
            $('#waitList').addClass('d-none');

            // Update the alert header
            $('.alert-green h2').html('Thank you for sharing your practice and heart with us.');

            // Show the success message
            $('#msg').removeClass('d-none').html(`
        You’ve been added to our waitlist, and we’ll be in touch as soon as space opens or a practitioner spot becomes available.<br><br>
        In the meantime, you’ll receive updates and moments of care from The Hira Collective.<br><br>
        With love and gratitude,<br>
        <strong>The Hira Collective Team</strong>
    `);
            $('.modal-footer').addClass('d-none');

            // (Optional) If you want to close modal after some time or redirect, you can uncomment below:
            setTimeout(function () {
                window.location.href = '/';
            }, 10000);
        },


        error: function (xhr) {
            if (xhr.responseJSON && xhr.responseJSON.errors) {
                const errors = xhr.responseJSON.errors;

                if (errors.email && errors.email.includes('The email has already been taken.')) {
                    alert('The email you entered is already registered. Please use a different one.');
                    return;
                }

                const messages = Object.values(errors).flat().join('\n');
                alert(messages);
            } else {
                alert('An error occurred while submitting the waitlist.');
            }
            console.error(xhr);
        },
        complete: function () {
            window.loadingScreen.removeLoading();
        }
    });

});


$(document).ready(function() {
    $("#subscribe").submit(function(e) {
        e.preventDefault(); // Prevent default form submission

        let formData = $(this).serialize();

        $.ajax({
            url: $(this).attr('action'),
            type: "POST",
            data: formData,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            beforeSend: function () {
                window.loadingScreen.addPageLoading();
            },
            success: function(response) {
                if (response.success) {
                    $("#subscribe-message").html(`<div class="text-success">${response.data}</div>`);
                    $("#subscribe")[0].reset();
                } else {
                    $("#subscribe-message").html(`<div class="text-danger">Something went wrong.</div>`);
                }
            },
            error: function(xhr) {
                const errorMsg = xhr.responseJSON?.data || "Something went wrong. Please try again.";
                $("#subscribe-message").html(`<div class="text-danger">${errorMsg}</div>`);
            },
            complete: function () {
                window.loadingScreen.removeLoading();
            }
        });
    });
});


// Force blur/focus to "wake up" fields after autofill on iOS
document.addEventListener('DOMContentLoaded', function () {
    const waitlistModal = document.getElementById('registerModal');
    waitlistModal.addEventListener('shown.bs.modal', () => {
        const inputs = waitlistModal.querySelectorAll('input, textarea, select');
        setTimeout(() => {
            inputs.forEach((el) => {
                el.style.display = 'none';
                el.offsetHeight; // trigger reflow
                el.style.display = '';
            });
        }, 100);
    });
});




