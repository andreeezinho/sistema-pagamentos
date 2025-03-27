function readImage(){
    if (this.files && this.files[0]) {
        var file = new FileReader();
        file.onload = function(e) {
            document.getElementById("preview").src = e.target.result;
        };       
        file.readAsDataURL(this.files[0]);
    }
}

if(document.getElementById("icone")){
    document.getElementById("icone").addEventListener("change", readImage, false);
}

if(document.getElementById("imagem")){
    document.getElementById("imagem").addEventListener("change", readImage, false);
}