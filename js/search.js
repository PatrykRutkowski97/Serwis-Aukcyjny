function jsUcfirst(string) 
{
    return string.charAt(0).toUpperCase() + string.slice(1);
}

const input = document.getElementById('search');

input.addEventListener('input', () => {
    const all = document.querySelectorAll('td.title');
    all.forEach(el => {
        if(el.innerHTML.indexOf(jsUcfirst(input.value))) {
            el.parentElement.style.setProperty('display', 'none');
        }
        else {
            el.parentElement.style.setProperty('display', '');
        }
    })
});
