document.addEventListener('DOMContentLoaded', function() {
    if (typeof stripeKey === 'undefined') {
        console.error('Stripe key is not defined.');
        return;
    }

    var stripe = Stripe(stripeKey);
    var elements = stripe.elements();

    var style = {
        base: {
            color: '#4a3c31', // Dark brown color for text
            fontFamily: '"Arial", sans-serif', // A more casual, clean font
            fontSmoothing: 'antialiased',
            fontSize: '16px',
            '::placeholder': {
                color: '#8e6e53' // Lighter brown for placeholder text
            }
        },
        invalid: {
            color: '#d9534f', // Red color for errors to ensure visibility
            iconColor: '#d9534f' // Match the color of the error icon
        }
    };
    

    // Create card element
    var card = elements.create('card', {style: style});
    card.mount('#card-element');

    card.addEventListener('change', function(event) {
        var displayError = document.getElementById('card-errors');
        if (event.error) {
            displayError.textContent = event.error.message;
        } else {
            displayError.textContent = '';
        }
    });

    // Create SEPA element
    var sepa = elements.create("sepaDebit", {style: style});
    sepa.mount("#sepa-element");

    sepa.addEventListener("change", function(event) {
        var displayError = document.getElementById("sepa-errors");
        if (event.error) {
            displayError.textContent = event.error.message;
        } else {
            displayError.textContent = "";
        }
    });

    var form = document.getElementById('payment-form');
    form.addEventListener('submit', function(event) {
        event.preventDefault();

        var selectedPaymentMethod = document.querySelector('input[name="payment-method"]:checked').value;

        if (selectedPaymentMethod === 'card') {
            stripe.createToken(card).then(function(result) {
                if (result.error) {
                    var errorElement = document.getElementById('card-errors');
                    errorElement.textContent = result.error.message;
                } else {
                    var hiddenInput = document.createElement('input');
                    hiddenInput.setAttribute('type', 'hidden');
                    hiddenInput.setAttribute('name', 'stripeToken');
                    hiddenInput.setAttribute('value', result.token.id);
                    form.appendChild(hiddenInput);

                    form.submit();
                }
            });
        } else if (selectedPaymentMethod === 'sepa') {
            stripe.createPaymentMethod({
                type: 'sepa_debit',
                sepa_debit: sepa,
                billing_details: {
                    name: 'Customer Name', // Modify as needed
                },
            }).then(function(result) {
                if (result.error) {
                    var errorElement = document.getElementById('sepa-errors');
                    errorElement.textContent = result.error.message;
                } else {
                    var hiddenInput = document.createElement('input');
                    hiddenInput.setAttribute('type', 'hidden');
                    hiddenInput.setAttribute('name', 'paymentMethodId');
                    hiddenInput.setAttribute('value', result.paymentMethod.id);
                    form.appendChild(hiddenInput);

                    form.submit();
                }
            });
        }
    });

    // Show/hide payment elements based on selected payment method
    document.querySelectorAll('input[name="payment-method"]').forEach(function(el) {
        el.addEventListener('change', function() {
            if (this.value === 'card') {
                document.getElementById('card-container').style.display = 'block';
                document.getElementById('sepa-container').style.display = 'none';
            } else if (this.value === 'sepa') {
                document.getElementById('card-container').style.display = 'none';
                document.getElementById('sepa-container').style.display = 'block';
            }
        });
    });
});
