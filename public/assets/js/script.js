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

$(document).on('change', '[data-type="change"]', function (e) {
    let targetOneValue = $(this).data('target-one');
    let matchOneValue = $(this).data('match-one');

    let targetTwoValue = $(this).data('target-two');
    let matchTwoValue = $(this).data('match-two');

    let addOneClassValue = $(this).data('add-one-class') ?? 'd-flex';
    let addTowClassValue = $(this).data('add-one-class') ?? 'd-flex';

    if ((targetOneValue && targetOneValue.length > 0) && (matchOneValue && matchOneValue.length > 0)) {
        $(this).val() == matchOneValue ? $(`#${targetOneValue}`).removeClass('d-none').addClass(addOneClassValue) : $(`#${targetOneValue}`).addClass('d-none').removeClass('d-flex')
    }

    if ((targetTwoValue && targetTwoValue.length > 0) && (matchTwoValue && matchTwoValue.length > 0)) {
        $(this).val() == matchTwoValue ? $(`#${targetTwoValue}`).removeClass('d-none').addClass(addTowClassValue) : $(`#${targetTwoValue}`).addClass('d-none').removeClass('d-flex')
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
        let maxWords = 1000;

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

// Event listener for availability type change
$(document).on('change', '#availability_type', function () {
    let targetElement = $('#custom_hours');
    targetElement.toggleClass('d-none d-flex', $(this).val() !== 'custom');
});


$(document).on('click','#sidebar_toogle', function () {
    let targetElement = $('#sidebar');
    targetElement.toggleClass('d-none d-flex', $(this).val() !== 'custom');
})



$(document).ready(function()
{
    const CURRENT_VERSION = '1.0';
    const LOCAL_KEY = 'app_version';
console.log('version check')
    const savedVersion = localStorage.getItem(LOCAL_KEY);

    if (savedVersion !== CURRENT_VERSION) {
        localStorage.setItem(LOCAL_KEY, CURRENT_VERSION);
        location.replace(window.location.href); // works better on mobile
    }
})


