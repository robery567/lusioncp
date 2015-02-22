
$(function () {
	var countDay = new Date();
	countDay = new Date('october 20, 2015 00:01:00');
	$('#main-counter').countdown({until: countDay, 
	format: 'DHMS',
	layout: '<div id="counter">'+
							'<div id="time-values">'+
								'<div id="count_days" class="numbers">{dnnn}<p class="below-labels">{dl}</p></div>'+
								'<div id="count_hours" class="numbers">{hnn}<p class="below-labels">{hl}</p></div>'+
								'<div id="count_minutes" class="numbers">{mnn}<p class="below-labels">{ml}</p></div>'+
								'<div id="count_seconds" class="numbers">{snn}<p class="below-labels">{sl}</p></div>'+
							'</div>'+
						'</div>'});
	$('#year').text(countDay.getFullYear());
});




