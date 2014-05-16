
TodoMVC.module('Layout', function (Layout, App, Backbone, Marionette, $, _) {
	
	// Layout for Header View
	// ======================
	Layout.Header = Backbone.Marionette.ItemView.extend({
		template: '#template-header',

		ui: {
			input: '#new-todo'
		},

		events: {
			'keypress #new-todo': 'onInputKeypress',
			'blur #new-todo': 'onTodoBlur'
		},

		onTodoBlur: function () {
			var todoText = this.ui.input.val().trim();

			this.createTodo(todoText);
		},

		onInputKeypress: function (e) {
			var ENTER_KEY = 13;
			var todoText = this.ui.input.val().trim();

			if( e.which === ENTER_KEY && todoText) {
				this.createTodo(todoText);

			}

			
		},

		completeAdd : function () {
			this.ui.input.val('');
		},

		createTodo: function (todoText) {
			if(todoText.trim() === "") {return;}

			this.collection.create({
				title: todoText
			});

			this.completeAdd();
		}

	});

	// Layout for footer views
	// =======================

	Layout.Footer = Backbone.Marionette.Layout.extend({
		template: '#template-footer',

		// UI binding create cache attribute that point to jQuery selected object
		// 
		ui: {
			todoCount: '#todo-count .count',
			todoCountLable: '#todo-count .label',
			clearCount: '#clear-completed .count',
			filters: '#filters a'
		},

		events: {
			'click #clear-completed' : 'onClearClick'
		},

		initialize: function () {
			this.listenTo(App.vent, "todoList: filter", this.updateFilterSelection,this);
			this.listenTo(this.collection, 'all', this.updateCount, this);
		},

		onRender: function () {
			this.updateCount();
		},

		updateCount: function () {
			var activeCount = this.collection.getActive().length,
				completedCount = this.collection.getCompleted().length;

			this.ui.todoCount.html(activeCount);

			this.ui.todoCountLable.html(activeCount === 1 ? 'item' : 'items');

			this.ui.clearCount.html(completedCount === 1 ? '' : '(' + completedCount + ')' );
		},

		updateFilterSelection: function () {
			this.ui.filters.removeClass('selected').filter('[href="#/' + filter + '"]').addClass('selected');

		},

		onClearClick: function () {
			var completed = this.collection.getCompleted();

			completed.forEach(function destroy (todo) {
				todo.destroy();
			});
		}
	});
});