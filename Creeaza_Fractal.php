<?php									 
	session_start();		// incepem o sesiune PHP pentru salvarea unor valori					
?>

<!DOCTYPE html>              <!-- declaram o pagina HTML -->
<html lang="en">                <!-- setam limba de scriere a documentului HTML -->
		<meta charset="UTF-8">            <!-- setam modul de codificare al caracterelor -->
			<title> Barnsley Generator </title>          <!-- setam titlul barei din browser -->
			<link rel="icon" href="Imagini/Icon2.png">        <!-- setam iconita din dreptul barei --> 
			<link rel="stylesheet" href="Design2.css">        <!-- legam printr-un link fisierul CSS "Design2.css" pentru a putea accesa diferitele taguri formatate -->
			<link rel="stylesheet" href="Design1.css">		  <!-- legam printr-un link fisierul CSS "Design1.css" pentru a putea accesa diferitele taguri formatate -->	
			
	<body>           <!-- deschidem corpul paginii -->              
	
	<?php                                         // deschidem o sursa PHP    
			$directoare = array("Clasic", "Cyclosorus", "Culcita dubia", "Fishbone");        // declaram un vector cu numele fisierelor text din care vom citi coeficientii necesari generarii unui tip de fractal Barnsley
			$numar_puncte = array(400000, 700000, 1000000);                             // declaram un vector cu numerele de puncte pe care-l va contine fractalul de generat   
			$dl = array(-1, 0, 1, 0);                                                   // declaram vectorii de directie pentru cele 4 puncte cardinale: N S E V
			$dc = array(0, 1, 0, -1);
			$px = $py = 0;                                                                                
			
			function random_hex_color(){                                                                           // functia returneaza aleatoriu codul in baza 16 a unei culori
				$rand = array('0', '1', '2', '3', '4', '5', '6', '7', '8', '9', 'A', 'B', 'C', 'D', 'E', 'F');           // codul este format dintr-un '#' + 6 caractere in baza 16 scrise unul dupa altul
				$color = '#'.$rand[rand(0, 15)].$rand[rand(0, 15)].$rand[rand(0, 15)].$rand[rand(0, 15)].$rand[rand(0, 15)].$rand[rand(0, 15)];
				return $color;
			}
			
			function Barnsley($x, $y, $C, $centru_x, $centru_y){                 // functia calculeaza si salveaza coordonatele unui punct ce apartine fractalului
				global $M;                                                       // vom salva in matricea M toate punctele care fac parte din fractalul Barnsley                     
				$numar = rand(1, 100);                                                                                                         
				$M[intval($GLOBALS['px']*$GLOBALS['zoom']+500-$centru_x)][intval($GLOBALS['py']*(-1)*$GLOBALS['zoom']+650-$centru_y)] = 1;     // aplicand formulele descrise in aceasta linie
				if($numar <= $GLOBALS['p1']){                                          // urmatoarele linii salveaza in px si py coordonatele noului punct din fractal folosind algoritmul de generare al unui fractal Barnsley
					$GLOBALS['px'] = $C[1][1]*$x + $C[1][2]*$y + $C[1][5];
					$GLOBALS['py'] = $C[1][3]*$x + $C[1][4]*$y + $C[1][6];
				}
				else if($numar <= $GLOBALS['p1']+$GLOBALS['p2']){
					$GLOBALS['px'] = $C[2][1]*$x + $C[2][2]*$y + $C[2][5];
					$GLOBALS['py'] = $C[2][3]*$x + $C[2][4]*$y + $C[2][6];
				}
				else if($numar <= $GLOBALS['p1']+$GLOBALS['p2']+$GLOBALS['p3']){
					$GLOBALS['px'] = $C[3][1]*$x + $C[3][2]*$y + $C[3][5];
					$GLOBALS['py'] = $C[3][3]*$x + $C[3][4]*$y + $C[3][6];
				}
				else if($numar <= $GLOBALS['p1']+$GLOBALS['p2']+$GLOBALS['p3']+$GLOBALS['p4']){
					$GLOBALS['px'] = $C[4][1]*$x + $C[4][2]*$y + $C[4][5];
					$GLOBALS['py'] = $C[4][3]*$x + $C[4][4]*$y + $C[4][6];
				}
			}
			
			if(isset($_POST['Galerie'])){						// daca s-a accesat GALERIA
				echo '<div class="centru"> <img src="Imagini/Galerie1.png" width=900 alt=""> </div> <br>';       // afisam imaginea GALERIE la centru
				echo '<div class="centru"> <form action="Index.html"> <input type="submit" value="Inapoi la prima pagina"></form></div><br><br>';    // si un formular care ne trimite inapoi la pagina principala
				
				for($i = 0; $i<=3; $i++){					// vom afisa toate pozele salvate: pentru fiecare din cele 4 tipuri de fractali         
				echo "<p class='tip'> -- ",$directoare[$i], " --</p>";                // afisam intr-un paragraf " -- TIP FRACTAL -- "
				echo "<div class='scrollmenu'>";                                      // deschidem o bara orizontala de scroll
				$director = './Exemple_Frunze/'.$directoare[$i].'/';                  // creem adresa fisierului in care se afla imaginile fractalilor ce prezinta tipul curent 
				$fisiere_total = 0;
				if($deschide_director = opendir($director)){                          // daca s-a deschis fisierul
					while(($fisier = readdir($deschide_director)) !== FALSE){         // cat timp exista fisiere de citit
						if($fisier != "." && $fisier != ".."){                         // daca fisierul este diferit de 0 -- adica daca este o imagine
							  $fisiere_total++;    // adaugam la scrollbar imaginea respectiva
							}
						}
					}
					for($j = 1; $j<=$fisiere_total; $j++){
						$nume_fisier_imagine = $director.'/'.$directoare[$i].$j.".png";
						echo "<img src='$nume_fisier_imagine' class='img1' alt=''>";
					}
					echo "</div>";                           // inchidem bara orizontala de scroll
					echo "<br><br>";					
				}
			}
			else{                                    // altfel, daca nu accesam GALERIA, vom genera un fractal
				echo '<div class="centru"> <img src="Imagini/Imagine_Generare.png" width=900 alt=""> </div> <br>';                  // afisam imaginea GENERARE
				echo '<div class="centru"> <button class="button" id="Gata" onclick="arata_imagine()"> Vezi direct imaginea </button> <form action="Index.html"> <input type="submit" value="Inapoi la prima pagina"></form></div><br><br>';  // cream butonul care va afisa direct imaginea generata in functie de optiunile alese
				echo '<div class="centru"><canvas id="plansa"> </canvas></div><br><br>';     // cream o plansa la mijlocul paginii unde vom arata cum este creat fractalul 
				if(isset($_POST['Random_colors'])){                         // daca s-a ales sa se genereze un fractal de culori aleatorii
					$tip = $_POST['tip'];                                   // salvam tipul ales de fractal
					$culoare_frunza = random_hex_color();                   // generam 3 culori aleatorii pentru frunza, fundalul si umbra fractalului
					$culoare_fundal = random_hex_color();
					$culoare_umbra = random_hex_color();
					while($culoare_frunza == $culoare_fundal || $culoare_fundal == $culoare_umbra || $culoare_umbra == $culoare_frunza){   // atat timp cat exista 2 culori identice
						$culoare_frunza = random_hex_color();                        // generam alte 3 culori aleatorii 
						$culoare_fundal = random_hex_color();
						$culoare_umbra = random_hex_color();
					}
					$calitate = $_POST['calitate'];              // salvam calitatea imaginii in functie de care vom afla numarul de puncte din care va fi format fractalul
					if($calitate == "Simplu"){                   // calitatea SIMPLU corespunde numarului calitate[0] = 400000 puncte, MEDIU la calitate[1] = 700000 si COMPLEX la 1000000
						$numar = $numar_puncte[0];
					}
					else if($calitate == "Mediu"){
						$numar = $numar_puncte[1];
					}
					else{
						$numar = $numar_puncte[2];
					}
				}
				else if(isset($_POST['Random_fractal'])){					// daca s-a ales sa se genereze un fractal complet aleator
					$i = rand(0, 255)%4;                                    // alegem un numar aleator de la 0 la 3
					$tip = $directoare[$i];                                 // numarul respectiv va fi cel ce va determina tipul fractalului  
					$culoare_frunza = random_hex_color();                   // generam 3 culori aleatorii pentru frunza, umbra si fundalul fractalului 
					$culoare_fundal = random_hex_color();
					$culoare_umbra = random_hex_color();
					while($culoare_frunza == $culoare_fundal || $culoare_fundal == $culoare_umbra || $culoare_umbra == $culoare_frunza){   // cat timp exista 2 culori identice
						$culoare_frunza = random_hex_color();                           // vom genera alte 3 culori aleatorii
						$culoare_fundal = random_hex_color();
						$culoare_umbra = random_hex_color();
					}
					$i = rand(0, 255)%3;								// alegem un numar aleator de la 0 la 2
					$numar = $numar_puncte[$i];                         // numarul respectiv va fi cel ce va determina numarul de puncte al fractalului
				}
				else if(isset($_POST['Genereaza'])){						// daca s-a ales sa se genereze un fractal in functie de parametrii alesi
					$culoare_frunza = $_POST['culoare_frunza'];             // salvam in variabile culorile, tipul si numarul de puncte al fractalului 
					$culoare_fundal = $_POST['culoare_fundal'];
					$culoare_umbra = $_POST['culoare_umbra'];
					$tip = $_POST['tip'];
					$calitate = $_POST['calitate'];
					if($calitate == "Simplu"){
						$numar = $numar_puncte[0];
					}
					else if($calitate == "Mediu"){
						$numar = $numar_puncte[1];
					}
					else{
						$numar = $numar_puncte[2];
					}
				}
				$nume_fisier_coeficienti = "./Valori_Coeficienti/".$tip.".txt";          // formam calea fisierului pentru a citi coeficientii 
				$citeste = fopen($nume_fisier_coeficienti, "r");                        // deschidem fisierul pentru a citi numere reale
				$total = 0;                                                               
				if($citeste){                                                           // daca s-a deschis fisierul  
					while(($valoare = fgets($citeste, 1000)) != false){                 // cat timp exista linii de citit
						$p = strtok($valoare, " ");                                     // separam linia citita in parti delimitate de caracterul " " 
						while($p != NULL){                                              // cat timp exista " "
							$coeficienti[$total] = floatval($p);                        // salvam coeficientul in vectorul respectiv
							$total ++;													// marim numarul de coeficienti cu 1
							$p = strtok(" ");                                           // cautam din nou caracterul " "
						}
					}
					fclose($citeste);                                                    // citirea s-a terminat
				}
			
				$i = -1;
				$n = $coeficienti[++$i];												// folosind vectorul "coeficienti" copiem valorile pentru a crea variabile noi				
				$m = $coeficienti[++$i];
				$centru_x = $coeficienti[++$i];
				$centru_y = $coeficienti[++$i];
				$zoom = $coeficienti[++$i];
				$p1 = $coeficienti[++$i];
				$p2 = $coeficienti[++$i];
				$p3 = $coeficienti[++$i];
				$p4 = $coeficienti[++$i];
				$indice = ++$i;
				for($i = 1; $i<=4; $i++){                                               // cream matricea de coeficienti descrisa in modul de generare al fractalului Barnsley
					for($j = 1; $j<=6; $j++){
						$C[$i][$j] = $coeficienti[$indice];
						$indice++;
					}	
				}
				for($i = 0; $i < $n; $i++){												// curatam matricea in care vom salva punctele ce fac parte din fractal			
					for($j = 0; $j < $m; $j++){                 
						$M[$i][$j] = 0;
					}
				}
		
				for($i = 1; $i<=$numar; $i++){                                         // generam si salvam in matricea M punctele ce formeaza fractalul
					Barnsley($px, $py, $C, $centru_x, $centru_y);
				}
				for($i = 0; $i<$n; $i++){                                         // parcurgem matricea M pentru a determina ce puncte formeaza umbra fractalului 
					for($j = 0; $j<$m; $j++){
						for($k = 0; $k<4 && $M[$i][$j] == 1; $k++){                  
							$l9 = $i + $dl[$k];
							$c9 = $j + $dc[$k];
							if($M[$l9][$c9] == 0){                                // daca un punct care nu face parte din fractal este vecinul unui punct ce e parte din fractal
								$M[$l9][$c9] = 2;								// atunci punctul respectiv face parte din umbra fractalului
							}
						}
					}
				}
				$imagine = imagecreatetruecolor($n, $m);                       // creem o variabila in care vom desena fractalul
				for($i = 0; $i<$n; $i++){                                      // parcurgem matricea M
					for($j = 0; $j<$m; $j++){
						if($M[$i][$j] == 1){                                    // daca M[i][j] este 1
							$color = $culoare_frunza;                           // punctul respectiv formeaza frunza fractalului
						}
						else if($M[$i][$j] == 2){                            // altfel, daca e 2
							$color =  $culoare_umbra;                        // punctul face parte din umbra fractalului
						}
						else{                                               // altfel, punctul face parte din fundal
							$color = $culoare_fundal;
						}
						imagesetpixel($imagine, $i, $j, hexdec($color));                // desenam la pozitia (i,j) in imagine punctul de culoarea respectiva
					}
				}	
				$fisiere = 0;														// vom forma numele imaginii cu fractalul pe care il vom genera	      			
				$director = './Exemple_Frunze/'.$tip.'/';                           // deschidem fisierul cu tipul fractalului ales      
				if($deschide_director = opendir($director)){                        // daca s-a deschis fisierul 
					while(($fisier = readdir($deschide_director)) !== FALSE){       // cat timp exista fisiere de citit
						if($fisier != "." && $fisier != ".."){                      // daca numele fisierului nu e nul 
							$fisiere++;                                             // actualizam numarul de fisiere gasite
						}
					}
				}
				$fisiere++;                                  // incrementam numarul de fisiere gasite - numarul lor va fi mai mare cu 1 deoarece imaginea pe care o vom crea se va afla aici
				$nume_fisier = './Exemple_Frunze/'.$tip.'/'.$tip.$fisiere.".png";            // cream adresa si numele imaginii cu fractalul generat din tipul sau + numarul pozei
				imagepng($imagine, $nume_fisier);                                            // generam poza la adresa creata mai sus
				echo "<p class='tip' hidden> <img id='imagine_creata' src='$nume_fisier' class='img1' alt=''> </p><br><br>"; // afisam intr-un paragraf ascuns imaginea cu fractalul generat
				if(!isset($_SESSION["nume_fisier"])){                                       // salvam in sesiune variabilele pe care le vom folosi in sursa JAVASCRIPT 
					$_SESSION["nume_fisier"] = $nume_fisier;
				}
				if(!isset($_SESSION["tip"])){
					$_SESSION["tip"] = $tip;
				}
				if(!isset($_SESSION["fisiere"])){
					$_SESSION["fisiere"] = $fisiere;
				}
				if(!isset($_SESSION["coeficienti"])){
					$_SESSION["coeficienti"] = $coeficienti;
				}
				if(!isset($_SESSION["culoare_frunza"])){
					$_SESSION["culoare_frunza"] = $culoare_frunza;
				}
				if(!isset($_SESSION["culoare_fundal"])){
					$_SESSION["culoare_fundal"] = $culoare_fundal;
				}
				if(!isset($_SESSION["culoare_umbra"])){
					$_SESSION["culoare_umbra"] = $culoare_umbra;
				}
				if(!isset($_SESSION["numar"])){
					$_SESSION["numar"] = $numar;
				}
				if(!isset($_SESSION["M"])){
					$_SESSION["M"] = $M;
				}
			}
	?>                                             <!-- inchidem sursa PHP --> 
	
	<script>                                <!-- deschidem o sursa JAVASCRIPT -->
		var coeficienti = <?php echo json_encode($coeficienti); ?>;              // cream variabile pentru valorile salvate in sesiune si le salvam ca in sursa precedenta
		var culoare_umbra =	<?php echo json_encode($culoare_umbra); ?>;
		var culoare_fundal = <?php echo json_encode($culoare_fundal); ?>;
		var culoare_frunza = <?php echo json_encode($culoare_frunza); ?>;
		var numar_puncte = <?php echo json_encode($numar); ?>;
		var M = <?php echo json_encode($M); ?>;
		var nume_fisier = <?php echo json_encode($nume_fisier); ?>;
		var dl = [-1, 0, 1, 0];
		var dc = [0, 1, 0, -1];
		var	C = [];
		var i = -1;
		var j;
		var	px = 0;
		var	py = 0;
		var	n = coeficienti[++i];
		var	m = coeficienti[++i];
		var centru_x = coeficienti[++i];
		var centru_y = coeficienti[++i];
		var zoom = coeficienti[++i];
		var	p1 = coeficienti[++i];
		var	p2 = coeficienti[++i];
		var	p3 = coeficienti[++i];
		var	p4 = coeficienti[++i];
		var	indice = ++i;
		for(i = 1; i<=4; i++){
			C[i] = new Array();
			for(j = 1; j<=6; j++){
				C[i][j] = coeficienti[indice];
				indice++;
			}
		}
		C[0] = new Array();
		for(i = 0; i<=4; i++){
			C[i][0] = 0;
			C[0][i] = 0;
		}
		function arata_imagine(){                                           // functia va afisa direct imaginea creata a fractalului de generat
			context.fillStyle = culoare_fundal;                             // setam culoarea curenta cu cea a fundalului fractalului
			context.fillRect(0,0, n, m);                                    // coloram toata plansa folosind culoarea respectiva 
			var imagine = document.getElementById("imagine_creata");        // accesam imaginea creata in sursa PHP si salvata in paragraful ascuns
			context.drawImage(imagine, 0, 0);                               // desenam imaginea
			var buton = document.getElementById("Gata");                    // ascundem butonul "Vezi direct imaginea"
			buton.style.display = "none";
		}
	<?php                                                                       
		if(!isset($_POST["Galerie"])){                                       // daca nu s-a accesat galeria  
			echo '</script>';                                                      // inchidem sursa 
			echo '<script src="Generare_Animata.js"> </script>';                   // rulam sursa ce va arata cum se genereaza fractalul Barnsley
		}
	?>
	</body>                                        <!-- inchidem corpul paginii -->
</html>                                        
	
