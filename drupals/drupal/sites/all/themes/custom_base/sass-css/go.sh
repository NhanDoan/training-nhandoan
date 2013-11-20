#!/bin/sh
compass compile  .
cp stylesheets/footheme.css ../css/footheme.css
drush cc css-js

