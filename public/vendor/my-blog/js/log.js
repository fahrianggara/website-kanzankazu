$(document).ready(function () {
    // Tooltip
    $(".btn-tooltip-hide").tooltip().on("click", function() {
        $(this).tooltip("hide")
    })

    // Darkmode
    const themeToggle = document.getElementById('theme-toggle')
    const darkTheme = 'dark-theme'
    const ligthTheme = 'uil-sun'

    const selectedTheme = localStorage.getItem('selected-theme')
    const selectedIcon = localStorage.getItem('selected-icon')

    const getCurrentTheme = () => document.body.classList.contains(darkTheme) ? 'dark' : 'light'
    const getCurrentIcon = () => themeToggle.classList.contains(ligthTheme) ? 'uil-moon' : 'uil_sun'

    if (selectedTheme) {
        document.body.classList[selectedTheme === 'dark' ? 'add' : 'remove'](darkTheme)
        themeToggle.classList[selectedIcon === 'uil-moon' ? 'add' : 'remove'](ligthTheme)
    }

    themeToggle.addEventListener('click', () => {
        document.body.classList.toggle(darkTheme)
        themeToggle.classList.toggle(ligthTheme)

        localStorage.setItem('selected-theme', getCurrentTheme())
        localStorage.setItem('selected-icon', getCurrentIcon())
    });

    // Active label to the top
    $(".form-input .form_control").blur(function() {
        if ($(this).val() != "") {
            $(this).siblings("label").addClass("active");
        } else {
            $(this).siblings("label").removeClass("active");
        }
    });

    // type password to type text
    const togglePassword = document.querySelector('#togglePassword');
    const password = document.querySelector('#password');

    togglePassword.addEventListener('click', function(e) {
        const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
        password.setAttribute('type', type);

        this.classList.toggle("bi-eye");
    });
});