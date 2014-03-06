$(document).ready(function () {
	var User = Backbone.Model.extend({
		// Regex patterns
		//================
		patterns: {
			specicalCharacter: '[^a-zA-Z0-9]',
			digits: '[0-9]',
			email: '^[a-zA-Z0-9._-]+@[a-zA-Z0-9][a-zA-Z0-9.-]*[.]{1}[a-zA-Z]{2,6}$'
		},

		validators: {
			minLength: function (value, minLenght) {
				return (value.length >= minLenght);
			},

			maxLength: function (value, maxLenght) {
				return (value.length <= maxLenght);
			},

			pattern: function(value, pattern) {
    
				return new RegExp(pattern, "gi").test(value) ? true : false;

			},
			isEmail: function (value) {
				return User.prototype.validators.pattern(value, User.prototype.patterns.email);
			},

			hasSpecialCharacter: function (value) {
				return User.prototype.validators.pattern(value, User.prototype.patterns.specicalCharacter);
			},

			hasDigits: function (value) {

				return User.prototype.validators.pattern(value, User.prototype.patterns.digits);
			},
		},

		validate: function (attrs) {
			var errors = this.errors = {};

                if(attrs.firstname != null) {
                      if (!attrs.firstname) errors.firstname = 'firstname is required';
                      else if(!this.validators.minLength(attrs.firstname, 2)) errors.firstname = 'firstname is too short';
                      else if(!this.validators.maxLength(attrs.firstname, 15)) errors.firstname = 'firstname is too large';
                      else if(this.validators.hasSpecialCharacter(attrs.firstname)) errors.firstname = 'firstname cannot contain special characters';
                  }
    
                  if(attrs.lastname != null) {
    
                      if (!attrs.lastname) errors.lastname = 'lastname is required';
                      else if(!this.validators.minLength(attrs.lastname, 2)) errors.lastname = 'lastname is too short';
                      else if(!this.validators.maxLength(attrs.lastname, 15)) errors.lastname = 'lastname is too large';
                      else if(this.validators.hasSpecialCharacter(attrs.lastname)) errors.lastname = 'lastname cannot contain special characters';  
    
                  }
    
                  if(attrs.password != null) {
    
                      if(!attrs.password) errors.password = 'password is required';
                      else if(!this.validators.minLength(attrs.password, 6)) errors.password = 'password is too short';
                      else if(!this.validators.maxLength(attrs.password, 15)) errors.password = 'password is too big';
                      else if(!this.validators.hasSpecialCharacter(attrs.password)) errors.password = 'password must contain a special character';
                      else if(!this.validators.hasDigit(attrs.password)) errors.password = 'password must contain a digit';
    
                  }           
                  
                  if(attrs.email != null) {
    
                      if (!attrs.email) errors.email = 'email is required';
                      else if(!this.validators.isEmail(attrs.email)) errors.email = 'email is not valid';
    
                  }
                
                  if(attrs.phone != null) {
    
                      if(!attrs.phone) errors.phone = 'phone is required';
                      else if(!this.validators.isPhone(attrs.phone)) errors.phone = 'phone number is invalid';
    
                  }
              
                  if (!_.isEmpty(errors)) return errors;
		},
	});

	var Field = Backbone.View.extend({
		events: {
			blur: 'validate'
		},

		initialize: function () {
			this.name = this.$el.attr('name');
			this.$msg = $('[data-msg=' + this.name + ']');
		},

		validate: function () {
			this.model.set(this.name, this.$el.val(), {validate: true});
			this.$msg.text(this.model.errors[this.name] || '');
		}
	});

	var user = new User();
	user.set({'firstname' : 'Greg'}, {validate: true, validateAll: false});
	$('input').each(function () {
		new Field({el: this, model:user});
	});

});