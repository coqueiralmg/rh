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
    var erros = Array();
    var mensagem = "";
    var i = 1;

    while(i < tabela.rows.length){
        var linha = tabela.rows[i];
        var campos = linha.getElementsByTagName("input");
        var erro = false;

        if(campos.codigo.value == "") {
            mensagem += "<li>[Linha " + i + "] É obrigatório informar o código do CID.</li>";
            erro = true;
        } 

        if(campos.nome.value == "") {
            mensagem += "<li>[Linha " + i + "] É obrigatório informar o nome da doença ou problema relacionado ao CID.</li>";
            erro = true;
        }   

        if(erro) {
            erros.push(i);
        }

        i++;
    }

    if (mensagem == "") {
        return true;
    } else {
        montarLinhasTabela(tabela, erros);
        $("#cadastro_erro").show('shake');
        $("#details").html("<ol>" + mensagem + "</ol>");
        return false;
    }
}

function montarLinhasTabela(tabela, erros){
    var i = 0;

    do {
        var linha = tabela.rows[i];
        var celula = null;

        if(linha.cells.length == 5) {
            if(i > 0) {
                celula = linha.cells[0];
                celula.innerHTML = i;

                if(erros.indexOf(i) >= 0) {
                    celula.style.color = "red";
                    celula.style.fontWeight = "bold";
                } else {
                    celula.style.color = "black";
                    celula.style.fontWeight = "normal";
                }
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

                if(erros.indexOf(i) >= 0) {
                    celula.style.color = "red";
                    celula.style.fontWeight = "bold";
                }
            }    
        }
        
        i++;
    } while(i < tabela.rows.length);
}