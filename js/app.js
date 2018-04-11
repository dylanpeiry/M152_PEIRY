var MessageBox = {
    confirmation: function (text, id) {
        $(".postDescription").text(text);
        $(".postDescription").attr('id',id);
        $('#deleteConfirmation').modal('show');
    },
    accepted: function (idPost) {
        $.get("./php/request.php?action=delete&postid=" + idPost, function (data) {
            console.log(data);
        })
        $('#deleteConfirmation').modal('hide');
    }
}