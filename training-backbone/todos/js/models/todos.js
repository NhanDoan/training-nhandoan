

$(document).ready(function () {

	var app = Backbone.Model.extend({
		
		// attribute default for each todo has title and completed
		defaults: {
			title: '',
			completed: false
		},

		toggle: function () {
			this.save({
				completed: !this.get('completed')
			});

		}

	});

});