function clearForm(){
    document.getElementById("myform").reset();
}

function clearTable(){
    var table = document.getElementById("searchResults");
    var rows = table.rows.length;
    for (var i=rows-1; i>0; i--){
        table.deleteRow(i);
    }
}

function validateForm(){
    var alert_messages= ["Συμπληρώστε όλα τα πεδία!", "Συμπληρώστε το όνομα μόνο με ελληνικούς χαρακτήρες!", "Συμπληρώστε την διεύθυνση μόνο με ελληνικούς χαρακτήρες!", "Συμπληρώστε έγκυρο email!", "Συμπληρώστε έγκυρο ταχυδρομικό κώδικα!", "Συμπληρώστε έγκυρο τηλέφωνο (+30210xxxxxxx)!", "Συμπληρώστε έγκυρο αριθμό κάρτας!"]
    var validate_form = [true, true, true, true, true, true, true]
    var form = document.getElementById("myform");
    if(form.name.value==="" || form.street.value ==="" || form.email.value==="" || form.tk.value ==="" || form.phone.value===""|| form.card.value===""){
        validate_form[0] = false;
    }
    if(!/^[\u0370-\u03ff\u1f00-\u1fff\s]+$/.test(form.name.value)){
        validate_form[1] = false;
    }
    if(!/^[\u0370-\u03ff\u1f00-\u1fff\s\d]+$/.test(form.street.value)){
        validate_form[2] = false;
    }
    if(!/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/.test(form.email.value)){
        validate_form[3] = false;
    }
    if(!/^\b\d{5}\b/.test(form.tk.value)){
        validate_form[4] = false;
    }
    if(!/^[+]{1}[3]{1}[0]{1}[2]{1}[1]{1}[0]{1}\d{7}$/.test(form.phone.value)){
        validate_form[5] = false;
    }
    if(!/^\b\d{16}\b/.test(form.card.value)){
        validate_form[6] = false;
    }
    if (validate_form.includes(false)){
        var alert_message = "";
        for (var i=0; i<validate_form.length; i++){
            if(validate_form[i]===false){
                alert_message += alert_messages[i] + "\n";
            }
        }
        alert(alert_message);
        return false;
    }
    else{
        var form_print = document.getElementById("myform-print");
        // Save placeholder
        form_print.name1.placeholder = form.name.value;
        form_print.street1.placeholder = form.street.value;
        form_print.email1.placeholder = form.email.value;
        form_print.tk1.placeholder = form.tk.value;
        form_print.phone1.placeholder = form.phone.value;
        newwin = window.open()
        newwin.document.write(form_print.outerHTML);
        newwin.print();
        newwin.close();
        return true;
    }
}

function validateFormForDb(){
    var alert_messages= ["Συμπληρώστε όλα τα πεδία!", "Συμπληρώστε το όνομα μόνο με ελληνικούς χαρακτήρες!", "Συμπληρώστε την διεύθυνση μόνο με ελληνικούς χαρακτήρες!", "Συμπληρώστε έγκυρο email!", "Συμπληρώστε έγκυρο ταχυδρομικό κώδικα!", "Συμπληρώστε έγκυρο τηλέφωνο (+30210xxxxxxx)!", "Συμπληρώστε έγκυρο αριθμό κάρτας!"]
    var validate_form = [true, true, true, true, true, true, true]
    var form = document.getElementById("myform");
    if(form.name.value==="" || form.street.value ==="" || form.email.value==="" || form.tk.value ==="" || form.phone.value===""|| form.card.value===""){
        validate_form[0] = false;
    }
    if(!/^[\u0370-\u03ff\u1f00-\u1fff\s]+$/.test(form.name.value)){
        validate_form[1] = false;
    }
    if(!/^[\u0370-\u03ff\u1f00-\u1fff\s\d]+$/.test(form.street.value)){
        validate_form[2] = false;
    }
    if(!/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/.test(form.email.value)){
        validate_form[3] = false;
    }
    if(!/^\b\d{5}\b/.test(form.tk.value)){
        validate_form[4] = false;
    }
    if(!/^[+]{1}[3]{1}[0]{1}[2]{1}[1]{1}[0]{1}\d{7}$/.test(form.phone.value)){
        validate_form[5] = false;
    }
    if(!/^\b\d{16}\b/.test(form.card.value)){
        validate_form[6] = false;
    }
    if (validate_form.includes(false)){
        var alert_message = "";
        for (var i=0; i<validate_form.length; i++){
            if(validate_form[i]===false){
                alert_message += alert_messages[i] + "\n";
            }
        }
        alert(alert_message);
        return false;
    }
    else{
        return true;
    }
}

function search(event) {
    event.preventDefault(); // Prevent form submission

    var searchQuery = document.querySelector('#searchForm input[name="searchQuery"]').value;

    var xhr = new XMLHttpRequest();
    xhr.onreadystatechange = function() {
        if (xhr.readyState === XMLHttpRequest.DONE) {
            if (xhr.status === 200) {
                document.querySelector('#searchResults').innerHTML = xhr.responseText;
            } else {
                alert('An error occurred while processing your request.');
            }
        }
    };
    xhr.open('GET', 'contact.php?searchQuery=' + encodeURIComponent(searchQuery), true);
    xhr.send();
}