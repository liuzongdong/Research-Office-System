
function change() {
	var pic = document.getElementById("preview"),
	    file = document.getElementById("avator");
		var ext=file.value.substring(file.value.lastIndexOf(".")+1).toLowerCase();
	    if(ext!='png'&&ext!='jpg'&&ext!='jpeg')
		{
	         alert("Upload Error.");
			 return;
	    }
		else
		{
			html5Reader(file);
		}
}
function html5Reader(file)
{
     var file = file.files[0];
     var reader = new FileReader();
     reader.readAsDataURL(file);
     reader.onload = function(e){
         var pic = document.getElementById("preview");
         pic.src=this.result;
     }
 }
