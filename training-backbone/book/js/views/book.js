var app = app || {};

app.BookView = Backbone.View.extend({
	events: {
		'click .delete' : 'deleteBook'
	},

	tagName: 'div',
	className: 'bookContainer',
	template: _.template( $('#bookTemplate').html() ),
	render: function () {

		this.$el.html(this.template(this.model.toJSON()));
		return this;
	},

	deleteBook: function () {
		this.model.destroy();

		this.remove();
	}
});