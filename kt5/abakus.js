window.onload = function() {
	var beads = document.querySelectorAll(".bead");
	console.log(beads)
	for (var i = 0; i < beads.length; i++) {
		console.log(beads[i].style.cssFloat);
		if (window.getComputedStyle(beads[i]).cssFloat=="left") {
			beads[i].style.cssFloat = "right";
			beads[i].innerHTML = i;
			beads[i].style.textAlign = "center"
		} else {
			beads[i].style.cssFloat = "left";
			beads[i].innerHTML = i;
			beads[i].style.textAlign = "center"
		}
	}
}