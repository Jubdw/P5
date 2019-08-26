document.addEventListener('DOMContentLoaded', function() {
	window.onscroll = function(ev) {
		document.getElementById("b-Back").className = (window.pageYOffset > 100) ? "b-Visible" : "b-Hidden";
	};
	document.getElementById("b-Back").addEventListener('click', () => window.scrollTo({
		top: 0,
		behavior: 'smooth',
	}));
});