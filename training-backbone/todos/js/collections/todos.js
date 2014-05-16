// $(document).ready(function () {
	var app = app || {};

	var TodoList = Backbone.Collection.extend({
		//reference to this collection's model
		model: app.Todo,

		//
		localStorage: new Backbone.LocalStorage('todos-backbone'),

		//filter down the list of all todo items that are finished
		completed: function () {
			return this.filter(function (todo) {
				return todo.get('completed');
			});
		},

		remaining: function () {
			return this.without.apply(this, this.completed());
		},

		nextOrder: function () {
			if(!this.length) {
				return 1;
			}

			return this.last().get('order') + 1;
		},

		comparator: function (todo) {
			return todo.get('order');
		}
	});

	//create our global collection of Todo
	app.Todos = new TodoList();
// });