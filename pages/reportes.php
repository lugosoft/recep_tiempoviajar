<?php
  echo"<script>var ofiRep = '{$_SESSION['oficina']}';</script>";
?>
<script>	
		
	function imprimirReporte(nombre, datosRep){
		var ficha = document.getElementById(nombre);
		//var ventimp = window.open(' ', 'popimpr');
    var ventimp = window.open("https://tourstiempodeviajar.lugo.host", "_blank");		
    
		var textoRep = document.getElementById('textoRep');
		var textofecha = document.getElementById('labelFecha');		
		
		ventimp.document.write("<img src='logoreportegestion"+ofiRep+".png' id='imcgXLS' name='imcgXLS'>");
		ventimp.document.write("<br>");
		ventimp.document.write(
		"<table border='0' width = '100%'>"+
			"<tr valign='center'>"+
				"<td colspan='2' align='center'><b>" + textoRep.innerHTML + "</b></td>"+
			"</tr>"+
			"<tr valign='center'>"+
				"<td colspan='2' align='right'><b>" + textofecha.innerHTML + "</b></td>"+
			"</tr>"+
			"<tr valign='center'>"+
				"<td colspan='2'><b>" + datosRep + "</b></td>"+
			"</tr>"+
		"</table>"+
		"<br>");

		ventimp.document.write(ficha.innerHTML);
		ventimp.document.close();
		sleepPrint(700).then(() => {
      ventimp.print( );
      ventimp.close();
    });
	};

	num=0;
	function crear(obj) {
	  num++;
	  fi = document.getElementById('fiel'); // 1
	  contenedor = document.createElement('div'); // 2
	  contenedor.id = 'div'+num; // 3
	  fi.appendChild(contenedor); // 4

	  ele = document.createElement('input'); // 5
	  ele.type = 'file'; // 6
	  ele.name = 'fil'+num; // 6
	  contenedor.appendChild(ele); // 7
	  
	  ele = document.createElement('input'); // 5
	  ele.type = 'button'; // 6
	  ele.value = 'Borrar'; // 8
	  ele.name = 'div'+num; // 8
	  ele.onclick = function () {borrar(this.name)} // 9
	  contenedor.appendChild(ele); // 7
	};
	
	function borrar(obj) {
	  fi = document.getElementById('fiel'); // 1 
	  fi.removeChild(document.getElementById(obj)); // 10
	};
	
	function crearFila() {
		var myCell = null;
		var myRow = null;
		var myEnc = null;
		var myA = null;
		
		var myTable = document.getElementById('tablaReporte');
		var myTbody = document.createElement("tbody");
		myTable.appendChild(myTbody);
		
		
		//Nueva Fila
		myRow = document.createElement("tr");
		//Nuevo Encabezado
		myEnc = document.createElement("th");
		myEnc.align='center';
		myEnc.valign='center';
		myA = document.createElement("a");
		myA.className='textoEncReporte';
		myA.innerHTML = "Columna 1";
		myEnc.appendChild(myA);
		myRow.appendChild(myEnc);		
		//Nuevo Encabezado
		myEnc = document.createElement("th");
		myEnc.align='center';
		myEnc.valign='center';
		myA = document.createElement("a");
		myA.className='textoEncReporte';
		myA.innerHTML = "Columna 2";
		myEnc.appendChild(myA);
		myRow.appendChild(myEnc);		
		//Agrego Fila
		myTbody.appendChild(myRow);
		
		
		//Nueva Fila
		myRow = document.createElement("tr");		
		//Nueva Celda
		myCell = document.createElement("td");
		myCell.valign='center';
		myA = document.createElement("a");
		myA.className='textoValReporte';
		myA.innerHTML = "Hello World!";
		myCell.appendChild(myA);
		myRow.appendChild(myCell);
		//Nueva Celda
		myCell = document.createElement("td");
		myCell.valign='center';
		myA = document.createElement("a");
		myA.className='textoValReporte';
		myA.innerHTML = "Hello World 2!";
		myCell.appendChild(myA);
		myRow.appendChild(myCell);
		//Agrego Fila
		myTbody.appendChild(myRow);
				
	};
	
</script>
<?php
	include "library/reporte".$page.".php";
?>
<div id="wrap">
	<div id="reporte" >
			<table id="tablaReporte" border="1" class="tabla_reporte">
			</table>	
	</div>		
</div>