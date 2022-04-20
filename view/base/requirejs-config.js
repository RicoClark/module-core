

var config = {
    paths: {
        'droppery/core/jquery/popup': 'Droppery_Core/js/jquery.magnific-popup.min',
        'droppery/core/owl.carousel': 'Droppery_Core/js/owl.carousel.min',
        'droppery/core/bootstrap': 'Droppery_Core/js/bootstrap.min',
        mpIonRangeSlider: 'Droppery_Core/js/ion.rangeSlider.min',
        touchPunch: 'Droppery_Core/js/jquery.ui.touch-punch.min',
        mpDevbridgeAutocomplete: 'Droppery_Core/js/jquery.autocomplete.min'
    },
    shim: {
        "droppery/core/jquery/popup": ["jquery"],
        "droppery/core/owl.carousel": ["jquery"],
        "droppery/core/bootstrap": ["jquery"],
        mpIonRangeSlider: ["jquery"],
        mpDevbridgeAutocomplete: ["jquery"],
        touchPunch: ['jquery', 'jquery/ui']
    }
};
