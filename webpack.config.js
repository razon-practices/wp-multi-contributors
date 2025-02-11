const path = require("path");
const MiniCssExtractPlugin = require("mini-css-extract-plugin");
const IgnoreEmitPlugin = require("ignore-emit-webpack-plugin");

const isProduction = process.env.NODE_ENV === 'production';

var config = {
	watch: !isProduction,
	mode: isProduction ? "production" : "development",
};

const projectFiles = {
	// SCSS & JScript Compile lists
	scss: [
		{
			filename: "frontend",
			entry: ["./assets/src/scss/frontend.scss"],
			path: "assets/css",
		},
	],
	js: [
		// {
		// 	filename: "admin",
		// 	entry: ["./assets/src/js/admin.js"],
		// 	path: "assets/js",
		// },
		// {
		// 	filename: "frontend",
		// 	entry: ["./assets/src/js/frontend.js"],
		// 	path: "assets/js",
		// },
	],
};

let scssConfig = projectFiles.scss.map((item) =>
	Object.assign({}, config, {
		entry: {
			[item.filename]: item.entry,
		},
		output: {
			path: path.resolve(__dirname, item.path),
		},
		module: {
			rules: [
				{
					test: /\.scss$/,
					use: [
						MiniCssExtractPlugin.loader,
						"css-loader",
						"sass-loader",
					],
				},
			],
		},
		plugins: [
			new MiniCssExtractPlugin({
				filename: "[name].css",
				chunkFilename: "[id].css",
			}),
			new IgnoreEmitPlugin(/\.js$/), // in case of css, a new admn.js file is craeted, that's why we are ignoring here
		],
	})
);

let jsConfig = projectFiles.js.map((item) =>
	Object.assign({}, config, {
		entry: {
			[item.filename]: item.entry,
		},
		output: {
			path: path.resolve(__dirname, item.path),
			chunkFilename: "chunk/[name].chunk.js",
		},
		module: {
			rules: [
				{
					test: /\.m?(js|jsx)$/,
					exclude: /(node_modules)/,
					loader: "babel-loader",
				},
				{
					test: /\.css$/i,
					use: ["style-loader", "css-loader"],
				},
				{
					test: /\.(png|jpe?g|gif)$/i,
					loader: "file-loader",
					options: {
						name: "[path][name].[ext]",
					},
				},
			],
		},
		performance: { hints: false },
		optimization: {
			minimize: isProduction,
		},
		resolve: {
			fallback: { fs: false },

			fallback: {
				"react/jsx-runtime": "react/jsx-runtime.js",
				"react/jsx-dev-runtime": "react/jsx-dev-runtime.js",
			},
		},
		externals: {
			react: "React",
			"react-dom": "ReactDOM",
			antd: "antd",
			lodash: "_",
		},
	})
);

let configModule = [...scssConfig, ...jsConfig];

// Return Array of Configurations
module.exports = configModule;