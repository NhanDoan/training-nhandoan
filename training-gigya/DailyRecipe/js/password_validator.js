/*
	Password Validator 0.1
	(c) 2007 Steven Levithan <stevenlevithan.com>
	MIT License
*/

var passwordError = "Password must be at least 6 characters and must include a letter and a digit.";

function validatePassword (pw, options) {
	// default password rules 
	var o = {
		lower:    0,  // Minimum n lowercase characters required (a–z).
		upper:    0,  // Minimum n uppercase characters required (A–Z).
		alpha:    1,  // Minimum n combined a–z and A–Z characters required.
		numeric:  1,  // Minimum n numeric characters required (0–9).
		special:  0,  // Minimum n special characters required (characters other than a–z, A–Z, and 0–9).
		length:   [5, Infinity], // Restriction on password length [min, max]
		custom:   [ /* regexes and/or functions */ ],
		badWords: ["password","badword"],  // Ban particular words (tested case-insensitively).
		badSequenceLength: 0,  // Ban n-length character sequences (e.g. "abc", "XYZ", or "789", with a sequence length of 3; does not apply to special characters).
		noQwertySequences: false,  // Ban n-length qwerty character sequences (e.g. "qwerty" or "asdf", with a sequence length of 4; does not apply to special characters).
		noSequential:      false  // Ban sequential, identical characters (e.g. "aa" or "!!").
	};

	for (var property in options)
		o[property] = options[property];

	var	re = {
			lower:   /[a-z]/g,
			upper:   /[A-Z]/g,
			alpha:   /[A-Z]/gi,
			numeric: /[0-9]/g,
			special: /[\W_]/g
		},
		rule, i;

	// enforce min/max length
	if (pw.length < o.length[0] || pw.length > o.length[1])
		return "Password is too Short";

	// enforce lower/upper/alpha/numeric/special rules
	for (rule in re) {
		if ((pw.match(re[rule]) || []).length < o[rule])
			{
				switch(rule)
				{
					case 'lower':
						return "Missing lower character";
					case 'upper':
						return "Missing upper character";
					case 'alpha':
						return "Missing alpha character";
					case 'numeric':
						return "Missing numeric character";
					case 'special':
						return "Missing special character";
					default:
						return "Missing lower/upper/alpha/numeric/special rules";
				}
			}
	}

	// enforce word ban (case insensitive)
	for (i = 0; i < o.badWords.length; i++) {
		if (pw.toLowerCase().indexOf(o.badWords[i].toLowerCase()) > -1)
			return "Not allowed to use specific words";
	}

	// enforce the no sequential, identical characters rule
	if (o.noSequential && /([\S\s])\1/.test(pw))
		return "Sequential Identical characters are not allowed";

	// enforce alphanumeric/qwerty sequence ban rules
	if (o.badSequenceLength) {
		var	lower   = "abcdefghijklmnopqrstuvwxyz",
			upper   = lower.toUpperCase(),
			numbers = "0123456789",
			qwerty  = "qwertyuiopasdfghjklzxcvbnm",
			start   = o.badSequenceLength - 1,
			seq     = "_" + pw.slice(0, start);
		for (i = start; i < pw.length; i++) {
			seq = seq.slice(1) + pw.charAt(i);
			if (
				lower.indexOf(seq)   > -1 ||
				upper.indexOf(seq)   > -1 ||
				numbers.indexOf(seq) > -1 ||
				(o.noQwertySequences && qwerty.indexOf(seq) > -1)
			) {
				return "Alphanumeric/qwerty sequence is not allowed ";
			}
		}
	}

	// enforce custom regex/function rules
	for (i = 0; i < o.custom.length; i++) {
		rule = o.custom[i];
		if (rule instanceof RegExp) {
			if (!rule.test(pw))
				return false;
		} else if (rule instanceof Function) {
			if (!rule(pw))
				return false;
		}
	}

	// great success!
	return "Perfect";
}
