! function (e) {
    "use strict";

    function t() {
        this.$body = e("body")
    }
    t.prototype.init = function () {
        Dropzone.autoDiscover = !1, e('[data-plugin="dropzone"]').each(function () {
            var t = e(this).attr("action"),
                i = e(this).data("previewsContainer"),
                t = {
                    url: t
                },
                i = (i && (t.previewsContainer = i), e(this).data("uploadPreviewTemplate"));
            i && (t.previewTemplate = e(i).html()), e(this).dropzone(t)
        })
    }, e.FileUpload = new t, e.FileUpload.Constructor = t
}(window.jQuery),
function () {
    "use strict";
    window.jQuery.FileUpload.init()
}();
