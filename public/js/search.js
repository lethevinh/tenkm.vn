$(document).ready(function (){
    function convertMoney($input, locale = 'vi', max = false) {
        let  string = {
            ty : 'tỷ',
            trieu : 'triệu',
            nghin : 'nghìn',
        };

        let currency = 'VND';

        if (locale === 'en'){
            string = {
                ty : 'L',
                trieu : 'M',
                nghin : 'K',
            };
            currency = '$'
        }

        let  condition = {
            ty : 1000000000,
            trieu : 1000000,
            nghin : 1000,
        };

        for (const conditionKey in condition) {
            let $secs = condition[conditionKey];
            let $d = $input / $secs;
            let $str = string[conditionKey];
            if ($d >= 1) {
                let $r = Math.round($d);
                $input =  '' + $r + ' ' + $str + ($r > 1 ? ' ' : '');
            }
        }
        return $input + (max ? ' ++ ' : ' ') + currency;
    }
    let priceSlider = $( ".rld-price-slider" );
    if (priceSlider.length > 0) {
        //let handleLeft = $( ".ui-slider-handle-price.left" );
        //let handleRight = $( ".ui-slider-handle-price.right" );
        let handleLeft = $( ".min-price-label" );
        let handleRight = $( ".max-price-label" );
        let locale = window.tenkm.locale;
        let min = window.tenkm.searchOption.minPrice;
        let max = window.tenkm.searchOption.maxPrice;
        let priceMinInput = $('input[name="mi_price"]');
        let priceMaxInput = $('input[name="ma_price"]');
        let minValue = (priceMinInput && priceMinInput.val()) ? priceMinInput.val() : min;
        let maxValue = (priceMaxInput && priceMaxInput.val()) ? priceMaxInput.val() : max;
        priceSlider.slider({
            range: true,
            min: Math.max(min, 0),
            max: max,
            values: [minValue, maxValue],
            create: function() {
                let minLabel = minValue > 0 && minValue === min ? convertMoney(parseFloat(minValue), locale, true): convertMoney(parseFloat(minValue), locale);
                let maxLabel = maxValue > 0 && maxValue === max ? convertMoney(parseFloat(maxValue), locale, true):convertMoney(parseFloat(maxValue), locale);
                handleLeft.text(minLabel);
                handleRight.text(maxLabel);
            },
            slide: function( event, ui ) {
                let minValue = ui.values[0];
                let maxValue = ui.values[1];
                let minLabel = minValue > 0 && minValue === min ? convertMoney(parseFloat(minValue), locale, true): convertMoney(parseFloat(minValue), locale);
                let maxLabel = maxValue > 0 && maxValue === max ? convertMoney(parseFloat(maxValue), locale, true):convertMoney(parseFloat(maxValue), locale);
                handleLeft.text(minLabel);
                handleRight.text(maxLabel);
                priceMinInput.val(minValue);
                priceMaxInput.val(maxValue);
            }
        });
    }

    let sizeSlider = $( ".rld-size-slider" );
    if (sizeSlider.length > 0) {
        //let handleLeft = $( ".ui-slider-handle-size.left" );
        //let handleRight = $( ".ui-slider-handle-size.right" );
        let handleLeft = $( ".min-area-label" );
        let handleRight = $( ".max-area-label" );
        let sizeMinInput = $('input[name="mi_size"]');
        let sizeMaxInput = $('input[name="ma_size"]');
        let min = window.tenkm.searchOption.minArea;
        let max = window.tenkm.searchOption.maxArea;
        let minValue = (sizeMinInput && sizeMinInput.val()) ? sizeMinInput.val() : min;
        let maxValue = (sizeMaxInput && sizeMaxInput.val()) ? sizeMaxInput.val() : max;
        let m2 = ' m²';
        sizeSlider.slider({
            range: true,
            min: Math.max(min, 0),
            max: max,
            values: [minValue, maxValue],
            create: function() {
                let minLabel = minValue > 0 && minValue === min ? minValue + ' ++': minValue;
                let maxLabel = maxValue > 0 && maxValue === max ? maxValue + ' ++': maxValue;
                handleLeft.text(minLabel + m2);
                handleRight.text(maxLabel + m2);
            },
            slide: function( event, ui ) {
                let minValue = ui.values[0];
                let maxValue = ui.values[1];
                let minLabel = minValue > 1 && minValue === min ? minValue + ' ++': minValue;
                let maxLabel = maxValue > 0 && maxValue === max ? maxValue + ' ++': maxValue;
                handleLeft.text(minLabel + m2);
                handleRight.text(maxLabel + m2);
                sizeMinInput.val(minValue);
                sizeMaxInput.val(maxValue);
            },
            change: function( event, ui ) {
                //let value = sizeSlider.slider( "option", "value" );
                //console.log(value)
                //  sizeInput.val(value);
            }
        });
    }
    $('.category-filter-btn').click(function (event){
        let $element = $(this);
        let idCat = $element.data('id-cat');
        $('.category-filter-btn').removeClass('active');
        $element.addClass('active');
        $('input[name="cat"]').val(idCat);
    });
});
