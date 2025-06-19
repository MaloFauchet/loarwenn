
console.log('ici');
document.getElementById('carteRestaurant').addEventListener('change', function (event) {
    
    const preview = document.getElementById('previewCarteRestaurant');
    preview.innerHTML = ''; 
    Array.from(event.target.files).forEach(file => {
        if (file.type.startsWith('image/')) {
            const img = document.createElement('img');
            img.src = URL.createObjectURL(file);
            preview.appendChild(img);   
        }
    });
});
