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
		<div id="tags"></div>
		<div>
		<button type="button">Start</button>
		</div>
		<canvas id="grid" width="500" height="500" />
		<script type="text/javascript">
		$(document).ready(function(){    
		var sizeInd = 5;
		var canvas = document.getElementById('grid');
		var ctx = canvas.getContext('2d');

		// how many cells fit on the canvas
		var w = ~~ (canvas.width / sizeInd);
		var h = ~~ (canvas.height / sizeInd);
		console.log(w+ " "+h);
		// array with status of the individual
		var state = new Array(h);
		console.log(state);
		for (var y = 0; y < h; ++y) {
		    state[y] = new Array(w);
		}
		var temp = state;
		// click event ro mark individuals
		$(canvas).click(function(e) {
		    function fill(color, cx, cy) {
		        ctx.fillStyle = color;
		        ctx.fillRect(cx * sizeInd, cy * sizeInd, sizeInd, sizeInd);
		    }
		    function howManyNeig(){

		    }
		    // get mouse click position
		    var mx = e.offsetX;
		    var my = e.offsetY;

		    // calculate grid square numbers
		    var gx = ~~ (mx / sizeInd);
		    var gy = ~~ (my / sizeInd);
		    $( "#tags" ).html(gx+" "+gy); 
		    // make sure we're in bounds
		    if (gx < 0 || gx >= w || gy < 0 || gy >= h) {
		        return;
		    }

		    if (state[gy][gx] == 1) {
		        // if pressed before, flash red
		            fill('#EEEEEE', gx, gy);
					state[gy][gx] = 0;

		    } else {
		        state[gy][gx] = 1;
		        fill('black', gx, gy);
		    }
		console.log(state);

		});
		});
		</script>
	</body>
</html>