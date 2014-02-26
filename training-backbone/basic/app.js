$(document).ready(function(argument) {
	
	// creating class TODO 
	var TODO = Backbone.Model.extend({
		
		// using default value
		defaults: {
			title: '',
			completed: false
		},

		// initialize method 
		initialize: function() {
			console.log("This is model has been initialize");
			this.on('change:title', function () {
				console.log('-Title value for this model have changed');
			});
		},

		setTitle: function (newTitle) {
			this.set({title: newTitle});
		}

	});
	// listing of change to your model
	var todo = new TODO();

	// using method set
	todo.set('title', 'Check what \'s logged.');
	todo.setTitle('Go fishning on Sunday');
	// using method get
	console.log('Title has changed: ' + todo.get('title'));
	
	todo.set({completed: true});
	console.log('Completed has changed' + todo.get('completed'));

	// validation
	var Person = Backbone.Model.extend({
		defaults: {
			completed: false
		},

		validate: function (argument) {
			if(argument.title === undefined	) {
				return "Remember to set a title for your todo";
			}
		},
		initialize: function () {
			console.log('This model has been initialized');
			this.on('invalid',function (model, error) {
				console.log(error);
			});
		}
	});

	var todoPro = new Person();
	todoPro.set('completed', true, {validate:true});
	console.log('completed: ' + todoPro.get('completed'));

	// creating a view basic
	var TodoView = Backbone.View.extend({
		tagName: 'li',
		id:'over_nav',
		className: 'nav',
		todoTemplate: _.template($("script#item-template").html()),
		event: {
			'dblclick lable': 'edit',
			'keypress .edit': 'updateOnEnter',
			'blur .edit' : 'close'
		},

		// render the titles of the todo item
		render: function () {
			this.$el.html(this.todoTemplate(this.model.toJSON()));
			this.input = this.$('.edit');
			return this;
		},

		//
		edit: function () {
			// body...
		},

		close: function () {
			// body...
		},

		updateOnEnter: function (argument) {
			// body...
		}
	});

	var todoView = new TodoView();

	//using setElement
	var button1 = $('<button></button');
	var button2 = $('<button></button');

	//define a new view
	var Views = Backbone.View.extend({
		events: {
			click: function (e) {
				console.log(view.el === e.target);
			}
		}
	});

	var  view = new Views({el: 'button1'});
	view.setElement(button2);
	button1.trigger('click');
	button2.trigger('click');

	// =================================
	// collections 
	// =================================
	var TodoCollection = Backbone.Collection.extend({
		model: TODO
	});

	var a = new TODO({title: "This is example a", id: 2 });
	var b = new TODO({title: "This is example b", id: 3});
	var c = new TODO({title: "This is example c", id: 4});

	var todos = new TodoCollection([a,b]);
	console.log('Collection size: ' + todos.length);
	
	// using add() to add model
	todos.add(c);
	console.log('Collection size when using add(): ' + todos.length);
	
	// using remove() to removed model
	todos.remove([a,b]);
	console.log('Collection size when using remove(): ' + todos.length);

	// retrieving models 
	var	todo2 = todos.get(4);
	var todoCid = todos.get(todo2.cid);
	console.log(todoCid === c);

	// listening for events
	// we can listen for add or removed event
	var listenCLT = new Backbone.Collection();

	listenCLT.on("add", function (todo) {
		console.log("I should" + todo.get("title") + "Have a done it before!" + (todo.get("completed") ? "Yeah!" : "No") );
	});

	listenCLT.add([
		{title: 'go to Jamaica', completed: true},
		{title: 'go to hehe', completed: false},
		{title: 'go to ;)', completed: true},
		]);

	// using once() method collection to only callback one time 
	// define an object with two counter
	var TodoCounter = {counterA: 0, counterB: 0};

	//mix in backbone events
	_.extend(TodoCounter, Backbone.Events);

	// increment counter a, trigger an event
	var incrA = function () {
		TodoCounter.counterA += 2;
	};

	var incrB = function () {
		TodoCounter.counterB += 1;
	};

	// use one rather than having to explicitly unbind our event listent
	TodoCounter.once('event', incrA);
	TodoCounter.once('event', incrB);

	TodoCounter.trigger('event');
	console.log(TodoCounter.counterA === 2);
	console.log(TodoCounter.counterB === 1);

	// resetting/ refreshing collection
	// using set() method take an array of models and performs the necessary add, remove, and change operation required to update the collection
	
	var TodoSet = new Backbone.Collection();

	TodoSet.add([
		{id: 1, title: 'go to Jamaica', completed: true},
		{id: 2, title: 'go to hehe', completed: false},
		{id: 3, title: 'go to ;)', completed: true}
	]);
	console.log('Collection Size when using Add: ' + TodoSet.length);

	TodoSet.on('add', function (model) {
		console.log('Add title: ' + model.get('title') );
	});

	TodoSet.on('remove', function (model) {
		console.log('Remove: ' + model.get('title'));
	});

	TodoSet.on('change:completed', function (model) {
		console.log('Changed completed: ' + model.get('title'));
	});

	TodoSet.set([
		{id: 1, title: 'go to Jamaica', completed: false},
		{id: 2, title: 'go to hehe', completed: false},
		{id: 4, title: 'go to New create)', completed: true}
	]);

	// using method reset() to simple replace the entire content of the conlection
	TodoSet.reset({title: 'Using reset method', completed: true});
	console.log('Collection Size when using reset: ' + TodoSet.length);

	// Underscore utility functions
	// take full advantage of its hard dependency on Underscore
	// using method forEach
	// iterate over collections
	var TodoWithUnderscore = new Backbone.Collection();

	var array_obj = [{id: 1, title: 'go to Jamaica', completed: false},
		{id: 2, title: 'go to hehe', completed: false},
		{id: 4, title: 'go to New create)', completed: true}];
	TodoWithUnderscore.add(array_obj);
	
	TodoWithUnderscore.forEach(function (model) {
		console.log(model.get('title'));
	});

	// sortBy 
	// sort a collection on specific attribute
	var sortByAlpha = TodoWithUnderscore.sortBy(function(todo) {
		return todo.get('title').toLowerCase();
	});

	sortByAlpha.forEach(function (model) {
		console.log(model.get('title'));
	});

	// map method
	// create a new collection by mapping each value in a list through a stransformation
	var count = 1;
	console.log(TodoWithUnderscore.map(function (model) {
		return count++ + ". " + model.get('title');
	}));

	// chainable API
	// return an object 
	var chainColl = new Backbone.Collection([
		{name: 'Nhan Doan', age: 24},
		{name: 'Nguyen Van A', age: 6},
		{name: 'Phan Thi B', age: 12}
		]);
	var filterNames = chainColl.chain()
	//start chain, return wrapper around collection's model
	.filter(function (item) {
		return item.get('age') > 10;
	})
	// return wrapper array executing 
	.map(function (item) {
		return item.get('name');
	}).value();
	console.log(filterNames);

	//======================
	// event and view
	// =====================
	var EventView = Backbone.View.extend({
		el: '#tag-div',

		// bind to Dom event using Events property
		events: {
			'click[type="checkbox"]': 'clicked'
		},

		initialize: function () {
			//bin to DOM event using jQuery
			this.$el.click(this.jQueryClicked);

			// bind to API event
			this.on('apiEvent', this.callback);

		},

		// this on views
		clicked: function (event) {
			console.log('Event handle for ' + this.outerHTML);
			this.trigger('apiEvent', event.type);
		},

		jQueryClicked: function (event) {
			console.log('jQuery handle for' + this.outerHTML);
		},

		callback: function (eventType) {
			console.log('Event type was ' + eventType);
		}
	});

	var eventView  = new EventView();

	//=======================
	// Router
	//=======================
	var TodoRouter = Backbone.Router.extend({
		routes: {
			"about" : "showAbout",
			"todo/:id": "getTodo",
			"search/:query" : "searchTodo",
			"*other" : "defautlRouter"
		},

		showAbout: function () {
			console.log("Show content page about");
		},

		getTodo: function (id) {
			console.log('Show id: ' + id);
		},

		searchTodo: function (query, page) {
			var page_number = page || 1;
			console.log('Page number:' + page_number + 'of query' + query);
		}
	});

	var myTodoRoutter = new TodoRouter();
	
	Backbone.history.start();		

	//=======================
	//	Backbone Syns API
	//=======================
	

});