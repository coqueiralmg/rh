var cidinvalido = false;

$(function () {
    $('#data_emissao').datepicker({
        language: 'pt-BR'
    });

    $('#data_afastamento').datepicker({
        language: 'pt-BR'
    });

    $('#data_retorno').datepicker({
        language: 'pt-BR'
    });

    $('#data_emissao').mask('00/00/0000');
    $('#data_afastamento').mask('00/00/0000');
    $('#data_retorno').mask('00/00/0000');
    $('#crm').mask('00000000000');

    $('#cid').blur(function (e) {
        this.value = this.value.toUpperCase();
    });

    $('#cid').change(function (e) {
        var cid = $("#cid").val();
        var motivo = $("#motivo").val();
        
        if(motivo === "" && cid.length == 3) {
            pesquisarCID(cid);
        }
    });

    $('#codigo_cid').blur(function (e) {
        this.value = this.value.toUpperCase();
    });

    $('#codigo_cid').change(function (e) {
        buscarCID();
    });

    $('#nome_cid').change(function (e) {
        buscarCID();
    });

    $("#buscar_cid").click(function () {
        antebuscaCID();
    });

    $('#data_retorno').blur(function (e) {
        calcularDiasAfastados();
    });

    $('#nome_funcionario').autocomplete({
        source: function (request, response) {
            $.ajax({
                url: '/rh/funcionarios/listar.json',
                dataType: 'json',
                data: {
                    nome: request.term
                },
                success: function (data) {
                    response(data);
                }
            });
        },
        select: function (event, ui) {
            $('#nome_funcionario').val(ui.item.nome.trim());
            $('#id_funcionario').val(ui.item.id);

            return false;
        }
    }).autocomplete("instance")._renderItem = function (ul, item) {
        return $("<li>")
            .append('<span>' + item.nome.trim() + '</span>')
            .appendTo(ul);
    };

    $('#nome_medico').autocomplete({
        source: function (request, response) {
            $.ajax({
                url: '/rh/medicos/listar',
                dataType: 'json',
                data: {
                    nome: request.term
                },
                success: function (data) {
                    response(data);
                }
            });
        },
        select: function (event, ui) {
            $('#nome_medico').val(ui.item.nome.trim());
            $('#id_medico').val(ui.item.id);

            return false;
        }
    }).autocomplete("instance")._renderItem = function (ul, item) {
        return $("<li>")
            .append('<span><b>' + item.nome.trim() + '</b><span><br/><small>' + item.especialidade + ' CRM:' + item.crm + '</small>')
            .appendTo(ul);
    };
});

function salvarMedico() {
    if (!validarPopup()) return false;

    var nome = $("#nome").val();
    var crm = $("#crm").val();
    var especialidade = $("#especialidade").val();

    $.ajax({
        url: '/rh/medicos/append',
        dataType: 'json',
        data: {
            nome: nome,
            crm: crm,
            especialidade: especialidade
        },
        success: function (data) {
            $("#cadastro_sucesso_popup").show('fade');
            $("#btnSalvaMedico").hide();
        }
    });
}

function fecharModalMedico() {
    $("#btnSalvaMedico").show();
    $("#nome").val('');
    $("#crm").val('');
    $("#especialidade").val('');
    $("#cadastro_sucesso_popup").hide();
    $("#cadastro_erro_popup").hide();
}

function validarPopup() {
    var mensagem = "";

    if ($("#nome").val() === "") {
        mensagem += "<li> É obrigatório informar o nome do médico.</li>";
        $("label[for='nome']").css("color", "red");
    } else {
        $("label[for='nome']").css("color", "#aaa");
    }

    if (mensagem == "") {
        return true;
    } else {
        $("#cadastro_erro_popup").show('shake');
        $("#cadastro_erro_popup #details").html("<ol>" + mensagem + "</ol>");
        return false;
    }
}

function validar() {
    var mensagem = "";

    if ($("#id_funcionario").val() === "") {
        mensagem += "<li> É obrigatório informar o nome do funcionário cadastrado no sistema.</li>";
        $("label[for='funcionario']").css("color", "red");
    } else {
        $("label[for='funcionario']").css("color", "#aaa");
    }

    if ($("#data_emissao").val() === "") {
        mensagem += "<li> É obrigatório informar a data de emissão do atestado.</li>";
        $("label[for='emissao']").css("color", "red");
    } else {
        $("label[for='emissao']").css("color", "#aaa");
    }

    if ($("#data_afastamento").val() === "") {
        mensagem += "<li> É obrigatório informar a data de afastamento do funcionário.</li>";
        $("label[for='afastamento']").css("color", "red");
    } else {
        $("label[for='afastamento']").css("color", "#aaa");
    }

    if ($("#data_retorno").val() === "") {
        mensagem += "<li> É obrigatório informar a data de retorno do funcionário.</li>";
        $("label[for='retorno']").css("color", "red");
    } else {
        $("label[for='retorno']").css("color", "#aaa");
    }

    if ($("#data_afastamento").val() !== "" && $("#data_retorno").val() !== "") {
        var afastamento = new Date($("#data_afastamento").val().split('/').reverse().join('/'));
        var retorno = new Date($("#data_retorno").val().split('/').reverse().join('/'));

        if (afastamento > retorno) {
            mensagem += "<li> A data de afastamento é maior do que a data de retorno.</li>";
            $("label[for='afastamento']").css("color", "red");
            $("label[for='retorno']").css("color", "red");
        } else {
            $("label[for='afastamento']").css("color", "#aaa");
            $("label[for='retorno']").css("color", "#aaa");
        }
    }

    if ($("#quantidade_dias").val() === "") {
        mensagem += "<li> É obrigatório informar a quantidade de dias de afastamento, determinado pelo atestado.</li>";
        $("label[for='quantidade-dias']").css("color", "red");
    } else {
        $("label[for='quantidade-dias']").css("color", "#aaa");
    }

    if ($("#id_medico").val() === "") {
        mensagem += "<li> É obrigatório informar o nome do médico cadastrado no sistema. Você pode adicionar o novo médico, clicando em 'Adicionar médico'</li>";
        $("label[for='medico']").css("color", "red");
    } else {
        $("label[for='medico']").css("color", "#aaa");
    }

    if ($("#cid").val() === "") {
        mensagem += "<li> É obrigatório informar o CID do atestado.</li>";
        $("label[for='cid']").css("color", "red");
    } else {
        $("label[for='cid']").css("color", "#aaa");
    }

    if ($("#motivo").val() === "") {
        mensagem += "<li> É obrigatório informar o motivo do afastamento.</li>";
        $("label[for='motivo']").css("color", "red");
    } else {
        $("label[for='motivo']").css("color", "#aaa");
    }

    if (mensagem == "") {
        if(cidinvalido){
            swal({
                title: "Salvar o atestado com CID Inválido ou Inexistente?",
                text: "Você deseja salvar o atestado no sistema, com o CID que não existe no sistema ou o mesmo é inválido? Isso não vai impedir de salvar o atestado, mas ficará salvo no banco de dados, podendo dificultar o trabalho gerencial. Verifique se você está salvando o CID corretamente.",
                icon: "warning",
                type: 'warning',
                buttons: true,
                dangerMode: true,
                showCancelButton: true,
                confirmButtonClass: 'btn btn-success',
                cancelButtonClass: 'btn btn-danger',
                confirmButtonText: 'Sim',
                cancelButtonText: 'Não'
              })
              .then((salvar) => {
                if (salvar) {
                    $("#cadastro_atestado").submit();
                } else {
                  return false;
                }
              });            
        } else{
            $("#cadastro_atestado").submit();
        }
        
    } else {
        $("#cadastro_erro").show('shake');
        $("#cadastro_erro #details").html("<ol>" + mensagem + "</ol>");
        return false;
    }
}

function calcularDiasAfastados() {
    var dataAfastamento = $('#data_afastamento').val();
    var dataRetorno = $('#data_retorno').val();

    if(dataAfastamento !== "" && dataRetorno !== "") {
        var afastamento = new Date(formatarData(dataAfastamento));
        var retorno = new Date(formatarData(dataRetorno));

        var timeDiff = retorno.getTime() - afastamento.getTime();
        var diffDays = Math.ceil(timeDiff / (1000 * 3600 * 24)); 

        $('#quantidade_dias').val(diffDays);
    }
}

function antebuscaCID() {
    var cid = $("#cid").val();

    if(cid != "" && cid.length == 3) {
        $("#codigo_cid").val(cid);
        buscarCID();
    }
}

function buscarCID() {
    var cid = $("#codigo_cid").val();
    var nome = $("#nome_cid").val();

    $.ajax({
        url: '/rh/cid/listar',
        dataType: 'json',
        data: {
            codigo: cid,
            nome: nome
        },
        beforeSend: function() {
            $(".category").empty();
            $(".category").html("Efetuando busca. Aguarde!");

            if($(".category").hasClass("text-danger")) {
                $(".category").removeClass("text-danger");
            }
        },
        success: function (data) {
            atualizarTabelaCID(data);
        },
        error: function() {
            $(".category").empty();
            $(".category").html("Ocorreu um erro ao efetuar a busca");
            $(".category").addClass("text-danger");
        }
    });
}

function pesquisarCID(cid){
    $.ajax({
        url: '/rh/cid/get',
        dataType: 'json',
        data: {
            codigo: cid
        },
        beforeSend: function() {
            $("#motivo").attr('disabled','disabled');
        },
        success: function (data) {
            $("#motivo").removeAttr('disabled');
            preencherMotivo(data);
        }
    });
}

function atualizarTabelaCID(data) {
    var tabela = $("#tabelaCID");
    var pivot = $("#tabelaCID tbody#pivot tr:first");
    var vazio = $("#tabelaCID tbody#pivot tr:last");
    var dados = $("#tabelaCID tbody#data");
    
    dados.empty();
    $(".category").empty();

    if(data.length > 0) {
        for(var i = 0; i < data.length; i++) {
            var linha = pivot.clone();
            var dado = data[i];
            var cid = (dado.subitem) ? dado.codigo + "." + dado.detalhamento : dado.codigo;
    
            linha.find("#codigo").html(cid);
            linha.find("#nome").html(dado.nome);

            linha.attr("id", dado.id);
            linha.attr("codigo", dado.codigo);
            linha.attr("nome", dado.nome);
    
            dados.append(linha);
        }

        $(".category").html(data.length + " itens encontrados");
    } else {
        dados.append(vazio);
        $(".category").html("Nenhum item encontrado.");
    }
}

function preencherMotivo(data) {
    if(data == null) {
        cidinvalido = true;
        notificarUsuario("O sistema não encontrou o CID com o código informado. Verifique se o código existe no sistema ou a doença realmente existe no cadastro oficial de CID.", "danger");
    } else {
        $("#motivo").val(data.nome);
        cidinvalido = false;
        notificarUsuario("O sistema encontrou com sucesso o CID informado, e preencheu o seu nome no campo Motivo.", "success");
    }
}

function selecionarCID(o) {
    var linha = o.parentNode.parentNode;
    var codigo = linha.getAttribute("codigo");
    var nome = linha.getAttribute("nome");

    $("#cid").val(codigo);
    $("#motivo").val(nome);
}

function notificarUsuario(mensagem, tipo) {
    $.notify({
        icon: "notifications",
        message: mensagem
    }, 
    {
        type: tipo,
        timer: 5000,
        placement: {
            from: 'bottom',
            align: 'right'
        }
    });
}