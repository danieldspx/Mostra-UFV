function loading(){
    var elem = document.getElementById("loadingDiv");
    elem.style.display="block";
    elem.style.opacity="1";
}
function muda_paginaNext(valor){
    var urlAtual = window.location.href;
    var nPaginaAtual = parseInt(urlAtual.substr(parseInt(urlAtual.search("p="))+2));
    var nPaginaNext;
    if(valor==1){
        nPaginaNext = nPaginaAtual + 1;
    } else {
        nPaginaNext = nPaginaAtual - 1;
    }
    urlAtual = urlAtual.replace("p="+nPaginaAtual,"p="+nPaginaNext);
    if(urlAtual.search("p=") == -1){
       urlAtual = urlAtual+"?p="+nPaginaNext;
    }
    window.location.href=urlAtual;
    loading();
}
function muda_paginaParam(gotoP){
    var urlAtual = window.location.href;
    var nPaginaAtual = parseInt(urlAtual.substr(parseInt(urlAtual.search("p="))+2));
    urlAtual = urlAtual.replace("p="+nPaginaAtual,"p="+gotoP);
    if(urlAtual.search("p=") == -1){
       urlAtual = urlAtual+"?p="+gotoP;
    }
    window.location.href=urlAtual;
    loading();
}