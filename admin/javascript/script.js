function Insert_Product(){
    
    upload(arquivo);

    $.ajax({
        url     : "php/product.php",
        type    : "POST",
        data    : $("#form").serialize(),
        success : function(data){

        var response = JSON.parse(data);

        console.log(JSON.parse(data));
        if(response.success == true) {  
            $('#form')[0].reset();
            alert(response.message)   
        } else{
           $('#form')[0].reset();
           alert(response.message)   
        }
        }
    });
}
function upload(){
    var formData = new FormData();
    var arquivo = $("#file")[0].files;
    if(arquivo.length > 0){
        formData.append('file', arquivo[0]);
        $.ajax({
            type: "POST",
            data: formData,
            url:'..//php/upload.php',
            contentType:false,
            processData:false,
            success : function(data){
                //$('#form')[0].reset();
                //console.log(data);
            }
        }).fail(function(response, TextStatus, errorThrown){
            if(response.status == 404){
                console.log(response)
            }
        });
    }
}

function filter(){
    $.ajax({
        url: "/Mercadon/admin/php/filters.php",
        type:"POST",
        dataType: "JSON",
        success: function(json){
            for(var i=0;i<json.length-1;i++){
                $(".change").replaceWith("<td>"+json[i]+"</td>");
            }
                $(".img-responsive").replaceWith('<img src="local/"'+json.Img+'class="img-responsive img-thumbnail" width="150"></img>')
        }
    })
}