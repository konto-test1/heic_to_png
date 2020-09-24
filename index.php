<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<style>
    #my-image img{
        max-height: 100px;
    }
</style>
<body>
        <form method="post" id="target" enctype="multipart/form-data">
            <input type="file" name="my_file[]" id="file" multiple>
            <input type="submit" value="Upload">
        </form>

    <div id="my-image">Twoje grafiki w png:</div>
<br>
<button id="button1">POBIERZ</button>



<script src="./node_modules/heic2any/dist/heic2any.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.5.0/jszip.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/file-saver@2.0.2/dist/FileSaver.min.js"></script>

    <script src="https://code.jquery.com/jquery-3.5.1.js" integrity="sha256-QWo7LDvxbWT2tbbQ97B53yJnYU3WhH/C8ycbRAkjPDc=" crossorigin="anonymous"></script>
    <script>

$("#target").submit(function( e ) {
  e.preventDefault();
    var files = $('#file')[0].files;

for (let i = 0; i < files.length; i++) {
    const element = files[i];
    test(element, i);
}



var zip = new JSZip();
var img = zip.folder("images");

    function test(zdjecie, photo_count){

// przed tym fetchem wcześniej wysyłać na serwer wtedy mam zapis ich plików

    fetch(`./grafiki/${zdjecie['name']}`)
        .then((res) => res.blob())
        .then((blob) => heic2any({ blob }))
        .then((conversionResult) => {
            var url = URL.createObjectURL(conversionResult);
            $('#my-image').append(`<img src="${url}">`)
            
            img.file(`photo${photo_count}.png`, conversionResult);
            zip.generateAsync({type:"blob"})
            .then(function(content) {
                console.log(`${files.length-1} == ${photo_count}`)
                if(files.length-1 == photo_count) {
                    saveAs(content, "final.zip");
                }
            });
        })
        .catch((errorObject) => {
            console.log(errorObject);
        });
    }
});
</script>
</body>
</html>
