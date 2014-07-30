#!/bin/bash

rm -rf ../backend/app/assets/images/
rm -rf ../backend/vendor/assets/fonts/

cp -R ../frontend/dist/images/ ../backend/app/assets/images/
cp -R ../frontend/dist/fonts/ ../backend/vendor/assets/fonts/
cp    ../frontend/app/bower_components/requirejs/require.js ../backend/app/assets/javascripts/
cp    ../frontend/dist/scripts/header.js ../backend/app/assets/javascripts/
cp    ../frontend/dist/scripts/body.js ../backend/app/assets/javascripts/
cp    ../frontend/app/bower_components/requirejs/require.js ../backend/vendor/assets/javascripts/
cp    ../frontend/dist/styles/bootstrap.css ../backend/app/assets/stylesheets/bootstrap.css
cp    ../frontend/dist/styles/theme.css ../backend/app/assets/stylesheets/theme.css.erb
