out = ./dist
src = ./src
scss = $(src)/css/main.scss
css = $(src)/css/main.css
html = $(src)/php

default: build


build: bscss mv


bscss: $(scss)
	sass $^ $(css)

mv:
	cp -r $(html)/* $(out)
	mkdir -p $(out)/css
	mv $(css) $(out)/css
	rm -r /opt/lampp/htdocs/*
	cp -r -f $(out)/* /opt/lampp/htdocs/
