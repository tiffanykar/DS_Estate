document.getElementById('submit_listing').addEventListener('click', function(e) {
    let title = document.getElementById('title').value;
    let area = document.getElementById('area').value;
    let rooms = document.getElementById('rooms').value;
    let price_per_night = document.getElementById('price_per_night').value;
    let photo = document.getElementById('photo').value;
    
    if (!/^[a-zA-Z]+$/.test(title)) {
        e.preventDefault();
        alert("Ο τίτλος πρέπει να περιέχει μόνο χαρακτήρες.");
        return false;
    }
    if (!/^[a-zA-Z]+$/.test(area)) {
        e.preventDefault();
        alert("Η περιοχή πρέπει να περιέχει μόνο χαρακτήρες.");
        return false;
    }
    if (!/^[0-9]+$/.test(rooms)) {
        e.preventDefault();
        alert("Το πλήθος δωματίων πρέπει να είναι ακέραιος αριθμός.");
        return false;
    }
    if (!/^[0-9]+$/.test(price_per_night)) {
        e.preventDefault();
        alert("Η τιμή ανά διανυκτέρευση πρέπει να είναι ακέραιος αριθμός.");
        return false;
    }
    if (photo === "") {
        e.preventDefault();
        alert("Πρέπει να επιλέξετε φωτογραφία.");
        return false;
    }
    return true;
});