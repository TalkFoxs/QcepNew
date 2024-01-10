const botonOcult=document.getElementById("botonIdioma");

function ocultarEnseñar() {
    const listaIdioma = document.getElementById("listaIdioma");
    if(listaIdioma.classList.contains(`noneLista`)){
        listaIdioma.classList.remove("noneLista");
    }else{
        listaIdioma.classList.add("noneLista");
    }
}
botonOcult.addEventListener("click",ocultarEnseñar);