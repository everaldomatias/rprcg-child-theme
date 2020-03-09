window.addEventListener( "DOMContentLoaded", () => {
    if (document.querySelector("body").classList.contains("home")) {
        let $wrapperContent = document.getElementById("territories-print");
        let $buttonsSections = document.getElementsByClassName("buttons-sections");

        [].forEach.call($buttonsSections, (e) => {
            e.addEventListener("click", () => {
                $wrapperContent.classList.add("off");
                $wrapperContent.style.opacity = "0";
                [].forEach.call($buttonsSections, (e) => {
                    e.classList.remove("active");
                });
                setTimeout(() => {
                    e.classList.add("active");
                    $wrapperContent.classList.remove("off");
                    $wrapperContent.style.opacity = "1";
                }, 1000);
            });
        });
    }
});


function apfaddpost( territoriesid ) {

    jQuery.ajax({

        type: 'POST',
        url: territoriesajax.ajaxurl,
        data: {
            action: 'territories_get_post_ajax',
            territoriesid: territoriesid
        },

        success: function (data, textStatus, XMLHttpRequest) {
            var id = '#territories-print';
            jQuery(id).html('');
            jQuery(id).load().html(data);

        },

        error: function ( XMLHttpRequest, textStatus, errorThrown ) {
            alert( errorThrown );
        }

    });

}
