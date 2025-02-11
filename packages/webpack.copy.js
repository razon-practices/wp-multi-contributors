const path = require("path");
const fs = require("fs");
const CopyWebpackPlugin = require("copy-webpack-plugin");
const WebpackShellPluginNext = require("webpack-shell-plugin-next");
const ZipPlugin = require("zip-webpack-plugin");

// Define the plugin slug
var pluginSlug = "wp-multi-contributors";

module.exports = {
	mode: "production",
	plugins: [
		new CopyWebpackPlugin({
			patterns: [
				{ from: "assets/css/**", to: "assets/css/[name][ext]" },
				// { from: "assets/js/**", to: "assets/js/[name][ext]" },
				{ from: "inc", to: "inc" },
				{ from: "languages", to: "languages" },
				{ from: "readme.txt", to: "readme.txt" },
				{ from: `${pluginSlug}.php`, to: `${pluginSlug}.php` },
			],
		}),
		new ZipPlugin({
			filename: `${pluginSlug}.zip`, // Set the name of the ZIP file
			path: path.resolve("dist"), // Ensure the ZIP is created in the dist directory
			pathPrefix: pluginSlug, // Maintain the internal folder structure
			exclude: [/main\.js$/], // Exclude main.js from the ZIP file
		}),
		new WebpackShellPluginNext({
			onBuildEnd: {
				scripts: [
					() => {
						const filePath = `dist/${pluginSlug}/main.js`;
						if (fs.existsSync(filePath)) {
							fs.unlinkSync(filePath);
							console.log(`${filePath} deleted.`);
						} else {
							console.log(`${filePath} does not exist.`);
						}
					},
				],
			},
		}),
	],
	output: {
		path: path.resolve(`dist/${pluginSlug}`),
		filename: "main.js", // Explicitly set the output filename
	},
};
