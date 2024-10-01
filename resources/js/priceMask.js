(function () {
    $('.fi-ac-btn-action').on("click", function () {
        console.log("ativando");
    })

    $('.money').on("click", function () {
        $('.money').mask('#.##0,00', {
            reverse: true,
            onKeyPress: function(valor) {
              valor = valor.replaceAll('.', '').replaceAll(',', '.');
              $(this).data('value', valor);
            },
            onChange: function(value, e) {
              e.target.value = value.replace(/(?!^)-/g, '').replace(/^(-[,.])/, '-').replace(/(\d+\.*)\.(\d{2})$/, "$1,$2");
            }
        })

        console.log($(".money").val());
    });
})();


