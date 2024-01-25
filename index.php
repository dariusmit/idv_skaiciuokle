<?php
   // IDV mokesciu skaiciuokle.
   error_reporting(0);
?>
<html>
   <body>
      <form action = "<?php $_PHP_SELF ?>" method = "GET">
	     <br />
		 <div style='margin: auto; width: 20%; border: 3px solid grey; padding: 40px;'>
		 Įveskite gautas pajamas:
		 <br />
		 <br />
		 <input type = "number" style="width: 20%;" name = "pajamos" step=".01"/>
         <br />
		 <br />
		 Pasirinkite atskaitymų metodą:
		 <br />
		 <br />
		 <input type="radio" id="30proc" name="islaidu_modelis" value="30PROC">
		 <label for="30proc">30% nuo pajamų</label><br>
		 <input type="radio" id="fakt" name="islaidu_modelis" value="FAKT">
		 <label for="fakt">Faktinės išlaidos</label>
	     <input type ="number" style="width: 20%" name = "islaidos" step=".01"/>
		 <br />
		 <br />
		 <input type = "submit" style="width: 100%; height: 50px;" value="Skaičiuoti"/>
		 </div>
		 <br /><br />
		 <?php 
			// Funkcija apskaiciuoti procentams i saskaitas, nes ta pati naudosim 2 kartus.	
			function procentai($lieka) {
				echo "<div style='margin: auto; width: 20%; border: 3px solid green; padding: 40px; padding-top: 20px;'>" . "<h2>" . 'Procentai sąskaitoms:' . "</h2>";
				echo 'Būtinos išlaidos 50%: '. round($lieka * 0.50, 2) . " eur" . "<br />" . "<br />";
				echo 'Ilgalaikis taupymas 10%: '. round($lieka * 0.1, 2) . " eur" . "<br />" . "<br />";
				echo 'Skoloms atiduoti 15%: '. round($lieka * 0.15, 2) . " eur" . "<br />" . "<br />";
				echo 'Pramogos 5%: '. round($lieka * 0.05, 2) . " eur" . "<br />" . "<br />";
				echo 'Sveikatai 5%: '. round($lieka * 0.05, 2) . " eur" . "<br />" . "<br />";
				echo 'Investavimas į verslą 5%: '. round($lieka * 0.05, 2) . " eur" . "<br />" . "<br />";
				echo 'Pinigų rezervas 10%: '. round($lieka * 0.1, 2) . " eur";
			}		
			if ($_GET["pajamos"]) { // Tikrinama ar ivestos pajamos.
				if ($_GET["islaidu_modelis"] == '30PROC') { // Tikrinama ar pasirinktas 30 proc. islaidu modelis.			
					$VSD = (($_GET["pajamos"] - ($_GET["pajamos"]*0.3)) - (($_GET["pajamos"] - ($_GET["pajamos"]*0.3)) * 0.1)) * 0.1552;				
					$GPM = ($_GET["pajamos"] - ($_GET["pajamos"] * 0.3)) * 0.05;
					echo "<div style='margin: auto; width: 20%; border: 3px solid green; padding: 40px; padding-top: 20px;'>" . "<h2>" . 'Mokesčiai: ' . "</h2>";
					echo 'Gautos pajamos: ' . $_GET["pajamos"] . " eur" . "<br />" . "<br />";					
					echo "<b>" . 'VSD: ' . round($VSD, 2) . " eur" . "<br />" . "<br />"; // Cia VSD2 galutinis.			
					echo 'GPM: ' . round($GPM, 2) . " eur" . "<br />" . "<br />";
					$viso = $VSD + $GPM;
					echo 'Viso: ' . round($viso, 2) . " eur" . "<br />" . "<br />";
					echo 'PSD/4: 16.13 eur' . "<br />" . "</b>" . "<br />";
					$lieka = $_GET["pajamos"] - $viso;
					echo 'Į rankas lieka (Neatėmus PSD 64.50 eur): ' . round($lieka, 2) . " eur" . "</div>" . "<br />" . "<br />";				
					procentai($lieka);				
					echo "</div>";	
				}
				if ($_GET["islaidu_modelis"] == 'FAKT') { // Tikrinama ar pasirinktas faktinis islaidu modelis.
					if ($_GET["islaidos"]) { // Tikrinama ar ivesta islaidu reiksme.
						$VSD = (($_GET["pajamos"] - $_GET["islaidos"]) - (($_GET["pajamos"] - $_GET["islaidos"]) * 0.1)) * 0.1552;
						$GPM = ($_GET["pajamos"] - $_GET["islaidos"]) * 0.05;
						echo "<div style='margin: auto; width: 20%; border: 3px solid green; padding: 40px; padding-top: 20px;'>" . "<h2>" . 'Mokesčiai: ' . "</h2>";
						echo 'Gautos pajamos: ' . $_GET["pajamos"] . " eur" . "<br />" . "<br />";
						echo 'Patirtos išlaidos: ' . $_GET["islaidos"] . " eur" . "<br />" . "<br />";
						echo "<b>" . 'VSD: ' . round($VSD, 2) . " eur" . "<br />" . "<br />";
						echo 'GPM: ' . round($GPM, 2) . " eur" . "<br />" . "<br />";
						$viso = $VSD + $GPM;
						echo 'Viso: ' . round($viso, 2) . " eur" . "<br />" . "<br />";
						echo 'PSD/4: 16.13 eur' . "<br />" . "</b>" . "<br />";
						$lieka = $_GET["pajamos"] - $viso - $_GET["islaidos"];
						echo 'Į rankas lieka (Neatėmus PSD 58.63 eur, bet atėmus patirtas išlaidas): ' . round($lieka, 2) . " eur" . "</div>" . "<br />" . "<br />";
						procentai($lieka);				
						echo "</div>";	
					} else {
						echo 'Įveskite patirtas išlaidas prieš spaudžiant skaičiuoti!';
					}
				}
				if ($_GET["islaidu_modelis"] == '') { // Tikrinama ar islaidu modelio reiksme isvis pasirinkta.
					echo 'Pasirinkite išlaidų modelį prieš spaudžiant skaičiuoti!';
				}
			} else { // Jeigu nera ivestos pajamos.
				echo 'Įveskite pajamas prieš spaudžiant skaičiuoti!';
			}
			// END			
		 ?>
      </form>
   </body>
</html>