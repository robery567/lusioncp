	<script>
		range.addEventListener('input', function(){
			document.querySelector('.pace').classList.remove('pace-inactive');
			document.querySelector('.pace').classList.add('pace-active');

			document.querySelector('.pace-progress').setAttribute('data-progress-text', range.value + '%');
			document.querySelector('.pace-progress').setAttribute('style', '-webkit-transform: translate3d(' + range.value + '%, 0px, 0px)');
			document.querySelector('.pace-progress').setAttribute('style', '-moz-transform: translate3d(' + range.value + '%, 0px, 0px)');
		});
	</script>
	<script src="https://code.jquery.com/jquery-1.11.1.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.1/js/bootstrap.min.js"></script>
	<script src="https://lusioncp.me/assets/js/plugins/metisMenu/metisMenu.min.js"></script>
	<script src="https://lusioncp.me/assets/js/plugins/morris/raphael.min.js"></script>
	<script src="https://lusioncp.me/assets/js/plugins/morris/morris.min.js"></script>
	<script src="https://lusioncp.me/assets/js/plugins/morris/morris-data.js"></script>
	<script src="https://lusioncp.me/assets/js/sb-admin-2.js"></script>
	<script src="https://lusioncp.me/assets/js/pace.min.js"></script> 