let isMobileNavbarOpen = false;

function openMoibileNavbar(){
    isMobileNavbarOpen = !isMobileNavbarOpen;
    const mobileNavbar = document.getElementById('mobile-navbar');
    const container = document.getElementById('container');
    if(isMobileNavbarOpen){
        mobileNavbar.classList.remove('hidden');
        container.classList.add('overflow-hidden');
    } else {
        mobileNavbar.classList.add('hidden');
        container.classList.remove('overflow-hidden');
    }
}

function previewImage(input) {
    const preview = document.getElementById('imagePreview');
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        reader.onload = function(e) {
            preview.src = e.target.result;
            preview.classList.remove('hidden');
        }
        reader.readAsDataURL(input.files[0]);
    } else {
        preview.src = "#";
        preview.classList.add('hidden');
    }
}