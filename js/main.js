$(function(){
    var requestList = $.ajax({
        method:"GET",
        url:"post.php",
        data:{listAll:"list"},
        dataType:"json"
    });
    requestList.done(function(e){
        console.log(e);
        var table = '<thead><tr><th>id</th><th>Aluno</th><th>Turma</th><th>Matéria</th><th>Nota</th></tr></thead><tbody>';
        for(var k in e){
            table += '<tr><th scope="row">'+e[k].id+'</th>';
            table += '<td>'+e[k].aluno+'</td>';
            table += '<td>'+e[k].turma+'</td>';
            table += '<td>'+e[k].materia+'</td>';
            table += '<td>'+e[k].nota+'</td></tr>';
        }
        table +='</tbody>';
        $('#notas').html(table);
    });


    $('#AjaxRequest').submit(function(){
        var form = $(this).serialize();
        var request = $.ajax({
            method:"POST",
            url:"post.php",
            data:form,
            dataType:"json"
        });
        request.done(function(e){
            $('#msg').html(e.msg);

            if(e.status){
                $('#AjaxRequest').each(function(){
                    this.reset();
                });
                var table = '<tr><th scope="row">'+ e.notas.id+'</th>';
                table += '<td>'+e.notas.aluno+'</td>';
                table += '<td>'+e.notas.turma+'</td>';
                table += '<td>'+e.notas.materia+'</td>';
                table += '<td>'+e.notas.nota+'</td></tr>';
                $('#notas tbody').prepend(table);

            }

        });
        request.fail(function(e){
            console.log("fail");
            console.log(e);
        });
        request.always(function(e){
            console.log("always");
            console.log(e);
        });

        return false;
    });
});