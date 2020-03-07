		var canvas = document.getElementById("plansa");                 // accesam plansa creata pe care vom desena fractalul Barnsley 
		var context = canvas.getContext("2d");                          
		var numar = 0;
		
		canvas.width = n;
		canvas.height = m;
		context.fillStyle = culoare_fundal;                     // setam culoarea de desenare la cea a fundalului ales pentru fractal
 		context.fillRect(0,0, n, m);                            // desenam fundalul fractalului
		 
		function Barnsley(x1, y1){                              // cream fractalul ca in sursa "Creeaza_Fractal.php"
			numar = Math.floor(Math.random()*101);
			var yy = parseInt(py*(-1)*zoom + 650 - centru_y);       // cream coordonatele la care vom desena pixelul din imagine    
			var xx = parseInt(px*zoom + 500 - centru_x);
			context.fillStyle = culoare_frunza;                      // setam culoarea de desenare la cea a frunzei
			context.fillRect(xx, yy, 1, 1);                          // desenam pixelul la coordonatele respective
			if(numar <= p1){										  // generam urmatorul punct din fractal			
				px = C[1][1]*x1 + C[1][2]*y1 + C[1][5];
				py = C[1][3]*x1 + C[1][4]*y1 + C[1][6];
			}
			else if(numar <= p1 + p2){
				px = C[2][1]*x1 + C[2][2]*y1 + C[2][5];
				py = C[2][3]*x1 + C[2][4]*y1 + C[2][6];
			}
			else if(numar <= p1 + p2 + p3){
				px = C[3][1]*x1 + C[3][2]*y1 + C[3][5];
				py = C[3][3]*x1 + C[3][4]*y1 + C[3][6];
			}
			else if(numar <= p1 + p2 + p3 + p4){
				px = C[4][1]*x1 + C[4][2]*y1 + C[4][5];
				py = C[4][3]*x1 + C[4][4]*y1 + C[4][6];
			}
		}
		function deseneaza(){                                        
			Barnsley(px, py);
		}
		function umbra(){                                      // cream umbra fractalului folosindu-ne de matricea M
			context.fillStyle = culoare_umbra;
			for(i = 0; i<n; i++){
				for(j = 0; j<m; j++){
					if(M[i][j] == 2){
						context.fillRect(i, j, 1, 1);
					}
				}
			}
		}
		
		for(i = 1; i<=numar_puncte; i++){							// la fiecare milisecunda vom desena un punct
			setInterval(deseneaza, 1);
		}
		setInterval(umbra, numar_puncte/1000);                      // dupa ce va fi generat fractalul, vom desena si umbra acestuia