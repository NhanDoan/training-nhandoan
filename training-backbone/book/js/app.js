var app = app || {};

$(function () {
	var books = [
	{converImage: 'img/placeholder.png', title: '"JavaScript: The Good Parts"', author: 'Douglas Crockford',releaseDate: '2008', keywords: 'JavaScript Programming'},
	{converImage: 'img/placeholder.png', title: 'The Little Book on CoffeeScript', author: 'Alex MacCaw', releaseDate: '2012', keywords: 'CoffeeScript Programming'},
	{converImage: 'img/placeholder.png', title: 'Scala for the Impatient', author: 'Cay S. Horstmann',releaseDate: '2012', keywords: 'Scala Programming'},
	{converImage: 'img/placeholder.png', title: 'American Psycho', author: 'Bret Easton Ellis',releaseDate: '1991', keywords: 'Novel Splatter'},
	{converImage: 'img/placeholder.png', title: 'Eloquent JavaScript', author: 'Marijn Haverbeke',releaseDate: '2011', keywords: 'JavaScript Programming'}
	];

	new app.LibraryView(books);
});