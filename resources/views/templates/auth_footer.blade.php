    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <script>
// Add floating animation to auth card
document.addEventListener('DOMContentLoaded', function() {
    const authCard = document.querySelector('.auth-card');

    if (authCard) {
        authCard.style.animation = 'fadeInUp 0.8s ease-out';
    }

    // Password confirmation validation
    const password1 = document.getElementById('password1');
    const password2 = document.getElementById('password2');

    if (password1 && password2) {

        function validatePasswords() {

            if (password2.value === '') {
                password2.setCustomValidity('');
                password2.classList.remove('is-invalid', 'is-valid');
                return;
            }

            if (password1.value === password2.value) {

                password2.setCustomValidity('');
                password2.classList.remove('is-invalid');
                password2.classList.add('is-valid');

            } else {

                password2.setCustomValidity('Passwords do not match');
                password2.classList.remove('is-valid');
                password2.classList.add('is-invalid');

            }
        }

        password1.addEventListener('input', validatePasswords);
        password2.addEventListener('input', validatePasswords);
    }

});


// Add CSS animation keyframes
const style = document.createElement('style');

style.textContent = `
            @keyframes fadeInUp {
                from {
                    opacity: 0;
                    transform: translateY(30px);
                }
                to {
                    opacity: 1;
                    transform: translateY(0);
                }
            }
        `;

document.head.appendChild(style);
    </script>

    </body>

    </html>