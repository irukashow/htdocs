jQuery(function () {
    if ($('form.dropzone').length > 0) {
      Dropzone.options.myAwesomeDropzone = {
            maxFiles: 2,
            autoProcessQueue: true,
            init: function () {
                this.on("maxfilesexceeded", function (file) {
                    this.removeAllFiles();
                });
                this.on("addedfile", function (file) {
                    if (this.files[1] != null) {
                        this.removeFile(this.files[0]);
                    }
                    return $('#upload_message').html("");
                });
                this.on("success", function (file) {
                    var shop_category = jQuery.parseJSON(file.xhr.response).shop_category;
                    return $('#upload_message').html("<b style='color: green;'>アップロード成功しました。</b>");
                });
                this.on("error", function (file) {
                    return $('#upload_message').html("<b style='color: red;'>アップロードに失敗しました。</b>");
                });
                this.on("complete", function (file) {
//                    this.removeFile(file);
                });

            }
      }
    }
});