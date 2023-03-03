$(document).ready(function() {

    let elRasxod = $("#prixodgoods-rasxod_id");
    let elRasxodGoods = $('#prixodgoods-rasxod_goods_id');
    let elCost = $('#prixodgoods-cost');
    let elCurrency = $('#prixodgoods-currency_id');

    elCost.prop("disabled", true);
    elCurrency.prop("disabled", true);


    elRasxod.change(function (e) {
        var rasxod_id = elRasxod.val();
        changeGoods(rasxod_id);
    });

    elRasxodGoods.change(function (e) {
        var rasxod_goods_id = elRasxodGoods.val();
        changeCostCurrency(rasxod_goods_id);
    });

    function changeGoods(rasxod_id) {
        $.ajax({
            url: "<?=url(['rasxod-goods/select-goods-available'])?>",
            method: "POST",
            data: {rasxod_id: rasxod_id, _csrf: yii.getCsrfToken()},
            dataType: "json",
            beforeSend: function () {
                $('#select2-chosen').text("");
                elRasxodGoods.empty().append('<option value="">Выберите</option>');
                // clientni tanlay olmaydigan qilib turamiz
                elRasxodGoods.prop("disabled", true);
            },

            success: function (data) {
                // console.log(data);
                $.each(data, function (i) {
                    elRasxodGoods.append('<option value="' + data[i].id + '">' + data[i].name + '</option>');
                });
                elRasxodGoods.prop("disabled", false);
            },

            error: function () {
                alert('Error - Qayta takrorlang!');
            }
        });
    }

    function changeCostCurrency(rasxod_goods_id) {
        $.ajax({
            url: "<?=url(['rasxod-goods/get-cost-currency'])?>",
            method: "POST",
            data: {rasxod_goods_id: rasxod_goods_id, _csrf: yii.getCsrfToken()},
            dataType: "json",

            success: function (data) {
                elCost.val(data.cost);
                elCurrency.val(data.currency_id);
                elCurrency.empty().append('<option value="'+data.currency_id+'">'+data.currency_name+'</option>');
            },
        });
    }

    elRasxod.trigger('change');
});