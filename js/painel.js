function prototype(){
    var page = "page.php";
    $.ajax({
        type: 'POST',
        dataType: 'html',
        url: page,
        data: {},
        beforeSend: function(){
            
        },
        success: function(msg){
        
        } 
    });
}

function isStudent(elem){
    $('div.isStudent').toggleClass('disappear');
    $('div.noStudent').toggleClass('disappear');
    $('div.cursoInteresse').toggleClass('disappear');
    $('div.motivoVisita').toggleClass('disappear');
    if(elem.value==='1'){
        console.log("Sim");
    }
}

function startLoadingGraphs(){
    var elem = document.getElementById("loadingDiv");
    elem.style.display="block";
    elem.style.opacity="1";
    $("body").css({"overflow":"hidden"});
    $("#loadingDiv").toggleClass("fadeInDown");
}

function startLoadingRegistro(){
    var elem = document.getElementById("loadingDiv2");
    elem.style.display="block";
    elem.style.opacity="1";
    $("body").css({"overflow":"hidden"});
    $("#loadingDiv2").toggleClass("fadeInDown");
}

function validaRadio(){
    var elem = document.getElementsByName('divulga');
    var encontrou = 0;
    for(var i=0;i<elem.length;i++){
        if(elem[i].checked==true){
           encontrou = 1;
        }
    }
    if(encontrou==0){
       Materialize.toast("Selecione 'Como ficou sabendo do Evento'",4500);
    }
}

function interesseUFV(elem){
    $('div.cursoInteresse').toggleClass('disappear');
    $('div.motivoVisita').toggleClass('disappear');
}

var trava = false;
var iCount1, iCount2, iCount, iTexto, nChar;
function MaskDown(e) {
        if(trava == false) {
                iTexto = e.value;
                iCount1 = e.value.length;
                trava = true;
        }
}

function MaskUp(e,evt,msc) {
iCount2 = e.value.length;
var key_code = evt.keyCode ? evt.keyCode : evt.charCode ? evt.charCode : evt.which ? evt.which : void 0;
if (key_code == 9) {
                iCount1 = iCount2-1;
                e.select;
                
} else {
if (iCount2 > iCount1) {
        e.value = e.value.substr(0,iCount1+1);
        if(e.value.length > msc.length) {
                e.value = e.value.substr(0,msc.length);
        }
        if(iCount1 == 0) {
                if (msc.substring(iCount1,iCount1+1) != "#") {
                        nChar=1;
                        while (msc.substring(iCount1+nChar,iCount1+nChar+1) != "#" && nChar <= msc.length) {
                                nChar++;        
                        }
                        e.value = msc.substring(0,iCount1+nChar) + e.value.substr(0,iCount1+1);
                } 
        } else {
                if (msc.substring(iCount1+1,iCount1+2) != "#") {
                        var nChar=1;
                        while (msc.substring(iCount1+nChar,iCount1+nChar+1) != "#" && nChar <= msc.length) {
                                nChar++;        
                        }
                        e.value = e.value.substr(0,iCount1+1) + msc.substring(iCount1+1,iCount1+nChar);
                }
        }
} else if (iCount2 == iCount1) {
        e.value = e.value;
} else {        
        if (msc.substr(iCount2,1) != "#") {     

                nChar = 1;
                while (msc.substr(iCount1-nChar,1) != "#" && nChar <= iCount1) {
                        nChar++;        
                }
                e.value = iTexto.substr(0,iCount2-nChar+1);
        }

}
trava = false;
}}
