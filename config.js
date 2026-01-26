module.exports = {
	config: {
		tailwindjs: "./tailwind.config.js"
	},
	paths: {
		root: "./",
		src: {
			base: "./src",
			css: "./src/scss",
			js: "./src/js",
			img: "./src/images",
			includes: "./src/includes",
			fonts: "./src/fonts",
			templates: "./src/templates"
		},
		dist: {
			base: "./dist",
			css: "./dist/css",
			js: "./dist/js",
			img: "./dist/images",
			includes: "./dist/includes",
			fonts: "./dist/fonts",
			templates: "./dist/templates"
		},
		build: {
			base: "./build",
			css: "./build/css",
			js: "./build/js",
			img: "./build/images",
			includes: "./build/includes",
			fonts: "./build/fonts",
			templates: "./build/templates"
		}
	}
}