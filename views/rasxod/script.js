$(document).ready(function() {

    let elPrixod = $("#rasxodgoods-prixod_id");
    let elPrixodGoods = $('#rasxodgoods-prixod_goods_id');
    let elCost = $('#rasxodgoods-cost');
    let elCurrency = $('#rasxodgoods-currency_id');
    let elAmount = $('#rasxodgoods-amount');

    elPrixod.change(function (e) {
        var prixod_id = elPrixod.val();
        changeGoods(prixod_id);
        elAmount.val(null);
        elCurrency.empty().append('<option value="">Выберите</option>');
        elCost.val(null);
    });

    elPrixodGoods.change(function (e) {
        var rasxod_goods_id = elPrixodGoods.val();
        changeCostCurrency(rasxod_goods_id);
    });

    function changeGoods(prixod_id) {
        $.ajax({
            url: "<?=url(['prixod-goods/select-goods-available'])?>",
            method: "POST",
            data: {prixod_id: prixod_id, _csrf: yii.getCsrfToken()},
            dataType: "json",
            beforeSend: function () {
                $('#select2-chosen').text("");
                elPrixodGoods.empty().append('<option value="">Выберите</option>');
                // clientni tanlay olmaydigan qilib turamiz
                elPrixodGoods.prop("disabled", true);
            },

            success: function (data) {
                // console.log(data);
                $.each(data, function (i) {
                    elPrixodGoods.append('<option value="' + data[i].id + '">' + data[i].name + '</option>');
                });
                elPrixodGoods.prop("disabled", false);
            },

            error: function () {
                alert('Error - Qayta takrorlang!');
            }
        });
    }

    function changeCostCurrency(rasxod_goods_id) {
        $.ajax({
            url: "<?=url(['prixod-goods/get-cost-currency'])?>",
            method: "POST",
            data: {rasxod_goods_id: rasxod_goods_id, _csrf: yii.getCsrfToken()},
            dataType: "json",

            success: function (data) {
                elCost.val(data.cost);
                elCurrency.val(data.currency_id);
                elAmount.val(data.amount);
                elCurrency.empty().append('<option value="'+data.currency_id+'">'+data.currency_name+'</option>');
            },
        });
    }

    elPrixod.trigger('change');
});