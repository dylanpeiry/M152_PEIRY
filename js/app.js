var MessageBox = {
    confirmation: function (text) {
        $("#postDescription").text(text);
        $('#deleteConfirmation').modal('show');
    },
    accepted: function (idPost) {
        $.get("../php/request.php", function (data) {
            console.log(data);
        })
        $('#deleteConfirmation').modal('hide');
    }
}