document.addEventListener('DOMContentLoaded', () => {
    const form = document.getElementById('form');
    const title_field = document.getElementById('title');
    const price_field = document.getElementById('price');
    const condition_field = document.getElementById('condition');
    const descpription_field = document.getElementById('desc');
    const city_field = document.getElementById('city');
    const name_field = document.getElementById('name');
    const phone_field = document.getElementById('phone');
    const highlighted_field = document.getElementById('highlighted');
    // Information span
    const title_info = document.getElementById('title_length');
    const desc_info = document.getElementById('desc_length');
    // CONST
    const title_max = 70;
    const desc_max = 1000;
    // static value
    title_info.innerHTML = title_max;
    desc_info.innerHTML = desc_max;
    

    title_field.addEventListener('input', function() {
        title_info.innerHTML = title_max - this.value.length;
    });

    descpription_field.addEventListener('input', function() {
        desc_info.innerHTML = desc_max - this.value.length;
    });

    // checking form

    form.addEventListener('submit', e => {
        // Title Field
        if(title_field.value == '') {
            title_field.classList.add('is-invalid');
            e.preventDefault();
        }
        else {
            title_field.classList.remove('is-invalid');
            title_field.classList.add('is-valid');
        }
        // Price field
        if(price_field.value == '' || isNaN(price_field.value)) {
            price_field.classList.add('is-invalid')
            e.preventDefault();
        }
        else {
            price_field.classList.remove('is-invalid');
            price_field.classList.add('is-valid');
        }
        // Condition Article Field
        if(condition_field.value == 'Wybierz...') {
            condition_field.classList.add('is-invalid')
            e.preventDefault();
        }
        else {
            condition_field.classList.remove('is-invalid');
            condition_field.classList.add('is-valid');
        }
        // Description Field
        if(descpription_field.value == '') {
            descpription_field.classList.add('is-invalid')
            e.preventDefault();
        }
        else {
            descpription_field.classList.remove('is-invalid');
            descpription_field.classList.add('is-valid');
        }
        // City field
        if(city_field.value == '') {
            city_field.classList.add('is-invalid')
            e.preventDefault();
        }
        else {
            city_field.classList.remove('is-invalid');
            city_field.classList.add('is-valid');
        }
        // Name field
        if(name_field.value == '') {
            name_field.classList.add('is-invalid')
            e.preventDefault();
        }
        else {
            name_field.classList.remove('is-invalid');
            name_field.classList.add('is-valid');
        }
        // Phone field
        if(phone_field.value == '' || phone_field.value.length > 9 || phone_field.value.length < 9) {
            phone_field.classList.add('is-invalid')
            e.preventDefault();
        }
        else {
            phone_field.classList.remove('is-invalid');
            phone_field.classList.add('is-valid');
        }
        // highlighted field
        if(highlighted_field.value == 'Wybierz...') {
            highlighted_field.classList.add('is-invalid')
            e.preventDefault();
        }
        else {
            highlighted_field.classList.remove('is-invalid');
            highlighted_field.classList.add('is-valid');
        }

        document.getElementById('add_ad').scrollIntoView();
    });

})
