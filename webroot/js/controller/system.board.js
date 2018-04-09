$(function () {
    obterDadosEvolucaoAtestados();
});

function obterDadosEvolucaoAtestados(){
    var data = null;
    var xhr = new XMLHttpRequest();
    xhr.open('GET', '/atestados/evolution.json', true);

    xhr.onload = function (e) {
        if (xhr.readyState === 4) {
          if (xhr.status === 200) {
            if(xhr.response.sucesso){
                var dados = xhr.response.data;
                var meses = montarSequenciaMeses(dados);

                carregarGraficoManifestos(meses, montarSequenciaAtestados(dados), montarSequenciaINSS(dados));
            } else {
                escreverMensagemGrafico("graficoEvolucao", xhr.response.mensagem);
            }
          } else {
            escreverMensagemGrafico("graficoEvolucao", xhr.statusText);
          }
        }
    };

    xhr.responseType = "json";
    xhr.send(null);
}

function montarSequenciaMeses(data) {
    var meses = Array();

    data.forEach(function(e, i, a){
        meses.push(e["mes"]);
    });
    
    return meses.reverse();
}

function montarSequenciaAtestados(data){
    var sequencia = Array();

    data.forEach(function(e, i, a){
        sequencia.push(e['total']);
    });

    return sequencia.reverse();
}

function montarSequenciaINSS(data){
    var sequencia = Array();

    data.forEach(function(e, i, a){
        sequencia.push(e['inss']);
    });

    return sequencia.reverse();
}

function carregarGraficoManifestos(labels, dadosTotal, dadosINSS){
    var ctx = document.getElementById("graficoEvolucao").getContext('2d');
    var myChart = new Chart(ctx, {
        type: 'line',
        data: {
            labels: labels,
            datasets: [{
                label: 'Total de atestados',
                data: dadosTotal,
                borderColor: "white",
                borderWidth: 3
            },
            {
                label: 'Afastamentos por INSS',
                data: dadosINSS,
                borderColor: "red",
                borderWidth: 3
            }]
        },
        options: {
            legend: {
                labels: {
                    fontColor: "white"
                }
            },
            scales: {
                xAxes: [{
                    ticks: {
                        fontColor: "white"
                    }
                }],
                yAxes: [{
                    ticks: {
                        fontColor: "white",
                        beginAtZero:true
                    }
                }]
            }
        }
    });
}

function escreverMensagemGrafico(htmlId, message) {
    var canvas = document.getElementById(htmlId);
    var ctx = canvas.getContext("2d");
    ctx.font = "12px Roboto";
    ctx.fillText(message,10,20);
}