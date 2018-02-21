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

function validar() {
    var tabela = document.getElementById("tblCadastro");
    var mensagem = "";
    var i = 1;

    while(i < tabela.rows.length){
        var linha = tabela.rows[i];
        var campos = tabela.getElementsByTagName("input");
        
        var codigo = obterCampo(campos, "codigo");
        var nome = obterCampo(campos, "nome");

        if(codigo.value == "") {
            mensagem += "<li>[Linha " + i + "] É obrigatório informar o código do CID.</li>";
            codigo.style.color = "red";
        } else {
            codigo.style.color = "#555";
        }

        if(nome.value == "") {
            mensagem += "<li>[Linha " + i + "] É obrigatório informar o nome da doença ou problema relacionado ao CID.</li>";
            nome.style.color = "red";
        } else {
            nome.style.color = "#555";
        }   

        i++;
    }


    if (mensagem == "") {
        return true;
    } else {
        montarLinhasTabela(tabela);
        $("#cadastro_erro").show('shake');
        $("#details").html("<ol>" + mensagem + "</ol>");
        return false;
    }
}

function montarLinhasTabela(tabela){
    var i = 0;

    do{
        var linha = tabela.rows[i];
        var celula = null;

        if(linha.cells.length == 5) {
            if(i > 0) {
                celula = linha.cells[0];
                celula.innerHTML = i;
            }
        } else {
            if(i == 0) {
                var pivot = linha.cells[0];
                celula = document.createElement("th");
                celula.innerHTML = "Linha"
                celula.style.width = "7%";
    
                linha.insertBefore(celula, pivot);
            } else {
                celula = linha.insertCell(0);
                celula.innerHTML = i;
            }    
        }
        
        i++;
    }while(i < tabela.rows.length);
}

function obterCampo(campos, id){
    var i = 0;

    do {
        if(campos[i].id = id) {
            return campos[i];
        }

        i++;
    } while(i < campos.length);
}