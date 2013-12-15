var locale = {
	de: {
		decimalPoint: ',',
		months: [
			'Januar',
			'Feburar',
			'März',
			'April',
			'Mai',
			'Juni',
			'Juli',
			'August',
			'September',
			'Oktober',
			'November',
			'Dezember',
		],
		shortMonths: [
			'Jan',
			'Feb',
			'Mär',
			'Apr',
			'Mai',
			'Jun',
			'Jul',
			'Aug',
			'Sep',
			'Okt',
			'Nov',
			'Dez',
		],
		thousandsSep: '.',
		weekdays: [
			'Sonntag',
			'Montag',
			'Dienstag',
			'Mittwoch',
			'Donnerstag',
			'Freitag',
			'Samstag'
		]
	},
	en: {
		decimalPoint: '.',
		months: [
			'January',
			'February',
			'March',
			'April',
			'May',
			'June',
			'July',
			'August',
			'September',
			'October',
			'November',
			'December'
		],
		shortMonths: [
			'Jan',
			'Feb',
			'Mar',
			'Apr',
			'May',
			'Jun',
			'Jul',
			'Aug',
			'Sep',
			'Oct',
			'Nov',
			'Dec'
		],
		thousandsSep: ',',
		weekdays: [
			'Sunday',
			'Monday',
			'Tuesday',
			'Wednesday',
			'Thursday',
			'Friday',
			'Saturday'
		]
	}
};

var App = {
	locale: 'de',
	getLocale: function(type) {
		if (typeof locale[this.locale][type] != 'undefined') {
			return locale[this.locale][type];
		} else {
			return locale['en'][type];
		}
	},
	getMonthNames: function() {
		return this.getLocale('months');
	},
	getShortMonthNames: function() {
		return this.getLocale('shortMonths');
	},
	getDecimalPoint: function() {
		return this.getLocale('decimalPoint');
	},
	getThousandsSep: function() {
		return this.getLocale('thousandsSep');
	},
	getWeekdays: function() {
		return this.getLocale('weekdays');
	},
};

var highchartsOptions = {
	credits: {
		enabled: false
	},
	colors: [
		'#A1CF64', // Green
		'#D95C5C', // Red
		'#6ECFF5', // Blue
		'#564F8A', // Purple
		'#F05940', // Orange
		'#00B5AD' // Teal
	],
	xAxis: {
		lineColor: '#dddddd'
	},
	yAxis: {
		gridLineColor: '#dddddd'
	},
	tooltip: {
		shadow: false
	}
};

Highcharts.setOptions({
	lang: {
		months: App.getMonthNames(),
		shortMonths: App.getShortMonthNames(),
		decimalPoint: App.getDecimalPoint(),
		thousandsSep: App.getThousandsSep(),
		weekdays: App.getWeekdays()
	}
});

$(function() {
	var $accountHistoryChart = $('#account-history-chart');

	if ($accountHistoryChart.length) {
		$.getJSON($accountHistoryChart.data('url'), function(json) {
			$accountHistoryChart.highcharts($.extend(true, {}, highchartsOptions,
				{
					chart: {
						zoomType: 'x',
						type: 'line'
					},
					legend: {
						enabled: false
					},
					title: {
						text: null
					},
					series: json,
					tooltip: {
						formatter: function() {
							return '<strong>' + this.series.name + '</strong><br>' +
								Highcharts.dateFormat('%B %Y', this.x) + ': ' + this.y + ' ' + $accountHistoryChart.data('currency');
						}
					},
					xAxis: {
						type: 'datetime',
						title: {
							text: null
						}
					},
					yAxis: {
						labels: {
							format: '{value} ' + $accountHistoryChart.data('currency')
						},
						title: {
							text: null
						}
					}
				}
			));
		});
	}
});