var application_root = __dirname,
	express = require('express'),
	path = require('path'),
	mongoose = require('mongoose');

var app = express();
app.configure(function () {
	app.use(express.bodyParser());
	app.use(express.methodOverride());
	app.use(app.router);
	app.use(express.static(path.join(application_root, 'book')));

	app.use(express.errorHandler({dumplExceptions: true, showStack: true}));

});

var port = 8002;



app.listen( port, function() {
	console.log( 'Express server listening on port %d in %s mode', port, app.settings.env );
});

//connect in database
mongoose.connect('mongodb://192.168.33.10/library_database');

// schemas
var Book = new mongoose.Schema({
	title: String,
	author: String,
	releaseDate: Date
});

//models
var BookModel = mongoose.model('Book', Book);
app.get('/api', function (request, reponse) {
	reponse.send('Library API is running');
});

app.get('/api/books', function (request, reponse) {
	return BookModel.find(function (err, books) {
		
		if(!err) {
			return reponse.send(books);
		} else {
			return console.log(err);
		}
	})	;
});

