function validateForm() {
    const phone = document.getElementById('phone').value.trim();
    const age = Number(document.getElementById('age').value);

    if (!/^[0-9]{10}$/.test(phone)) {
        alert('Please enter a valid 10-digit phone number.');
        return false;
    }

    if (age < 1 || age > 120) {
        alert('Please enter a valid age.');
        return false;
    }

    return true;
}
