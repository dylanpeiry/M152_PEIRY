var MessageBox = {
    confirmation: function (text) {
        $("#postDescription").text(text);
        $('#deleteConfirmation').modal('show');
    },
    accepted: function (idPost) {
        $.get("./php/request.php?action=delete&postid=51", function (data) {
            console.log(data);
        })
        $('#deleteConfirmation').modal('hide');
    }
}