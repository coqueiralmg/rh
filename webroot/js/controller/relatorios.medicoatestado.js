$(function () {
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

    $('#nome_funcionario').blur(function(){
        if(this.value == ""){
            $('#id_funcionario').val("");
        }
    });
});