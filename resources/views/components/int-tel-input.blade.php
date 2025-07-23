<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/intl-tel-input@25.3.1/build/css/intlTelInput.css">
<style>
    .iti {
        display:block;
    }
    .iti__search-input {
        padding:.5rem;
    }
</style>
<script src="https://cdn.jsdelivr.net/npm/intl-tel-input@25.3.1/build/js/intlTelInput.min.js"></script>
<script>
    const phoneInputs = document.querySelectorAll('.int-tel-input');
    phoneInputs.forEach(input => {
        window.intlTelInput(input, {
            initialCountry: "auto",
            geoIpLookup: callback => {
            fetch("https://ipapi.co/json")
                .then(res => res.json())
                .then(data => callback(data.country_code))
                .catch(() => callback("tr"));
            },
            loadUtils: () => import("https://cdn.jsdelivr.net/npm/intl-tel-input@25.3.1/build/js/utils.js"),
        });
    });
</script>