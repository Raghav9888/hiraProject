document.addEventListener('DOMContentLoaded', () => {
    const flash = document.getElementById('flash-data');
    if (!flash) return;

    const success = flash.dataset.success;
    const error = flash.dataset.error;
    const warning = flash.dataset.warning;

    if (success) {
        alertify.success(success);
    }
    if (error) {
        alertify.error(error);
    }
    if (warning) {
        alertify.warning(warning);
    }
});
