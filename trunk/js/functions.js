//Función para comprobar datos del tipo nombre de usuario. Se comprueba que tenga
//un mínimo de caracteres y que solo sea caracteres alfanumericos
function Check_only_alphanumerics(str, len, maxi){
	if (str.length<len || str.length>maxi)
		return false;
	else{
		var plant = /[^\w]+/gi;
		if (plant.test(str))
			return false
	}
	return true
}


//Función para comprobar que tiene un determinado número de caracteres y que 
//estos son número exclusivamente
function Check_only_numbers(str, len, maxi){
	if (str.length<len || str.length>maxi)
		return false;
	else{
		var plant = /[^0-9]+/gi;
		if (plant.test(str))
			return false
	}
	return true;		
}

//Función para comprobar si una cadena corresponde a un número
function isNumber(str){
	var plant = /[^0-9]+/gi;
	if (plant.test(str))
		return false; 
	
	return true;
}


//Función para comparar si dos cadenas son iguales
function equals(str1, str2){
	if (str1==str2)
		return true;
	else
		return false;
}


//Función para comprobar si una cadena es la cadena vacia
function isEmpty(str){
if (str!="")
	return true;
else
	return false;
}


//Función para comprobar el correcto formato de un email
function Check_mail(str, optional) {
  if (optional && str=="")
  	return true;

	var plant = /[^\w^@^\.^-]+/gi
	if (plant.test(str))
		return false;
	else{
		plant =/(^[\w\.-]+)(@{1})([\w\.-]+$)/i
		if (plant.test(str))
			return true;
		else
			return false;
 	}
  
  
}

//Función para comprobar si un radio element está seleccionado
function Check_radio_selected(checked){
	return checked;
}

//Función para comprobar el formato de una fecha
function Check_date(str) {
var plant = new RegExp("([0-3][0-9])-([0-1][0-9])-([0-9]){4,}$", "i");
if (plant.test(str))
	return true;
else
	return false;
}

//Función para imprimir la carpeta seleccionada de un input file
function Get_folder(str){
return str.substr(0,str.lastIndexOf("\\")+1);
}

//Función para comprobar que los nombres de ficheros cumplen ciertas normas
function Check_file(str, optional){
if (optional && str=="")
	return true;

var plant = new RegExp("[^-A-Za-z0-9.:_()@#\\\\/]+","i");

//Obtengo el nombre del fichero obviando la ruta al fichero
namefile = str.substring(str.lastIndexOf("\\")+1).toLowerCase();
if (plant.test(namefile))
	return false;
else
	return true;
}

//Función para comprobar si una cadena está incluida en otra y además está al 
//inicio de la misma.
function Check_initial_strings(str1, str2){
	str_aux = str2.substr(0,str1.length);
	if (str_aux == str1)
		return true;
	else
		return false;
}

//Función para cambiar de color el subtítulo seleccionado
function change_selected_subtitle(id, pages, subtitles_page){
	for (i=0;i<(pages*subtitles_page);i++){
		document.formi['pInitial_'+i].style.backgroundColor='';
		document.formi['pInitial_Milesimes_'+i].style.backgroundColor='';
		document.formi['pFinal_'+i].style.backgroundColor='';
		document.formi['pFinal_Milesimes_'+i].style.backgroundColor='';
		document.formi['pText_'+i].style.backgroundColor='';				
		document.formi['pInitial_'+i].style.color='';
		document.formi['pInitial_Milesimes_'+i].style.color='';
		document.formi['pFinal_'+i].style.color='';
		document.formi['pFinal_Milesimes_'+i].style.color='';
		document.formi['pText_'+i].style.color='';						
	}

	document.formi['pInitial_'+id].style.backgroundColor='#ACACE8';
	document.formi['pInitial_Milesimes_'+id].style.backgroundColor='#ACACE8';
	document.formi['pFinal_'+id].style.backgroundColor='#ACACE8';
	document.formi['pFinal_Milesimes_'+id].style.backgroundColor='#ACACE8';
	document.formi['pText_'+id].style.backgroundColor='#ACACE8';		
	document.formi['pInitial_'+id].style.color='#000000';
	document.formi['pInitial_Milesimes_'+id].style.color='#000000';
	document.formi['pFinal_'+id].style.color='#000000';
	document.formi['pFinal_Milesimes_'+id].style.color='#000000';
	document.formi['pText_'+id].style.color='#000000';			
}

//Función para cambiar de página de subtitulos
function change_subtitle_page(id, pages){
	for (i=0;i<pages;i++)
		document.getElementById('capa_'+i).style.display = 'none';
	
	document.getElementById(id).style.display = '';
}

//Función que devuelve un tiempo en formato HH:MM:SS 
//a partir de una cantidad de segundos
function getHMS(seconds){
	hora = parseInt(seconds / 3600);
	restohora = seconds % 3600;
	minuto = parseInt(restohora / 60);
	segundo = parseInt(restohora % 60);
	
	if (hora<10)
		hora = '0'+hora;
	
	if (minuto<10)
		minuto = '0'+minuto;
	
	if (segundo<10)
		segundo = '0'+segundo;
	
	return (hora+':'+minuto+':'+segundo);
}

/**
 * This function generates the actual toolbar buttons with localized text
 * we use it to avoid creating the toolbar where javascript is not enabled
 */
function formatButton(imageFile, speedTip, tagOpen, tagClose, sampleText, accessKey, nameForm, nameTextarea) {
  speedTip=escapeQuotes(speedTip);
  tagOpen=escapeQuotes(tagOpen);
  tagClose=escapeQuotes(tagClose);
  sampleText=escapeQuotes(sampleText);

  document.write("<a ");
  if(accessKey){
    document.write("accesskey=\""+accessKey+"\" ");
    speedTip = speedTip+' [ALT+'+accessKey.toUpperCase()+']';
  }
  document.write("href=\"javascript:insertTags");
  document.write("('"+tagOpen+"','"+tagClose+"','"+sampleText+"', '"+nameForm+"', '"+nameTextarea+"');\">");

  document.write("<img width=\"24\" height=\"24\" src=\"../images/"+imageFile+"\" border=\"0\" alt=\""+speedTip+"\" title=\""+speedTip+"\">");
  document.write("</a>");
  return;
}

/**
 * This function escapes some special chars
 */
function escapeQuotes(text) {
  var re=new RegExp("'","g");
  text=text.replace(re,"\\'");
  re=new RegExp('"',"g");
  text=text.replace(re,'&quot;');
  re=new RegExp("\\n","g");
  text=text.replace(re,"\\n");
  return text;
}

/**
 * apply tagOpen/tagClose to selection in textarea, use sampleText instead
 * of selection if there is none copied and adapted from phpBB
 *
 * @author phpBB development team
 * @author MediaWiki development team
 * @author Andreas Gohr <andi@splitbrain.org>
 * @author Jim Raynor <jim_raynor@web.de>
 */
function insertTags(tagOpen, tagClose, sampleText, nameForm, nameTextarea) {
  //var txtarea = document.formi.pDescription;
var clientPC  = navigator.userAgent.toLowerCase(); // Get client info
var is_gecko  = ((clientPC.indexOf('gecko')!=-1) && (clientPC.indexOf('spoofer')==-1)
                && (clientPC.indexOf('khtml') == -1) && (clientPC.indexOf('netscape/7.0')==-1));
  var txtarea = document.forms[nameForm].elements[nameTextarea];
  // IE
  if(document.selection  && !is_gecko) {
    var theSelection = document.selection.createRange().text;
    var replaced = true;
    if(!theSelection){
      replaced = false;
      theSelection=sampleText;
    }
    txtarea.focus();

    // This has change
    text = theSelection;
    if(theSelection.charAt(theSelection.length - 1) == " "){// exclude ending space char, if any
      theSelection = theSelection.substring(0, theSelection.length - 1);
      r = document.selection.createRange();
      r.text = tagOpen + theSelection + tagClose + " ";
    } else {
      r = document.selection.createRange();
      r.text = tagOpen + theSelection + tagClose;
    }
    if(!replaced){
      r.moveStart('character',-text.length-tagClose.length);
      r.moveEnd('character',-tagClose.length);
    }
    r.select();
  // Mozilla
  } else if(txtarea.selectionStart || txtarea.selectionStart == '0') {
    var replaced = false;
    var startPos = txtarea.selectionStart;
    var endPos   = txtarea.selectionEnd;
    if(endPos - startPos) replaced = true;
    var scrollTop=txtarea.scrollTop;
    var myText = (txtarea.value).substring(startPos, endPos);
    if(!myText) { myText=sampleText;}
    if(myText.charAt(myText.length - 1) == " "){ // exclude ending space char, if any
      subst = tagOpen + myText.substring(0, (myText.length - 1)) + tagClose + " ";
    } else {
      subst = tagOpen + myText + tagClose;
    }
    txtarea.value = txtarea.value.substring(0, startPos) + subst +
                    txtarea.value.substring(endPos, txtarea.value.length);
    txtarea.focus();

    //set new selection
    if(replaced){
      var cPos=startPos+(tagOpen.length+myText.length+tagClose.length);
      txtarea.selectionStart=cPos;
      txtarea.selectionEnd=cPos;
    }else{
      txtarea.selectionStart=startPos+tagOpen.length;
      txtarea.selectionEnd=startPos+tagOpen.length+myText.length;
    }
    txtarea.scrollTop=scrollTop;
  // All others
  } else {
    var copy_alertText=alertText;
    var re1=new RegExp("\\$1","g");
    var re2=new RegExp("\\$2","g");
    copy_alertText=copy_alertText.replace(re1,sampleText);
    copy_alertText=copy_alertText.replace(re2,tagOpen+sampleText+tagClose);
    var text;
    if (sampleText) {
      text=prompt(copy_alertText);
    } else {
      text="";
    }
    if(!text) { text=sampleText;}
    text=tagOpen+text+tagClose;
    //append to the end
    txtarea.value += "\n"+text;

    // in Safari this causes scrolling
    if(!is_safari) {
      txtarea.focus();
    }

  }
  // reposition cursor if possible
  if (txtarea.createTextRange) txtarea.caretPos = document.selection.createRange().duplicate();
}

//Esta función se utilizará para posicionar el cursor en el primer elemento del formulario
function placeFocus() {
    if (document.forms.length > 0) {
        var field = document.forms[0];
        for (i = 0; i < field.length; i++) {
            if ((field.elements[i].type == "text") || (field.elements[i].type == "textarea")) {
                //if ((field.elements[i].name != "pTextSearch") && (document.getElementById(field.elements[i].name).style.visibility!="none")){
                if (field.elements[i].name != "pTextSearch"){
                 	try{
	                    document.forms[0].elements[i].focus();
	                }catch(e){}
                }
                break;
            }
        }
    }
}

//Función para mostrar una vista previa del código introducido en un textarea
function preview(nameForm, nameTextarea, name_div_textarea){
    var parrafo = document.getElementById(name_div_textarea);
    parrafo.innerHTML = document.forms[nameForm].elements[nameTextarea].value.replace(/\n/g, "<br/>");
}

//Función para ocultar y mostrar el frame de la izquierda
function cambiar(esto, text_hide, text_show){
    //s=esto.id=="Quitar";
    s=top.document.getElementById('pepe').cols=='190,*';
    destino=(s)?0:190;
    incremento=(s)?-5:5;
    origen=(s)?190:0;
    esto.id=(s)?"Poner":"Quitar";
    esto.title=(s)?text_show:text_hide;
    mover(origen,destino,incremento);
}

//Función que muestra como aparece o desaparece el frame izquierdo
function mover(origen,destino,incremento){
    origen+=incremento;
    top.document.getElementById('pepe').cols=origen+',*'
    if(origen!=destino){
        o=origen;
        d=destino;
        i=incremento;
        setTimeout("mover(o,d,i)",10);
    }
}

//Función que compara dos fechas y devuelve los siguientes valores
//Las fechas están en el formato dd-mm-yyyy
//1: ambas fechas son iguales
//2: la primera fecha es mayor que la segunda
//3: la primera fecha es menor que la segunda
function CompareDates(strdate1, strdate2){
	yeardate1 = strdate1.substr(6,4);
	monthdate1 = strdate1.substr(3,2);
	daydate1 = strdate1.substr(0,2);
	yeardate2 = strdate2.substr(6,4);
	monthdate2 = strdate2.substr(3,2);
	daydate2 = strdate2.substr(0,2);	
	date1 = new Date(yeardate1, monthdate1, daydate1);
	date2 = new Date(yeardate2, monthdate2, daydate2);
	
	if (date1==date2)
		return 1;
	else if (date1>date2)
			return 2;
		 else
		 	return 3;
}

//Función AJAX para actualizar el nombre de un campo editado con la forma edit in place
function saveeditinplace(table,nameprimarykey,valueprimarykey,namecolumntochange, newvalue){
	url = "../ajax/saveeditinplace.php";
	new Ajax.Request(url, {
	 	parameters: { table: table, nameprimarykey: nameprimarykey, valueprimarykey: valueprimarykey, namecolumntochange: namecolumntochange, newvalue: newvalue},
		method: 'post',
		onSuccess: function(transport) {
			$('form_edit_in_place_'+table+'_'+nameprimarykey+'_'+valueprimarykey).hide();
			$('edit_in_place_'+table+'_'+nameprimarykey+'_'+valueprimarykey).update(transport.responseText);
			$('edit_in_place_'+table+'_'+nameprimarykey+'_'+valueprimarykey).show();
		}
	});			
}
