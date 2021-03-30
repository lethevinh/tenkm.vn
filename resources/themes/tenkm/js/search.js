$(document).ready(function (){
    function convertMoney($input, locale = 'vi') {
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
        return $input + ' ' + currency;
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
                handleLeft.text(convertMoney(parseFloat(minValue), locale));
                handleRight.text(convertMoney(parseFloat(maxValue), locale));
            },
            slide: function( event, ui ) {
                let minValue = ui.values[0];
                let maxValue = ui.values[1];
                handleLeft.text(convertMoney(parseFloat(minValue), locale));
                handleRight.text(convertMoney(parseFloat(maxValue), locale));
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
        let min = (sizeSlider && sizeSlider.data('min')) ? sizeSlider.data('min') : 1;
        let max = (sizeSlider && sizeSlider.data('max')) ? sizeSlider.data('max') : 6500;
        let minValue = (sizeMinInput && sizeMinInput.val()) ? sizeMinInput.val() : 1;
        let maxValue = (sizeMaxInput && sizeMaxInput.val()) ? sizeMaxInput.val() : 6500;
        let m2 = ' m²';
        sizeSlider.slider({
            range: true,
            min: Math.max(min, 0),
            max: max,
            values: [minValue, maxValue],
            create: function() {
                handleLeft.text(minValue + m2);
                handleRight.text(maxValue + m2);
            },
            slide: function( event, ui ) {
                let minValue = ui.values[0];
                let maxValue = ui.values[1];
                handleLeft.text(minValue + m2);
                handleRight.text(maxValue + m2);
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
