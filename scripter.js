document.addEventListener("DOMContentLoaded", function() {
    const submit_date = document.getElementById('submit_date'); 
    const completeBookingForm = document.getElementById('complete_booking');
    const submit_booking = document.getElementById('submit_booking');
    const pricePerNightElement = document.getElementById('price_per_night');

    if (submit_date && pricePerNightElement) {
        submit_date.addEventListener('click', function(e) {
            e.preventDefault();

            const startDate = document.getElementById('start_date').value;
            const endDate = document.getElementById('end_date').value;
            const pricePerNight = document.getElementById('price_per_night').textContent;
            
            if (startDate && endDate && !isNaN(pricePerNight)) {
                const start = new Date(startDate);
                const end = new Date(endDate);
                const nights = (end - start) / (1000 * 60 * 60 * 24);

                if (nights > 0) {
                    const initialAmount = pricePerNight * nights;
                    const discount = Math.random() * (30 - 10) + 10;
                    const totalAmount = initialAmount - (initialAmount * (discount / 100));

                    // Εμφάνιση των αποτελεσμάτων στον χρήστη
                    const totalAmountDisplay = document.getElementById('total_amount_display');
                    const discountDisplay = document.getElementById('discount_display');

                    if (totalAmountDisplay && discountDisplay) {
                        totalAmountDisplay.textContent = Math.floor(totalAmount);
                        discountDisplay.textContent = discount + '%';

                        // Αποθήκευση των αποτελεσμάτων σε κρυφά πεδία φόρμας
                        document.getElementById('total_amount').value = Math.floor(totalAmount);
                        document.getElementById('discount').value = discount;

                        document.querySelector('input[name="total_amount"]').value = Math.floor(totalAmount);
                        document.querySelector('input[name="discount"]').value = Math.floor(discount);

                        // Υποβολή της φόρμας
                        submit_booking.submit();


                    } else {
                        console.error("Display elements for total amount and discount not found.");
                    }

                } else {
                    alert("Η ημερομηνία λήξης πρέπει να είναι μετά την ημερομηνία έναρξης.");
                }
            } else {
                alert("Παρακαλώ εισάγετε έγκυρες ημερομηνίες και τιμή ανά διανυκτέρευση.");
            }
        });
    }

    const submit_final = document.getElementById('submit_final');
    if (submit_final) {
        submit_final.addEventListener('click', function(event) {
            event.preventDefault();
            console.log('Complete booking form submitted');
            
            // Submit the form via AJAX or any other method if needed
            // For simplicity, we're just showing the alert and redirecting
            alert('Η κράτηση σας ολοκληρώθηκε με επιτυχία!');
            window.location.href = 'feed.php';
        });
    } else {
        console.error('Complete booking form not found.');
    }
});

