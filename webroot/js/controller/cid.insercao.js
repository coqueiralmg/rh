function uppercaseCID(o) {
    o.value = o.value.toUpperCase();
}

function finalizarLinha(o, e){
    var charCode = e.which || e.keyCode;

    if(!e.shiftKey && charCode == 9) {
        var tabela = document.getElementById("tblCadastro");
        var pivot = tabela.rows[tabela.rows.length - 1];

        if(o.parentElement.parentElement.parentElement == pivot) {
            adicionarLinha(o.parentElement);
        }
    }
}

function adicionarLinha(o) {
    var tabela = document.getElementById("tblCadastro");
    var linha = o.parentElement.parentElement;
    var clone = linha.cloneNode(true);
    var campos = clone.getElementsByTagName("input");
    var i = 0;

    while (i < campos.length) {
        campos[i].value = "";
        i++;
    }

    linha.parentNode.insertBefore(clone, linha.nextSibling);

    if(tabela.tBodies[0].getElementsByTagName('tr').length > 1)
    {
        var botoes = tabela.getElementsByClassName("btn-danger");
        var j = 0;

        while(j < botoes.length) {
            botoes[j].removeAttribute("disabled");
            j++;
        }
    }
}

function removerLinha(o) {
    var tabela = document.getElementById("tblCadastro");
    var linha = o.parentNode.parentNode;

    tabela.deleteRow(linha.rowIndex);

    if(tabela.tBodies[0].getElementsByTagName('tr').length == 1)
    {
        var botoes = tabela.getElementsByClassName("btn-danger");
        var j = 0;

        while(j < botoes.length) {
            botoes[j].setAttribute("disabled", true);
            j++;
        }
    }
}