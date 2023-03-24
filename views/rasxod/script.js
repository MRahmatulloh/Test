$(function () {
    const prixodSelect = $('#rasxodgoods-prixod_id');
    const goodsSelect = $('#rasxodgoods-prixod_goods_id');
    const costInput = $('#rasxodgoods-cost');
    const currencySelect = $('#rasxodgoods-currency_id');
    const amountInput = $('#rasxodgoods-amount');
    const select2Chosen = $('#select2-chosen');

    function fetchAvailableGoods(prixodId) {
        $.ajax({
            url: '<?=url(['prixod-goods/select-goods-available'])?>',
            method: 'POST',
            data: { prixod_id: prixodId, _csrf: yii.getCsrfToken() },
            dataType: 'json',
            beforeSend: function () {
                select2Chosen.text('');
                goodsSelect.empty().append('<option value="">Выберите</option>').prop('disabled', true);
            },
            success: function (data) {
                goodsSelect.prop('disabled', false);
                $.each(data, function (i) {
                    goodsSelect.append($('<option>', { value: data[i].id, text: data[i].name }));
                });
            }
        });
    }

    function fetchCostCurrency(prixodGoodsId, rasxodId) {
        $.ajax({
            url: '<?=url(['prixod-goods/get-cost-currency'])?>',
            method: 'POST',
            data: { prixod_goods_id: prixodGoodsId, rasxod_id: rasxodId, _csrf: yii.getCsrfToken() },
            dataType: 'json',
            success: function (data) {
                costInput.val(data.cost);
                currencySelect.val(data.currency_id).trigger('change');
                amountInput.val(data.amount);
            }
        });
    }

    prixodSelect.on('change', function () {
        const prixodId = $(this).val();
        clearForm();
        fetchAvailableGoods(prixodId);
    });

    goodsSelect.on('change', function () {
        const prixodGoodsId = $(this).val();
        const rasxodId = $('#rasxod-id').val();
        clearForm();
        fetchCostCurrency(prixodGoodsId, rasxodId);
    });

    function clearForm() {
        amountInput.val(null);
        costInput.val(null);
        currencySelect.val(null).trigger('change');
    }

    prixodSelect.trigger('change');
});
