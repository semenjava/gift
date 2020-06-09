class Dates {
	constructor() {
		this.dayInMonth = {
			1 : '31',
			2 : '28',
			3 : '31',
			4 : '30',
			5 : '31',
			6 : '30',
			7 : '31',
			8 : '31',
			9 : '30',
			10 : '31',
			11 : '30',
			12 : '31',
		}
	}

	updateDaySelector($dayInput, month) {
		$dayInput.html('');
		if (month) {
			var max = this.dayInMonth[month];
			$dayInput.append('<option value="">Select day ...</option>');
			for (var i = 1; i <= max; i++) {
				$dayInput.append('<option value="'+i+'">'+i+'</option>')
			}
			$dayInput.prop('disabled', false);
		} else {
			$dayInput.prop('disabled', true);
		}
	}

	initDayByMonth($monthInput, $dayInput, currentDay) {
		$(document).ready(() => {
			$monthInput.change(() => {
				this.updateDaySelector($dayInput, $monthInput.val());
			});

			if ($monthInput.val()) {
				this.updateDaySelector($dayInput, $monthInput.val());
				if (currentDay) {
					$dayInput.val(currentDay).trigger('change');
				}
			}
		});
	}
}
