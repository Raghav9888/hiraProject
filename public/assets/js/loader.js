const LoadingScreen = {
    loadingParentElement: 'body',

    addLoading: function (loadingText = "Loading...") {
        const overlay = `
            <div class="loader-container">
                <div class="loading-text">${loadingText}</div>
                <img src="your-image.jpg" alt="Loading..." class="flip-loader">
            </div>
        `;
        $(this.loadingParentElement).append(overlay);
    },

    addPageLoading: function (imageUrl = "your-image.jpg") {
        const overlay = `
            <div class="loader-container">
                <img src="${imageUrl}" alt="Loading..." class="flip-loader">
            </div>
        `;
        $(this.loadingParentElement).append(overlay);
    },

    removeLoading: function () {
        const $loading = $(this.loadingParentElement).find('.loader-container');
        $loading.fadeOut(1000, function () {
            $(this).remove(); // Removes after fade-out animation completes
        });
    }
};

window.loadingScreen = LoadingScreen;
