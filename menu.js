function abrirMenu() {
    document.getElementById("menu-lateral").classList.add("aberto");
    document.getElementById("fundo-menu").classList.add("aberto");
}

function fecharMenu() {
    document.getElementById("menu-lateral").classList.remove("aberto");
    document.getElementById("fundo-menu").classList.remove("aberto");
}