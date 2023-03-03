$(document).ready(function() {

    let elPrixod = $("#prixodgoods-rasxod_id");
    let elPrixodGoods = $('#prixodgoods-rasxod_goods_id');

    elPrixod.change(function (e) {
        var prixod_id = elPrixod.val();
        changeGoods(prixod_id);
    });

    function changeGoods(prixod_id) {
        $.ajax({
            url: "<?=url(['rasxod-goods/select-goods-available'])?>",
            method: "POST",
            data: {rasxod_id: prixod_id, _csrf: yii.getCsrfToken()},
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

    elPrixod.trigger('change');
});