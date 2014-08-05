# This file should contain all the record creation needed to seed the database with its default values.
# The data can then be loaded with the rake db:seed (or created alongside the db with db:setup).
#
# Examples:
#
#   cities = City.create([{ name: 'Chicago' }, { name: 'Copenhagen' }])
#   Mayor.create(name: 'Emanuel', city: cities.first)

posts = [
  {title: 'Emanuel', body: 'this is body test', published: true},
  {title: 'Emanuel', body: 'this is body test', published: true},
  {title: 'Emanuel', body: 'this is body test', published: true},
  {title: 'Emanuel', body: 'this is body test', published: true},
  {title: 'Emanuel', body: 'this is body test', published: true}
  ]
Post.create(posts)

users = [
	{
		first_name: 'Tuong',
		last_name: 'Le',
		email: 'tuong.le@asnet.com.vn',
		password: 'guessit',
		user_type: 'patient'
	},
	{
		first_name: 'Tung',
		last_name: 'Phan',
		email: 'tungphan@asnet.com.vn',
		password: 'guessit',
		user_type: 'therapist'
	}
]
User.create(users)
