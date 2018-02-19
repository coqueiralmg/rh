function validarCPF(cpf) {
    var numeros, digitos, soma, i, resultado, digitos_iguais;
    cpf = removerMascara(cpf);
    digitos_iguais = 1;
    if (cpf.length < 11)
        return false;
    for (i = 0; i < cpf.length - 1; i++)
        if (cpf.charAt(i) != cpf.charAt(i + 1)) {
            digitos_iguais = 0;
            break;
        }
    if (!digitos_iguais) {
        numeros = cpf.substring(0, 9);
        digitos = cpf.substring(9);
        soma = 0;
        for (i = 10; i > 1; i--)
            soma += numeros.charAt(10 - i) * i;
        resultado = soma % 11 < 2 ? 0 : 11 - soma % 11;
        if (resultado != digitos.charAt(0))
            return false;
        numeros = cpf.substring(0, 10);
        soma = 0;
        for (i = 11; i > 1; i--)
            soma += numeros.charAt(11 - i) * i;
        resultado = soma % 11 < 2 ? 0 : 11 - soma % 11;
        if (resultado != digitos.charAt(1))
            return false;
        return true;
    }
    else
        return false;
}

function validarPIS(pis) {
    var ftap="3298765432";
    var total = 0;
    var resto = 0;
    var numPIS = 0;
    var strResto = "";

    numPIS = pis;

    if (numPIS == "" || numPIS == null) {
        return false;
    }

    for (var i = 0; i <= 9; i++) {
        resultado = (numPIS.slice(i, i + 1)) * (ftap.slice(i, i + 1));
        total = total + resultado;
    }

    resto = (total % 11)

    if (resto != 0) {
        resto = 11 - resto;
    }

    if (resto == 10 || resto == 11) {
        strResto = resto + "";
        resto = strResto.slice(1, 2);
    }

    if (resto != (numPIS.slice(10, 11))) {
        return false;
    }

    return true;
}

function removerMascara(texto) {
    return texto.replace(/[^0-9]+/g, '');
}

function formatarData(data) {
    var pivot = data.split("/");
    return pivot[1] + "/" + pivot[0] + "/" + pivot[2];
}