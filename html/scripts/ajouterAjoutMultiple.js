
function ajouterajoutMultiple(id) {
    const input = document.getElementById('ajoutMultipleInput_' + id);
    const list = document.getElementById('ajoutMultipleList_' + id);
    const value = input.value.trim();

    if (value !== '') {
        const li = document.createElement('li');
        li.innerHTML = `${value} 
            <input type="hidden" name="ajoutMultiple_${id}[]" value="${value}">
            <button type="button" onclick="supprimerajoutMultiple(this)">✖</button>`;
        list.appendChild(li);
        input.value = '';
    }
}

function supprimerajoutMultiple(btn) {
    btn.parentElement.remove();
}
