var input = document.getElementById( 'file-upload' );
var infoArea = document.getElementById( 'file-upload-filename' );

input.addEventListener( 'change', showFileName );

function showFileName( event ) {
  var input = event.srcElement;
  var fileName = input.files[0].name;
    if(fileName.length >= 25){
      let splitName = fileName.split('.');
      fileName1 = splitName[0].substring(0, 26) + ".. ." + splitName[1];
    }
    else{
      fileName1 = input.files[0].name;
    }
  infoArea.textContent = fileName1;
}