document.getElementById('submit_listing').addEventListener('click', function() {
    let title = document.getElementById('title').value;
    let area = document.getElementById('area').value;
    let rooms = document.getElementById('rooms').value;
    let price_per_night = document.getElementById('price_per_night').value;
    let photo = document.getElementById('photo').value;
     
    if (!/^[a-zA-Z]+$/.test(title)) {
        alert("Ο τίτλος πρέπει να περιέχει μόνο χαρακτήρες.");
        return false;
    }
    if (!/^[a-zA-Z]+$/.test(area)) {
        alert("Η περιοχή πρέπει να περιέχει μόνο χαρακτήρες.");
        return false;
    }
    if (!/^[0-9]+$/.test(rooms)) {
        alert("Το πλήθος δωματίων πρέπει να είναι ακέραιος αριθμός.");
        return false;
    }
    if (!/^[0-9]+$/.test(price_per_night)) {
        alert("Η τιμή ανά διανυκτέρευση πρέπει να είναι ακέραιος αριθμός.");
        return false;
    }
    if (photo === "") {
        alert("Πρέπει να επιλέξετε φωτογραφία.");
        return false;
    }
    return true;
});