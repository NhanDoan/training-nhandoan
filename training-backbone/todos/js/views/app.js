var app = app || {};

app.AppView = Backbone.View.extend({
  // bind to the existing skeleton of the app already present in the HTML
  el: "#todoapp",

  // template for the line of statistics at the bottom of the app
  statsTemplate: _.template( $('#stats-template').html() ),

  // events
  // delegateEvents for creating view new items, and clearing completed ones
  events : {
    'keypress #new-todo' : 'createOnEnter',
    'click #clear-completed': 'clearCompleted',
    'click #toggle-all': 'toggleAllCompleted'
  } ,

  // initialize
  initialize: function () {
    this.allCheckbox = this.$('#toggle-all')[0];
    this.$main = this.$('#main');
    this.$footer = this.$('#footer');
    this.$input = this.$('#new-todo');

    // listenTo events
    this.listenTo(app.Todos, 'add', this.addOne);
    this.listenTo(app.Todos, 'reset', this.addAll);
    this.listenTo(app.Todos, 'change: completedd', this.filterOne);
    this.listenTo(app.Todos, 'filter', this.filterAll);
    this.listenTo(app.Todos, 'all', this.render);

    app.Todos.fetch();
  },


  render: function () {
    var completed = app.Todos.completed().length;
    var remaining = app.Todos.remaining().length;

    if ( app.Todos.length ) {
      this.$main.show();
      this.$footer.show();

      this.$footer.html(this.statsTemplate({
        completed: completed,
        remaining: remaining
      }));

      this.$('#filters li a')
        .removeClass('selected')
        .filter('[href="#/' + ( app.TodoFilter || '' ) + '"]')
        .addClass('selected');

    } else {

      this.$main.hide();
      this.$footer.hide();
    }

    this.allCheckbox.checked = !remaining;
  },

  addOne: function(todo) {

    var view = new app.TodoView({model: todo});
    $('#todo-list').append(view.render().el);
  },

  addAll: function () {
    
    this.$('#todo-list').html('');
    app.Todos.each(this.addOne, this);
  },

  filterOne: function (todo) {
    todo.trigger('visible');
  },

  filterAll: function () {
    app.Todos.each(this.filterOne, this);
  },

  newAttributes: function () {
    return {
      title: this.$input.val().trim(),
      order: app.Todos.nextOrder(),
      completed: false
    };
  },

  createOnEnter: function (event) {

    if (event.which !== ENTER_KEY || this.$input.val().trim()) {
      return;
    }

    app.Todos.create(this.newAttributes());

    this.$input.val('');
  },

  clearCompleted: function () {
    _.invoke(app.Todos.completed(), 'destroy');
    return false;
  },

  toggleAllCompleted: function () {
    var completed = this.allCheckbox.checked;

    app.Todos.each(function (todo) {
      todo.save({
        'completed' : completed
      });
    });
  }

});