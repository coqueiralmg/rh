$(function () {
    obterDadosEvolucaoAtestados();
});

function obterDadosEvolucaoAtestados(){
    carregarGraficoManifestos();
}

function carregarGraficoManifestos(dados, datas){
    var ctx = document.getElementById("graficoEvolucao").getContext('2d');
    var myChart = new Chart(ctx, {
        type: 'line',
        data: {
            labels: ['Março/2018', 'Fevereiro/2018', 'Janeiro/2018', 'Dezembro/2017', 'Novembro/2017', 'Outubro/2017', 'Setembro/2017', 'Agosto/2017', 'Julho/2017', 'Junho/2017', 'Maio/2017', 'Abril/2017', 'Março/2017'],
            datasets: [{
                label: 'Total de atestados',
                data: [32, 54, 57, 91, 12, 5, 6, 9, 61, 30, 60, 45, 80],
                borderColor: "white",
                borderWidth: 3
            },
            {
                label: 'Afastamentos por INSS',
                data: [2, 0, 0, 5, 2, 3, 1, 0, 21, 4, 3, 1, 8],
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