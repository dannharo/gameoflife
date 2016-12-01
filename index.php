<!DOCTYPE html>
<html>
	<head>
		<title>Game of life</title>
		<script src="lib/jquery-v1.8.3.js"></script>
		<style type="text/css">
			canvas{background-color: #EEEEEE;}
		</style>
	</head>
	<body>
		
		<div>
		<button id="btn-invert" type="button">Invert</button>
		<button id="btn-clear" type="button">Clear Grid</button>
		<button id="btn-start" type="button">Start</button>
		<button id="btn-stop" type="button" disabled="true">Stop</button>
		<button id="btn-step" type="button">Step</button>
		</div>
		<div id="tags">Position: X= 0,Y= 0</div>
		<canvas id="grid" width="500" height="500" />
		<script type="text/javascript">
		$(document).ready(function(){    
		var sizeInd = 5;
		var canvas = document.getElementById("grid");
		var ctx = canvas.getContext("2d");

		// how many cells fit on the canvas
		var w = ~~ (canvas.width / sizeInd);
		var h = ~~ (canvas.height / sizeInd);
		console.log(w+ " "+h);
		// array with status of the individual
		var state = new Array(h);
		var temp = new Array(h);
		console.log(state);
		for (var y = 0; y < h; ++y) {
		    state[y] = new Array(w);
		    temp[y] = new Array(w);
		}
		function start(){
		    window.idTimeout = setTimeout(function(){
		      theJudge();
		      start();
		    }, 500);
		}
		function stop(){
			clearTimeout(window.idTimeout);
		}
		function clearGrid(){
			ctx.clearRect(0,0,500,500);
				for (var y = 0; y < h; y++) {
					for (var x = 0; x < w; x++) {
						if(state[y][x] === 1){
						state[y][x] = 0;
						}
					}
				}
				arraySynch();

		}
		function theJudge(){
			var neighbors = 0;
			ctx.clearRect(0,0,500,500);
			for (var y = 0; y < h; y++) {
				for (var x = 0; x < w; x++) {
					neighbors = howManyNeig(x,y);
					if(temp[y][x] === 1){// is alive
						switch(neighbors){
							case 2:
								state[y][x] = 1;
								ctx.fillStyle = "#000000";
								ctx.fillRect(x*sizeInd, y*sizeInd, sizeInd,sizeInd);
								break;
							case 3:
								state[y][x] = 1;
								ctx.fillStyle = "#000000";
								ctx.fillRect(x*sizeInd, y*sizeInd, sizeInd,sizeInd);
								ctx.fillStyle = "#000000";
								break;
							default:
							state[y][x] = 0;
						}
					}
					else {
						switch(neighbors){
							case 3:
							state[y][x] = 1;
							ctx.fillStyle = "#000000";
							ctx.fillRect(x*sizeInd, y*sizeInd, sizeInd,sizeInd);
							break;
							default:
							state[y][x] = 0;
						}
					}
				}
			}
			arraySynch();
		}
		function arraySynch(){ //function to asign the data from state[] to temp[]
			for (var y = 0; y < h; y++) {
				for (var x = 0; x < w; x++) {
					temp[y][x] = state[y][x];
				}
			}
		}
		function changeStateOp(){ // change the state of all the individuals
			ctx.clearRect(0,0,500,500);
			for (var y = 0; y < h; y++) {
				for (var x = 0; x < w; x++) {
					console.log(state[y][x]);
					if(state[y][x] === 0 || !state[y][x]){
						state[y][x] = 1;
						ctx.fillStyle = "#000000";
						ctx.fillRect(x*sizeInd, y*sizeInd, sizeInd,sizeInd);
					}
					else{
						state[y][x] = 0;
					}
				}
			}
		}
		// how many individuals are around him
		function howManyNeig(x,y){
			var howMany = 0;
			if(y > 0){
				if(x>0){
		   			howMany += (temp[y-1][x-1] == null || temp[y-1][x-1] == 0)? 0 : 1; // up - left
				}
				if(x<w){	
		   			howMany += (temp[y-1][x+1] == null || temp[y-1][x+1] == 0)? 0 : 1; // up - right
				}
		   		howMany += (temp[y-1][x] == null || temp[y-1][x] == 0)? 0 : 1; // up
		   	}
		   	howMany += (temp[y][x-1] == null || temp[y][x-1] == 0)? 0 : 1;// left
		   	howMany += (temp[y][x+1] == null || temp[y][x+1] == 0)? 0 : 1;// right

		   	if(y < h -1){
				if(x>0){
			   		howMany += (temp[y+1][x-1] == null || temp[y+1][x-1] == 0)? 0 : 1; //dow - left
   				}
   				if(x<w){	
		   			howMany += (temp[y+1][x+1] == null || temp[y+1][x+1] == 0)? 0 : 1; // down - right
		   		}
		   		howMany += (temp[y+1][x] == null || temp[y+1][x] == 0)? 0 : 1; // down
		   	}
		   		return howMany;
		    }
		// click event ro mark individuals
		$(canvas).click(function(e) { // change status with click
		    function fill(color, cx, cy) { 
		        ctx.fillStyle = color;
		        ctx.fillRect(cx * sizeInd, cy * sizeInd, sizeInd, sizeInd);
		    }
		    // get click position
		    var mx = e.offsetX;
		    var my = e.offsetY;

		    // calculate grid square numbers
		    var gx = ~~ (mx / sizeInd);
		    var gy = ~~ (my / sizeInd);
		    $( "#tags" ).html("Position: X= "+gx+",Y= "+gy); 
		    // make sure we're in bounds
		    if (gx < 0 || gx >= w || gy < 0 || gy >= h) {
		        return;
		    }

		    if (state[gy][gx] === 1) {
		        // if pressed before, flash red
		            fill('#EEEEEE', gx, gy);
					state[gy][gx] = 0;

		    } else {
		        state[gy][gx] = 1;
		        fill('black', gx, gy);
		    }
		   	arraySynch();
		});
		
		$("#btn-invert").click(function(e){
			changeStateOp();
		});
		$("#btn-start").click(function(e){
			$("#btn-start").attr("disabled",true);
			$("#btn-stop").attr("disabled",false);
			console.log("Start with the Game of Life");
			start(1);
		});
		$("#btn-step").click(function(e){
			theJudge();
		});
		$("#btn-stop").click(function(e){
			$("#btn-stop").attr("disabled",true);			
			$("#btn-start").attr("disabled",false);
			stop();
		});
		$("#btn-clear").click(function(e){
			clearGrid();
		});
		});
		</script>
	</body>
</html>